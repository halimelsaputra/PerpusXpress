@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4 rounded-4" style="max-width: 420px; width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Login</h3>
            <p>Welcome back! Please login to your account.</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label text-white fw-semibold">Email Address</label>
                <input 
                    id="email" 
                    type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required autocomplete="email" autofocus
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
                    required autocomplete="current-password"
                    style="background-color: rgba(255,255,255,0.9); border:none;"
                >
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3 form-check text-white">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-light fw-semibold" style="background: white; color: #764ba2; transition: background-color 0.3s ease;">
                    Login
                </button>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center mb-2">
                    <a class="text-white text-opacity-75" href="{{ route('password.request') }}" style="text-decoration: underline;">
                        Forgot Your Password?
                    </a>
                </div>
            @endif

            @if (Route::has('register'))
                <div class="text-center">
                    <a class="text-white fw-semibold" href="{{ route('register') }}">
                        Don't have an account? Register
                    </a>
                </div>
            @endif

        </form>
    </div>
</div>
@endsection
