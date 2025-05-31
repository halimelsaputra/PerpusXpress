@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@if(Auth::user()->role === 'admin')
<div class="row mb-4 g-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary shadow-sm rounded-4">
            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title fw-semibold">Total Buku</h6>
                    <h2 class="display-5 fw-bold mb-0">{{ $totalBooks }}</h2>
                </div>
                <i class="fas fa-book fa-3x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success shadow-sm rounded-4">
            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title fw-semibold">Buku Dipinjam</h6>
                    <h2 class="display-5 fw-bold mb-0">{{ $borrowedBooks }}</h2>
                </div>
                <i class="fas fa-hand-holding fa-3x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning shadow-sm rounded-4">
            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="card-title fw-semibold">Peminjam Aktif</h6>
                    <h2 class="display-5 fw-bold mb-0">{{ $activeBorrowers }}</h2>
                </div>
                <i class="fas fa-users fa-3x opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card shadow-sm rounded-4 mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 fw-semibold">Peminjaman Terbaru</h5>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Peminjam</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBorrowings as $borrowing)
                                <tr>
                                    <td class="fw-medium">{{ $borrowing->user->nama_lengkap }}</td>
                                    <td>{{ $borrowing->book->judul }}</td>
                                    <td>{{ $borrowing->tanggal_pinjam->format('d/m/Y') }}</td>
                                    <td>
                                        @if($borrowing->status === 'dipinjam')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @elseif($borrowing->status === 'dikembalikan')
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-danger">Terlambat</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted fst-italic">Tidak ada data peminjaman</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
{{-- Tampilan untuk user biasa --}}
<div class="row mb-4">
     <div class="col-md-12">
         <div class="alert alert-info shadow-sm rounded-3 mb-4" role="alert">
             <i class="fas fa-info-circle me-2"></i>Selamat datang di dashboard pengguna, <strong>{{ Auth::user()->nama_lengkap }}</strong>!
         </div>
     </div>
</div>

{{-- Bagian peminjaman terbaru bisa ditampilkan untuk user biasa --}}
<div class="row g-4">
    <div class="col-md-8">
        <div class="card shadow-sm rounded-4 mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 fw-semibold">Peminjaman Terbaru</h5>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Peminjam</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBorrowings as $borrowing)
                                <tr>
                                    <td class="fw-medium">{{ $borrowing->user->nama_lengkap }}</td>
                                    <td>{{ $borrowing->book->judul }}</td>
                                    <td>{{ $borrowing->tanggal_pinjam->format('d/m/Y') }}</td>
                                    <td>
                                        @if($borrowing->status === 'dipinjam')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @elseif($borrowing->status === 'dikembalikan')
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-danger">Terlambat</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted fst-italic">Tidak ada data peminjaman</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
