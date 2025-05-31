<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PerpusExpress - @yield('title')</title>

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
    <style>
      /* Styling tambahan untuk navbar */
      .navbar-nav .nav-link {
        font-weight: 600;
        font-size: 1rem;
        color: #343a40;
        transition: color 0.3s ease;
      }
      .navbar-nav .nav-link.active,
      .navbar-nav .nav-link:hover {
        color: #0d6efd; /* warna biru bootstrap */
      }
      .btn-report {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: background-color 0.3s ease;
      }
      .btn-report:hover {
        background-color: #0b5ed7;
        color: white;
      }
      .user-avatar {
        width: 32px;
        height: 32px;
        object-fit: cover;
        border-radius: 50%;
      }
    </style>

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100" style="background-color: #f8f9fa;">
@if(!request()->routeIs('login') && !request()->routeIs('register'))
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
      <img
        src="{{ asset('img/logo.png') }}"
        alt="Logo"
        height="40"
        class="me-2"
      />
      <span class="fw-bold fs-4">PerpusExpress</span>
    </a>

    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto gap-4">
        <li class="nav-item">
          <a
            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            href="{{ route('dashboard') }}"
          >
            <i class="fas fa-home me-1"></i>Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}"
            href="{{ route('books.index') }}"
          >
            <i class="fas fa-book me-1"></i>Buku
          </a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link {{ request()->routeIs('borrowings.*') ? 'active' : '' }}"
            href="@if(Auth::check() && Auth::user()->role === 'user'){{ route('user.borrowings') }}@else{{ route('borrowings.index') }}@endif"
          >
            <i class="fas fa-hand-holding me-1"></i>Peminjaman
          </a>
        </li>
        {{-- Link Kategori hanya untuk Admin --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
        <li class="nav-item">
          <a
            class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
            href="{{ route('categories.index') }}"
          >
            <i class="fas fa-tags me-1"></i>Kategori
          </a>
        </li>
        @endif
      </ul>

      <ul class="navbar-nav ms-auto align-items-center gap-3">
        @auth
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle d-flex align-items-center gap-2"
            href="#"
            id="userDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <img
              src="{{ Auth::user()->profile_photo_url ?? asset('img/default-profile.png') }}"
              alt="User Avatar"
              class="user-avatar"
            />
            <span>{{ Auth::user()->nama_lengkap }}</span>
          </a>
          <ul
            class="dropdown-menu dropdown-menu-end shadow"
            aria-labelledby="userDropdown"
          >
            <li>
              <a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a>
            </li>
            <li><hr class="dropdown-divider" /></li>
            <li>
              <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
              </form>
            </li>
          </ul>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
@endif

<main class="py-4 @if(request()->routeIs('login') || request()->routeIs('register')) d-flex align-items-center justify-content-center @endif" style="padding-top: 3rem !important; padding-bottom: 3rem !important;">
  <div class="container">
    @if(session('success'))
    <div
      class="alert alert-success alert-dismissible fade show"
      role="alert"
    >
      {{ session('success') }}
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
      ></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
      ></button>
    </div>
    @endif

    @yield('content')
  </div>
</main>

<!-- Bootstrap Bundle with Popper -->
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>
@stack('scripts')
</body>
</html>
