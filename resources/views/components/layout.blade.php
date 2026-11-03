<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - Chirper' : 'Chirper' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-vh-100 d-flex flex-column bg-body-tertiary">
    <nav class="navbar bg-white border-bottom">
        <div class="container">
            <a href="/" class="navbar-brand fw-semibold">🐦 Chirper</a>
            <div class="d-flex align-items-center gap-2 ms-auto">
                @auth
                    <span class="small text-secondary">{{ auth()->user()->name }}</span>
                    <form method="POST" action="/logout" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Logout</button>
                    </form>
                @else
                    <a href="/login" class="btn btn-outline-secondary btn-sm">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    @if (session('success'))
        <div class="position-fixed top-0 start-50 translate-middle-x p-3 z-3" aria-live="polite" aria-atomic="true">
            <div class="alert alert-success shadow animate-fade-out" role="status">
                <svg xmlns="http://www.w3.org/2000/svg" class="me-2 flex-shrink-0" width="24" height="24" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <main class="container flex-grow-1 py-4">
        {{ $slot }}
    </main>

    <footer class="bg-dark text-white text-center py-3 small">
        <p class="mb-0">© {{ date('Y') }} Chirper - Built with Laravel and ❤️</p>
    </footer>
</body>

</html>
