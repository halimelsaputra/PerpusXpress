@extends('layouts.app')

@section('title', 'Daftar Reservasi Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Daftar Reservasi Saya</h1>
    {{-- Tombol kembali atau navigasi lain jika diperlukan --}}
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Tanggal Reservasi</th>
                        <th>Status</th>
                        <th>Aksi (jika ada)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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
                                {{-- Tombol aksi user (misal batal reservasi pending/confirmed) bisa ditambahkan di sini --}}
                                @if(in_array($reservation->status, ['pending', 'confirmed']))
                                    <form action="{{ route('user.reservations.cancel', $reservation) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')" title="Batal Reservasi">
                                            <i class="fas fa-times"></i> Batal
                                        </button>
                                    </form>
                                @endif
                             </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Anda belum memiliki reservasi buku</td>
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