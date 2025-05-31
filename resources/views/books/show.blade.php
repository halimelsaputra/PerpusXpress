@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Detail Buku</h1>
    <div>
        <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $book->judul }}</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Kode Buku:</strong> {{ $book->isbn }}</p>
                        <p class="mb-1"><strong>Penulis:</strong> {{ $book->penulis }}</p>
                        <p class="mb-1"><strong>Penerbit:</strong> {{ $book->penerbit }}</p>
                        <p class="mb-1"><strong>Kategori:</strong> {{ $book->category->nama_kategori ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Tahun Terbit:</strong> {{ $book->tahun_terbit ?? '-' }}</p>
                        <p class="mb-1"><strong>Jumlah Halaman:</strong> {{ $book->jumlah_halaman ?? '-' }}</p>
                        <p class="mb-1"><strong>Stok:</strong> {{ $book->stok }}</p>
                        <p class="mb-1"><strong>Lokasi Rak:</strong> {{ $book->lokasi_rak ?? '-' }}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Deskripsi:</strong>
                    <p class="mt-2">{{ $book->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                </div>

                {{-- Tombol Reservasi untuk User Biasa jika stok 0 --}}
                @if(Auth::check() && Auth::user()->role === 'user' && $book->stok === 0)
                    <form action="{{ route('reservations.store') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin mereservasi buku ini?')">
                            <i class="fas fa-bookmark me-1"></i> Reservasi Buku Ini
                        </button>
                    </form>
                @endif

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Riwayat Peminjaman</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Peminjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($book->borrowings as $borrowing)
                                <tr>
                                    <td>{{ $borrowing->tanggal_pinjam->format('d/m/Y') }}</td>
                                    <td>{{ $borrowing->tanggal_kembali->format('d/m/Y') }}</td>
                                    <td>{{ $borrowing->user->nama_lengkap }}</td>
                                    <td>
                                        @if($borrowing->status === 'dipinjam')
                                            <span class="badge bg-warning">Dipinjam</span>
                                        @elseif($borrowing->status === 'dikembalikan')
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-danger">Terlambat</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada riwayat peminjaman</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Buku</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @forelse($book->bookStatus as $status)
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">
                                    @if($status->status === 'tersedia')
                                        <span class="badge bg-success">Tersedia</span>
                                    @elseif($status->status === 'dipinjam')
                                        <span class="badge bg-warning">Dipinjam</span>
                                    @elseif($status->status === 'rusak')
                                        <span class="badge bg-danger">Rusak</span>
                                    @else
                                        <span class="badge bg-dark">Hilang</span>
                                    @endif
                                </h6>
                                <small>{{ $status->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <p class="mb-1">{{ $status->keterangan }}</p>
                        </div>
                    @empty
                        <div class="list-group-item text-center">
                            Belum ada status buku
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 