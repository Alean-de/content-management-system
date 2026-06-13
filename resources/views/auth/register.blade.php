@include('partials.head')

<style>
    .register-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .register-card {
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
        color: #6c757d;
    }
</style>

<div class="container register-wrapper py-5">
    <div class="card register-card shadow-lg p-4 bg-body">
        <div class="card-body">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold text-body m-0 tracking-tight">
                    Adddawn<span class="text-primary bg-primary bg-opacity-10 px-2 py-0.5 rounded-2 ms-1 fw-semibold" style="font-size: 14px; letter-spacing: 0.5px;">Admin</span>
                </h3>
                <p class="text-muted small mt-2">Daftarkan akun administrator baru untuk sistem restoran Addawn</p>
            </div>

            <form action="{{ route('auth.register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label small fw-bold text-secondary mb-1">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-secondary mb-1">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="contoh@ukrida.ac.id" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold text-secondary mb-1">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Buat password aman" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="co-password" class="form-label small fw-bold text-secondary mb-1">Confirmation Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                        <input type="password" class="form-control" id="co-password" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2.5 fw-semibold rounded-3 shadow-sm border-0 mb-3">
                    <i class="bi bi-person-plus-fill me-1"></i> Register Account
                </button>
                
                <div class="text-center">
                    <span class="text-muted small">Sudah punya akses?</span>
                    <a href="{{ route('login') }}" class="text-primary small fw-semibold text-decoration-none ms-1 hover-underline">Login di sini</a>
                </div>
            </form>

        </div>
    </div>
</div>

