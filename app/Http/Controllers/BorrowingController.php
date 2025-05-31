<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->paginate(10);
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $books = Book::where('stok', '>', 0)->get();
        return view('borrowings.create', compact('books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        $book = Book::findOrFail($validated['book_id']);
        
        if ($book->stok <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        $borrowing = Borrowing::create($validated);
        
        // Update book stock
        $book->decrement('stok');
        
        // Create book status
        $book->bookStatus()->create([
            'status' => 'dipinjam',
            'keterangan' => 'Dipinjam oleh ' . $borrowing->user->nama_lengkap
        ]);

        return redirect()->route('borrowings.index')
            ->with('success', 'Peminjaman berhasil dibuat.');
    }

    public function return(Borrowing $borrowing)
    {
        if ($borrowing->status === 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $today = Carbon::today();
        $tanggalKembali = Carbon::parse($borrowing->tanggal_kembali);
        
        $borrowing->update([
            'tanggal_pengembalian' => $today,
            'status' => 'dikembalikan'
        ]);

        // Update book stock
        $borrowing->book->increment('stok');
        
        // Update book status
        $borrowing->book->bookStatus()->create([
            'status' => 'tersedia',
            'keterangan' => 'Dikembalikan oleh ' . $borrowing->user->nama_lengkap
        ]);

        // Calculate fine if late
        if ($today->greaterThan($tanggalKembali)) {
            $daysLate = $today->diffInDays($tanggalKembali);
            $fineAmount = $daysLate * 1000; // Rp 1.000 per hari

            $borrowing->update(['denda' => $fineAmount]);
            
            Fine::create([
                'borrowing_id' => $borrowing->id,
                'jumlah_denda' => $fineAmount,
                'status_pembayaran' => 'belum_lunas'
            ]);
        }

        return redirect()->route('borrowings.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }

    /**
     * Extend the specified borrowing period.
     */
    public function extend(Borrowing $borrowing)
    {
        // Pastikan hanya pinjaman yang statusnya 'dipinjam' yang bisa diperpanjang
        if ($borrowing->status !== 'dipinjam') {
            return back()->with('error', 'Pinjaman tidak dapat diperpanjang karena statusnya bukan dipinjam.');
        }

        // Tentukan tanggal kembali baru (misal, perpanjang 7 hari dari tanggal kembali saat ini)
        $newTanggalKembali = Carbon::parse($borrowing->tanggal_kembali)->addDays(7);

        // Update tanggal kembali pada data peminjaman
        $borrowing->update([
            'tanggal_kembali' => $newTanggalKembali,
        ]);

        return redirect()->route('borrowings.index')
            ->with('success', 'Masa pinjam berhasil diperpanjang.');
    }

    public function show(Borrowing $borrowing)
    {
        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Display a listing of borrowings for the authenticated user.
     */
    public function userBorrowings()
    {
        // Pastikan user yang login adalah user biasa
        if (!Auth::check() || Auth::user()->role !== 'user') {
             return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $userId = Auth::id();
        // Ambil peminjaman user yang sedang login, dengan relasi buku, urutkan berdasarkan tanggal terbaru
        $borrowings = Borrowing::where('user_id', $userId)->with(['book'])->latest()->paginate(10);

        return view('user.borrowings', compact('borrowings'));
    }

    /**
     * Handle an incoming book borrowing request from a regular user.
     */
    public function storeForUser(Request $request): RedirectResponse
    {
        // Pastikan user yang login adalah user biasa
        if (!Auth::check() || Auth::user()->role !== 'user') {
             return redirect('/')->with('error', 'Anda tidak memiliki akses untuk melakukan peminjaman.');
        }

        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        // Cek stok buku
        if ($book->stok <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia untuk dipinjam.');
        }

        // Cek apakah user sudah meminjam buku ini dan statusnya masih dipinjam
        $existingBorrowing = Borrowing::where('user_id', Auth::id())
                                    ->where('book_id', $book->id)
                                    ->where('status', 'dipinjam')
                                    ->first();

        if ($existingBorrowing) {
            return back()->with('error', 'Anda masih memiliki pinjaman buku ini yang belum dikembalikan.');
        }

        // Tentukan tanggal pinjam dan tanggal kembali (misal, 7 hari)
        $tanggalPinjam = Carbon::today();
        $tanggalKembali = $tanggalPinjam->copy()->addDays(7);

        // Buat data peminjaman baru
        $borrowing = Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $tanggalKembali,
            'status' => 'dipinjam',
        ]);

        // Update book stock
        $book->decrement('stok');

        // Create book status (optional, based on application flow)
        // $book->bookStatus()->create([
        //     'status' => 'dipinjam',
        //     'keterangan' => 'Dipinjam oleh ' . Auth::user()->nama_lengkap
        // ]);

        return redirect()->route('user.borrowings')
            ->with('success', 'Buku berhasil dipinjam. Silakan ambil buku di perpustakaan.');
    }
} 