@extends('layouts.app')

@section('title', 'Daftar Denda Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Daftar Denda Saya</h1>
    <a href="{{ route('profile.edit') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali ke Profil
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Tanggal Keterlambatan</th>
                        <th>Jumlah Denda</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fines as $fine)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $fine->borrowing->book->judul }}</td>
                            <td>{{ $fine->borrowing->tanggal_kembali->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($fine->jumlah_denda, 0, ',', '.') }}</td>
                            <td>
                                @if($fine->status_pembayaran === 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Belum Lunas</span>
                                @endif
                            </td>
                            <td>
                                @if($fine->status_pembayaran === 'belum_lunas')
                                    <form action="{{ route('user.fines.pay', $fine) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm" 
                                                onclick="return confirm('Apakah Anda yakin ingin membayar denda ini?')"
                                                title="Bayar Denda">
                                            <i class="fas fa-money-bill-wave"></i> Bayar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Anda tidak memiliki denda</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $fines->links() }}
        </div>
    </div>
</div>
@endsection 