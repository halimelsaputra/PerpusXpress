@extends('layouts.app')

@section('title', 'Manajemen Reservasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Manajemen Reservasi</h1>
    {{-- Tombol tambah reservasi? Mungkin reservasi dibuat oleh user biasa --}}
    {{-- <a href="{{ route('reservations.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Tambah Reservasi
    </a> --}}
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Buku</th>
                        <th>Tanggal Reservasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reservation->user->nama_lengkap }}</td>
                            <td>{{ $reservation->book->judul }}</td>
                            <td>{{ $reservation->reservation_date->format('d/m/Y') }}</td>
                            <td>
                                @if($reservation->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($reservation->status === 'confirmed')
                                    <span class="badge bg-primary">Dikonfirmasi</span>
                                @elseif($reservation->status === 'cancelled')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @else {{-- fulfilled --}}
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    {{-- Tombol konfirmasi hanya jika status pending --}}
                                    @if($reservation->status === 'pending')
                                        <form action="{{ route('reservations.confirm', $reservation) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin mengkonfirmasi reservasi ini?')" title="Konfirmasi">
                                                <i class="fas fa-check"></i> Konfirmasi
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol batal jika status bukan fulfilled --}}
                                     @if($reservation->status !== 'fulfilled')
                                        <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')" title="Batal">
                                                <i class="fas fa-times"></i> Batal
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data reservasi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection 