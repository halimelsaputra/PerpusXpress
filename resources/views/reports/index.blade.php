@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Laporan</h1>
    <div>
        <button type="button" class="btn btn-success" onclick="window.print()">
            <i class="fas fa-print me-1"></i>Cetak
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter Laporan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.index') }}" method="GET">
                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis Laporan</label>
                        <select class="form-select" id="type" name="type" onchange="this.form.submit()">
                            <option value="borrowings" {{ request('type') === 'borrowings' ? 'selected' : '' }}>
                                Laporan Peminjaman
                            </option>
                            <option value="returns" {{ request('type') === 'returns' ? 'selected' : '' }}>
                                Laporan Pengembalian
                            </option>
                            <option value="fines" {{ request('type') === 'fines' ? 'selected' : '' }}>
                                Laporan Denda
                            </option>
                            <option value="books" {{ request('type') === 'books' ? 'selected' : '' }}>
                                Laporan Buku
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ request('start_date') }}">
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ request('end_date') }}">
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                @if(request('type') === 'borrowings')
                    <h5 class="card-title mb-4">Laporan Peminjaman</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Peminjam</th>
                                    <th>Buku</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($borrowings as $borrowing)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $borrowing->tanggal_pinjam->format('d/m/Y') }}</td>
                                        <td>{{ $borrowing->user->nama_lengkap }}</td>
                                        <td>{{ $borrowing->book->judul }}</td>
                                        <td>{{ $borrowing->book->category->nama_kategori }}</td>
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
                                        <td colspan="6" class="text-center">Tidak ada data peminjaman</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                @elseif(request('type') === 'returns')
                    <h5 class="card-title mb-4">Laporan Pengembalian</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Peminjam</th>
                                    <th>Buku</th>
                                    <th>Keterlambatan</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($returns as $return)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $return->tanggal_kembali->format('d/m/Y') }}</td>
                                        <td>{{ $return->user->nama_lengkap }}</td>
                                        <td>{{ $return->book->judul }}</td>
                                        <td>{{ $return->keterlambatan }} hari</td>
                                        <td>Rp {{ number_format($return->denda, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pengembalian</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                @elseif(request('type') === 'fines')
                    <h5 class="card-title mb-4">Laporan Denda</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Peminjam</th>
                                    <th>Buku</th>
                                    <th>Jumlah Denda</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fines as $fine)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $fine->tanggal_bayar->format('d/m/Y') }}</td>
                                        <td>{{ $fine->borrowing->user->nama_lengkap }}</td>
                                        <td>{{ $fine->borrowing->book->judul }}</td>
                                        <td>Rp {{ number_format($fine->jumlah_denda, 0, ',', '.') }}</td>
                                        <td>
                                            @if($fine->status === 'belum_lunas')
                                                <span class="badge bg-danger">Belum Lunas</span>
                                            @else
                                                <span class="badge bg-success">Lunas</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data denda</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                @elseif(request('type') === 'books')
                    <h5 class="card-title mb-4">Laporan Buku</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Dipinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($books as $book)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $book->judul }}</td>
                                        <td>{{ $book->penulis }}</td>
                                        <td>{{ $book->category->nama_kategori }}</td>
                                        <td>{{ $book->stok }}</td>
                                        <td>{{ $book->borrowings_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data buku</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="d-flex justify-content-end mt-3">
                    {{ ${request('type')}->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .navbar, .btn, .card-header, form {
            display: none !important;
        }
        .card {
            border: none !important;
        }
        .card-body {
            padding: 0 !important;
        }
    }
</style>
@endpush 