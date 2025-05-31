<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua reservasi dengan relasi user dan buku, urutkan berdasarkan tanggal reservasi terbaru
        $reservations = Reservation::with(['user', 'book'])->latest()->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Confirm the specified reservation.
     */
    public function confirm(Reservation $reservation)
    {
        // Pastikan status masih 'pending' sebelum dikonfirmasi
        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Reservasi tidak dapat dikonfirmasi karena statusnya bukan pending.');
        }

        $reservation->update(['status' => 'confirmed']);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservasi berhasil dikonfirmasi.');
    }

    /**
     * Cancel the specified reservation.
     */
    public function cancel(Reservation $reservation)
    {
         // Pastikan status bukan 'fulfilled' sebelum dibatalkan
        if ($reservation->status === 'fulfilled') {
            return back()->with('error', 'Reservasi tidak dapat dibatalkan karena sudah selesai.');
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => ['required', 'exists:books,id'],
        ]);

        // Pastikan user yang login adalah user biasa
        if (!Auth::check() || Auth::user()->role !== 'user') {
             return back()->with('error', 'Anda tidak memiliki izin untuk melakukan reservasi.');
        }

        $bookId = $request->input('book_id');
        $userId = Auth::id();

        // Cek apakah user sudah mereservasi buku ini sebelumnya dan statusnya masih pending atau confirmed
        $existingReservation = Reservation::where('user_id', $userId)
                                        ->where('book_id', $bookId)
                                        ->whereIn('status', ['pending', 'confirmed'])
                                        ->first();

        if ($existingReservation) {
            return back()->with('error', 'Anda sudah memiliki reservasi aktif untuk buku ini.');
        }

        // Cek apakah buku memang sedang tidak tersedia (stok 0)
        $book = \App\Models\Book::find($bookId);
        if (!$book || $book->stok > 0) {
             return back()->with('error', 'Buku tidak dapat direservasi saat stok masih tersedia.');
        }

        Reservation::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'reservation_date' => now(),
            'status' => 'pending', // Status awal reservasi adalah pending
        ]);

        // Redirect ke halaman detail buku dengan pesan sukses, atau ke halaman daftar reservasi user jika ada.
        return back()->with('success', 'Buku berhasil direservasi. Menunggu konfirmasi admin.');
    }

    /**
     * Display a listing of reservations for the authenticated user.
     */
    public function userReservations()
    {
        // Pastikan user yang login adalah user biasa
        if (!Auth::check() || Auth::user()->role !== 'user') {
             return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $userId = Auth::id();
        // Ambil reservasi user yang sedang login, dengan relasi buku, urutkan berdasarkan tanggal terbaru
        $reservations = Reservation::where('user_id', $userId)->with(['book'])->latest()->paginate(10);

        // Kita bisa menggunakan view yang sama dengan admin tapi menyesuaikan tampilan di Blade,
        // atau membuat view terpisah. Untuk sementara, kita buat view terpisah agar lebih jelas.
        return view('user.reservations', compact('reservations'));
    }

    // Metode lain seperti create, show, edit, update, destroy bisa ditambahkan jika dibutuhkan
    // Untuk admin, mungkin hanya perlu index, confirm, dan cancel.
}
