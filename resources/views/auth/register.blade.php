@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4 rounded-4" style="max-width: 420px; width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Register</h3>
            <p>Create your account</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label text-white fw-semibold">Username</label>
                <input 
                    id="username" 
                    type="text" 
                    class="form-control @error('username') is-invalid @enderror" 
                    name="username" 
                    value="{{ old('username') }}" 
                    required autocomplete="username" autofocus
                    style="background-color: rgba(255,255,255,0.9); border:none;"
                >
                @error('username')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label text-white fw-semibold">Full Name</label>
                <input 
                    id="nama_lengkap" 
                    type="text" 
                    class="form-control @error('nama_lengkap') is-invalid @enderror" 
                    name="nama_lengkap" 
                    value="{{ old('nama_lengkap') }}" 
                    required autocomplete="name"
                    style="background-color: rgba(255,255,255,0.9); border:none;"
                >
                @error('nama_lengkap')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-white fw-semibold">Email Address</label>
                <input 
                    id="email" 
                    type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required autocomplete="email"
                    style="background-color: rgba(255,255,255,0.9); border:none;"
                >
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-white fw-semibold">Password</label>
                <input 
                    id="password" 
                    type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    name="password" 
                    required autocomplete="new-password"
                    style="background-color: rgba(255,255,255,0.9); border:none;"
                >
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label text-white fw-semibold">Confirm Password</label>
                <input 
                    id="password-confirm" 
                    type="password" 
                    class="form-control" 
                    name="password_confirmation" 
                    required autocomplete="new-password"
                    style="background-color: rgba(255,255,255,0.9); border:none;"
                >
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-light fw-semibold" style="background: white; color: #764ba2; transition: background-color 0.3s ease;">
                    Register
                </button>
            </div>

            <div class="text-center">
                <a class="text-white fw-semibold" href="{{ route('login') }}">
                    Already have an account? Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
