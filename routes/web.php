<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserFineController;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\User;

// Mengarahkan rute utama '/' ke dashboard jika authenticated, atau ke login jika tidak.
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $totalBooks = Book::count();
        $borrowedBooks = Borrowing::where('status', 'dipinjam')->count();
        $activeBorrowers = Borrowing::where('status', 'dipinjam')->distinct('user_id')->count();
        $totalFines = Fine::where('status_pembayaran', 'belum_lunas')->count();

        $recentBorrowings = Borrowing::with(['user', 'book'])->latest()->limit(5)->get();

        $popularBooks = [];

        return view('dashboard', compact('totalBooks', 'borrowedBooks', 'activeBorrowers', 'totalFines', 'recentBorrowings', 'popularBooks'));
    })->name('dashboard');

    // Route untuk dashboard user biasa
    Route::get('/user/dashboard', function () {
        // Ambil data yang relevan untuk user biasa
        // Untuk saat ini, kita bisa kirim data minimal atau data yang sama dengan dashboard admin jika view dashboard akan dihandle logikanya di Blade
        $totalBooks = Book::count(); // Contoh ambil data yang sama
        $recentBorrowings = Auth::user()->borrowings()->with('book')->latest()->limit(5)->get(); // Contoh ambil peminjaman user yang login

        return view('dashboard', compact('totalBooks', 'recentBorrowings')); // Kirim data ke view dashboard
    })->name('user.dashboard');

    // Books routes
    Route::resource('books', BookController::class);

    // Borrowings routes
    Route::resource('borrowings', BorrowingController::class);
    Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'return'])->name('borrowings.return');
    Route::post('borrowings/{borrowing}/extend', [BorrowingController::class, 'extend'])->name('borrowings.extend');

    // Categories routes
    Route::resource('categories', CategoryController::class);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route for updating user password
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Users routes (untuk admin mengelola user)
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // Reservations routes (untuk admin mengelola reservasi)
    Route::resource('reservations', ReservationController::class)->only(['index']);
    Route::post('reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
    Route::post('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

    // Route untuk daftar reservasi user biasa
    Route::get('/my-reservations', [ReservationController::class, 'userReservations'])->name('user.reservations');
    Route::post('/my-reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('user.reservations.cancel');

    // Route untuk daftar peminjaman user biasa
    Route::get('/my-borrowings', [BorrowingController::class, 'userBorrowings'])->name('user.borrowings');
    // Route untuk menyimpan peminjaman oleh user biasa
    Route::post('/my-borrowings', [BorrowingController::class, 'storeForUser'])->name('user.borrowings.store');
});

require __DIR__.'/auth.php';
