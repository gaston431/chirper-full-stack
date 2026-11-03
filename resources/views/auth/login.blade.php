<x-layout>
    <x-slot:title>
        Sign In
    </x-slot:title>

    <div class="auth-page d-flex align-items-center justify-content-center">
        <div class="card auth-card w-100 shadow-sm">
            <div class="card-body p-4">
                <h1 class="fs-2 fw-bold text-center mb-4">Welcome Back</h1>

                <form method="POST" action="/login">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="email"
                               name="email"
                               id="email"
                               placeholder="name@example.com"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               required
                               autofocus>
                        <label for="email">Email</label>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password"
                               name="password"
                               id="password"
                               placeholder="Password"
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        <label for="password">Password</label>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mt-3">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100 mt-4">Sign In</button>
                </form>

                <div class="d-flex align-items-center my-4">
                    <hr class="flex-grow-1">
                    <span class="px-3 text-secondary">OR</span>
                    <hr class="flex-grow-1">
                </div>
                <p class="text-center small mb-0">
                    Don't have an account?
                    <a href="/register" class="link-primary">Register</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>
