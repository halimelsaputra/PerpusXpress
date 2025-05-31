@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Daftar Peminjaman</h1>
    {{-- Tombol Tambah Peminjaman dihapus karena admin tidak bisa meminjam --}}
    {{-- <a href="{{ route('borrowings.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Tambah Peminjaman
    </a> --}}
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $borrowing->user->nama_lengkap }}</td>
                            <td>{{ $borrowing->book->judul }}</td>
                            <td>{{ $borrowing->tanggal_pinjam->format('d/m/Y') }}</td>
                            <td>{{ $borrowing->tanggal_kembali->format('d/m/Y') }}</td>
                            <td>
                                @if($borrowing->status === 'dipinjam')
                                    <span class="badge bg-warning">Dipinjam</span>
                                @elseif($borrowing->status === 'dikembalikan')
                                    <span class="badge bg-success">Dikembalikan</span>
                                @else
                                    <span class="badge bg-danger">Terlambat</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($borrowing->status === 'dipinjam')
                                        <form action="{{ route('borrowings.extend', $borrowing) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-warning" 
                                                    onclick="return confirm('Apakah Anda yakin ingin memperpanjang pinjaman ini?')"
                                                    title="Perpanjang">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($borrowing->status === 'dipinjam')
                                        <form action="{{ route('borrowings.return', $borrowing) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success" 
                                                    onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')"
                                                    title="Kembalikan">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $borrowings->links() }}
        </div>
    </div>
</div>
@endsection 