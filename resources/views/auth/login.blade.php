@include('partials.head')

<div class="container-fluid bg-light min-vh-100 d-flex p-0">
    <div class="row g-0 w-100">
        
        <div class="col-12 col-md-6 bg-primary d-none d-md-flex flex-column justify-content-between p-5 text-white position-relative" 
             style="background: linear-gradient(135deg, #0d6efd 0%, #0a4ebd 100%) !important;">
            
            <div class="d-flex align-items-center gap-2">
                <div class="bg-white rounded-3 text-primary d-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px;">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <span class="fw-bold fs-5 tracking-tight">Ukrida<span class="text-white bg-white bg-opacity-20 px-2 py-0.5 rounded-2 ms-1 small" style="font-size: 12px;">Admin</span></span>
            </div>

            <div class="my-auto max-width-sm">
                <h2 class="fw-bold tracking-tight mb-2" style="font-size: 32px;">Selamat Datang Kembali</h2>
                <p class="text-white text-opacity-75 small m-0">Silakan masuk menggunakan akun administrator Anda untuk mengelola konten menu, artikel, banner, dan pesan pelanggan secara real-time.</p>
            </div>

            <div class="text-white text-opacity-50 small" style="font-size: 11px;">
                &copy; {{ date('Y') }} Ukrida Admin Dashboard. All rights reserved.
            </div>
        </div>

        <div class="col-12 col-md-6 d-flex flex-column justify-content-center bg-white p-4 p-sm-5 position-relative">
            
            <div class="d-flex d-md-none align-items-center gap-2 position-absolute top-0 start-0 m-4">
                <div class="bg-primary rounded-3 text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <span class="fw-bold text-dark">Ukrida<span class="text-primary">Admin</span></span>
            </div>

            <div class="mx-auto w-100" style="max-width: 400px;">
                
                <div class="mb-4">
                    <h4 class="fw-bold text-dark mb-1 tracking-tight">Sign In</h4>
                    <p class="text-muted small m-0">Masukkan kredensial akun Anda untuk melanjutkan</p>
                </div>

                <form method="POST" action="{{ route('auth.login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="identity" class="form-label small fw-bold text-secondary mb-1">Email atau Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted pe-0 rounded-start-3">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" id="identity" name="identity" 
                                   class="form-control bg-light border-0 py-2.5 rounded-end-3 @error('identity') is-invalid @enderror" 
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
                            <span class="input-group-text bg-light border-0 text-muted pe-0 rounded-start-3">
                                <i class="bi bi-key"></i>
                            </span>
                            <input type="password" id="password" name="password" 
                                   class="form-control bg-light border-0 py-2.5 rounded-end-3" 
                                   placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-bold small shadow-sm border-0 mb-3">
                        Sign In Account
                    </button>

                    <div class="d-flex justify-content-between align-items-center mt-2 px-1" style="font-size: 12px;">
                        <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold hover-underline">
                            <i class="bi bi-person-plus me-1"></i> Register
                        </a>
                        <a href="{{ route('forgotPass') }}" class="text-muted text-decoration-none hover-underline">
                            Forgot Password?
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

@include('partials.foot')