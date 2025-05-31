@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Tambah Peminjaman</h1>
    <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('borrowings.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Peminjam</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" 
                                id="user_id" name="user_id" required>
                            <option value="">Pilih Peminjam</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->nama_lengkap }} ({{ $user->username }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="book_id" class="form-label">Buku</label>
                        <select class="form-select @error('book_id') is-invalid @enderror" 
                                id="book_id" name="book_id" required>
                            <option value="">Pilih Buku</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" 
                                    {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->judul }} (Stok: {{ $book->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                               id="tanggal_pinjam" name="tanggal_pinjam" 
                               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                        @error('tanggal_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                               id="tanggal_kembali" name="tanggal_kembali" 
                               value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}" required>
                        @error('tanggal_kembali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Set minimum date for tanggal_kembali to be after tanggal_pinjam
    document.getElementById('tanggal_pinjam').addEventListener('change', function() {
        document.getElementById('tanggal_kembali').min = this.value;
    });
</script>
@endpush 