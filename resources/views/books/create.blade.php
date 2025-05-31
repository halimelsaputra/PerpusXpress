@extends('layouts.app')

@section('title', 'Tambah Buku Baru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-primary fw-bold">Tambah Buku Baru</h1>
    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Buku
    </a>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('books.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="judul" class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror shadow-sm" id="judul" name="judul" value="{{ old('judul') }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="form-text">Masukkan judul buku secara lengkap</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="isbn" class="form-label fw-semibold">Kode Buku <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('isbn') is-invalid @enderror shadow-sm" id="isbn" name="isbn" value="{{ old('isbn') }}" required>
                    @error('isbn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="form-text">Masukkan Kode Buku</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="penulis" class="form-label fw-semibold">Penulis <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('penulis') is-invalid @enderror shadow-sm" id="penulis" name="penulis" value="{{ old('penulis') }}" required>
                    @error('penulis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="form-text">Nama lengkap penulis</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="penerbit" class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('penerbit') is-invalid @enderror shadow-sm" id="penerbit" name="penerbit" value="{{ old('penerbit') }}" required>
                    @error('penerbit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="form-text">Penerbit buku</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="tahun_terbit" class="form-label fw-semibold">Tahun Terbit <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror shadow-sm" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required min="1000" max="{{ date('Y') }}">
                    @error('tahun_terbit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="form-text">Tahun terbit buku (contoh: 2023)</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="category_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select class="form-select @error('category_id') is-invalid @enderror shadow-sm" id="category_id" name="category_id" required>
                        <option value="" selected>-- Pilih Kategori --</option>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="form-text">Pilih kategori buku</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="stok" class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('stok') is-invalid @enderror shadow-sm" id="stok" name="stok" value="{{ old('stok', 1) }}" required min="0">
                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="form-text">Jumlah stok buku tersedia</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="lokasi_rak" class="form-label fw-semibold">Lokasi Rak</label>
                    <input type="text" class="form-control @error('lokasi_rak') is-invalid @enderror shadow-sm" id="lokasi_rak" name="lokasi_rak" value="{{ old('lokasi_rak') }}">
                    @error('lokasi_rak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="form-text">Contoh: Rak A1, Lantai 2</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                    <i class="fas fa-save me-2"></i> Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Bootstrap 5 form validation example
(() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>
@endsection
