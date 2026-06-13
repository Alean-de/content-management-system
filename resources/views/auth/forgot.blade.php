@include('partials.admin.header')

<style>
    .forgot-wrapper {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .forgot-card {
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

<div class="container forgot-wrapper py-5">
    <div class="card forgot-card shadow-lg p-4 bg-body">
        <div class="card-body">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold text-body m-0 tracking-tight">
                    Adddawn<span class="text-primary bg-primary bg-opacity-10 px-2 py-0.5 rounded-2 ms-1 fw-semibold" style="font-size: 14px; letter-spacing: 0.5px;">Admin</span>
                </h3>
                <p class="text-muted small mt-2">Masukkan email terdaftar untuk menerima link instruksi reset password</p>
            </div>

            <form method="POST" action="">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="form-label small fw-bold text-secondary mb-1">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="email" name="email" 
                               class="form-control" placeholder="nama@email.com" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2.5 fw-semibold rounded-3 shadow-sm border-0 mb-3">
                    <i class="bi bi-send-fill me-1" style="font-size: 13px;"></i> Send Reset Link
                </button>
                
                <div class="text-center mt-2">
                    <a href="{{ route('login') }}" class="text-muted small text-decoration-none fw-semibold hover-underline">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke halaman Login
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

