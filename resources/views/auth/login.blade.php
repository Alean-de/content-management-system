@include('partials.head')

<style>

    .login-wrapper {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-card {
        border: none;
        border-radius: 16px;
        max-width: 450px;
        width: 100%;
    }
    .form-control {
        background-color: var(--bs-tertiary-bg);
        border: none;
        padding: 10px 12px;
        border-radius: 0 8px 8px 0;
    }
    .form-control:focus {
        background-color: var(--bs-body-bg);
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border: 1px solid #0d6efd;
    }
    .input-group-text {
        background-color: var(--bs-tertiary-bg);
        border: none;
        border-radius: 8px 0 0 8px;
       color: var(--bs-secondary-color);
    }
</style>

<div class="container login-wrapper py-5">
    <div class="card login-card shadow-lg p-4 bg-body">
        <div class="card-body">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold text-body m-0 tracking-tight">
                    Adddawn<span class="text-primary bg-primary bg-opacity-10 px-2 py-0.5 rounded-2 ms-1 fw-semibold" style="font-size: 14px; letter-spacing: 0.5px;">Admin</span>
                </h3>
                <p class="text-muted small mt-2">Sign in untuk mengelola menu, banner, galeri, dan pesan restoran Addawn</p>
            </div>

            <form method="POST" action="{{ route('auth.login') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="identity" class="form-label small fw-bold text-secondary mb-1">Email atau Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" id="identity" name="identity" 
                               class="form-control @error('identity') is-invalid @enderror" 
                               placeholder="Username atau nama@email.com" required>
                    </div>
                    @error('identity')
                        <div class="text-danger mt-1 fw-semibold" style="font-size: 11px;">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label small fw-bold text-secondary mb-1">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password" 
                               class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2.5 fw-semibold rounded-3 shadow-sm border-0 mb-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Sign In Account
                </button>
                
                <div class="d-flex justify-content-between align-items-center mt-2 px-1" style="font-size: 12px;">
                    <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold hover-underline">
                        <i class="bi bi-person-plus me-1"></i> Register Account
                    </a>
                    <a href="{{ route('forgotPass') }}" class="text-muted text-decoration-none hover-underline">
                        Forgot Password?
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

