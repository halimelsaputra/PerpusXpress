@extends('layouts.app')

@section('title', 'Daftar Peminjaman Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Daftar Peminjaman Saya</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Anda belum memiliki riwayat peminjaman</td>
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