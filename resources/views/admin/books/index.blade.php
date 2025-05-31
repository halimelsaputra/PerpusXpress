@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Daftar Buku</h1>
    <a href="{{ route('books.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Tambah Buku
    </a>
</div>

{{-- Form Pencarian --}}
<div class="card mb-4">
    <div class="card-body p-4">
        <form action="{{ route('books.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label for="keyword" class="form-label">Cari Buku</label>
                <input type="text" class="form-control" id="keyword" name="keyword" value="{{ request('keyword') }}" placeholder="Judul, Penulis, Penerbit, Kategori...">
            </div>
            <div class="col-md- auto">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search me-1"></i> Cari</button>
                 @if(request('keyword'))
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Lokasi Rak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $book->judul }}</td>
                            <td>{{ $book->penulis }}</td>
                            <td>{{ $book->penerbit }}</td>
                            <td>{{ $book->tahun_terbit }}</td>
                            <td>{{ $book->category->nama_kategori ?? '-' }}</td>
                            <td>{{ $book->stok }}</td>
                            <td>{{ $book->lokasi_rak ?? '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm gap-1">
                                    <a href="{{ route('books.show', $book) }}" class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('books.edit', $book) }}" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data buku</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection 