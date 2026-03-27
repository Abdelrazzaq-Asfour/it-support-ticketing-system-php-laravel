<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Support System | Eng. Abdelrazzaq Asfour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('v.png') }}">.
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; min-height: 100vh; display: flex; flex-direction: column; }
        .navbar { background-color: #1e293b; padding: 0.8rem 1rem; }
        .navbar-brand { font-size: 1.25rem; letter-spacing: 1px; }
        .footer { background-color: #1e293b; color: #cbd5e1; padding: 1.5rem 0; margin-top: auto; }
        .btn-primary { background-color: #3b82f6; border: none; }
        .btn-primary:hover { background-color: #2563eb; }
        .nav-link { font-weight: 500; }
        /* تنسيق إضافي للروابط النشطة */
        .nav-link:hover { color: #3b82f6 !important; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ auth()->check() ? route('tickets.index') : url('/') }}">
                <i class="bi bi-cpu"></i> SUPPORT PORTAL
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    @auth
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('tickets.index') }}">
                                <i class="bi bi-list-task"></i> My Tickets
                            </a>
                        </li>
@auth
    @if(auth()->user()->email === 'aboodasfour@gmail.com')
        <li class="nav-item">
            <a class="nav-link fw-bold text-warning px-3" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item border-start border-secondary ps-2">
            <a class="nav-link fw-bold text-info px-3" href="{{ route('staff.index') }}">
                <i class="bi bi-people-fill"></i> Staff Admin
            </a>
        </li>
    @endif
@endauth

                        <li class="nav-item">
                            <a class="nav-link btn btn-primary btn-sm text-white ms-lg-3 px-3 shadow-sm" href="{{ route('tickets.create') }}">
                                + Open New Ticket
                            </a>
                        </li>

                        <li class="nav-item ms-lg-4 text-white-50 small d-none d-lg-block">
                            | Hello, <strong>{{ auth()->user()->name }}</strong>
                            @if(auth()->user()->is_admin) <span class="badge bg-danger ms-1" style="font-size: 9px;">ADMIN</span> @endif
                        </li>

                        <a class="nav-link fw-bold " href="{{ route('profile.edit') }}">
    <i class="bi bi-person-circle"></i> Profile
</a>

                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-link nav-link text-danger fw-bold ms-lg-2" type="submit">Logout</button>
                            </form>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light btn-sm ms-lg-3 px-4" href="{{ route('register') }}">Register</a>
                        </li>
                    @endguest

                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container text-center">
            <p class="mb-1 fw-semibold">IT Support Ticketing System</p>
            <small class="text-white-50">
                Designed & Developed by <strong>Eng. Abdelrazzaq Asfour</strong> &copy; {{ date('Y') }}
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>