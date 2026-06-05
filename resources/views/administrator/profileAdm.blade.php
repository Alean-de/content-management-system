@include('partials.head')
@include('partials.navbar')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">

<div class="container-fluid bg-light min-vh-100 py-4 px-md-5" style="background-color: #f8f9fa !important;">
    
    <!-- Title Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold text-dark m-0 tracking-tight">Profile Settings</h4>
            <p class="text-muted small m-0 mt-1">Kelola informasi kredensial akun administrator dan amankan kata sandi Anda</p>
        </div>
    </div>

    <!-- Global Flash Notification Alert -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 alert-dismissible fade show small d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close shadow-none small" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- ==========================================
             KOLOM KIRI: RINGKASAN AKUN & LOGOUT
             ========================================== -->
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 text-center p-4 bg-white mb-3">
                <!-- Avatar Placeholder Bulat Estetik -->
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold text-uppercase shadow-sm" style="width: 72px; height: 72px; font-size: 24px;">
                    {{ substr(auth()->user()->name, 0, 2) }}
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ auth()->user()->name }}</h5>
                <p class="text-muted small mb-0">{{ auth()->user()->email }}</p>
                <span class="badge bg-dark bg-opacity-10 text-dark small px-3 py-1.5 rounded-pill fw-semibold mt-3" style="font-size: 11px;">Administrator</span>
            </div>

            <!-- Card Tombol Logout Terpisah -->
            <div class="card border-0 shadow-sm rounded-3 bg-white p-2">
                <form action="{{ route('administrator.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-light w-100 py-2 text-danger fw-bold rounded-3 small d-flex align-items-center justify-content-center gap-2 shadow-none border-0 bg-danger bg-opacity-10">
                        <i class="bi bi-box-arrow-right"></i> Logout Account
                    </button>
                </form>
            </div>
        </div>

        <!-- ==========================================
             KOLOM KANAN: DUA FORM UTAMA PENGATURAN
             ========================================== -->
        <div class="col-12 col-md-8 col-lg-9">
            <div class="d-flex flex-column gap-4">
                
                <!-- KARTU 1: PENGATURAN DATA DIRI -->
                <div class="card border-0 shadow-sm rounded-3 bg-white">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h6 class="fw-bold text-dark m-0"><i class="bi bi-person-gear me-2 text-primary"></i>Account Information</h6>
                        <p class="text-muted small m-0 mt-1" style="font-size: 11px;">Perbarui nama tampilan dan alamat surat elektronik utama Anda</p>
                    </div>
                    <div class="card-body px-4 pb-4 pt-3">
                        <div class="row g-3">
                            <!-- Form Ubah Nama -->
                            <div class="col-12 col-lg-6">
                                <form action="{{ route('administrator.profile.name') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold text-secondary mb-1">Display Name</label>
                                        <input type="text" name="name" class="form-control bg-light border-0 py-2 rounded-3 text-dark font-medium" value="{{ auth()->user()->name }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm px-3 py-2 rounded-3 fw-semibold shadow-sm border-0">Update Name</button>
                                </form>
                            </div>

                            <!-- Form Ubah Email -->
                            <div class="col-12 col-lg-6 border-start-lg">
                                <form action="{{ route('administrator.profile.email') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold text-secondary mb-1">Email Address</label>
                                        <input type="email" name="email" class="form-control bg-light border-0 py-2 rounded-3 text-dark font-medium" value="{{ auth()->user()->email }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm px-3 py-2 rounded-3 fw-semibold shadow-sm border-0">Update Email</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KARTU 2: PENGATURAN SECURITY (PASSWORD) -->
                <div class="card border-0 shadow-sm rounded-3 bg-white">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h6 class="fw-bold text-dark m-0"><i class="bi bi-shield-lock me-2 text-warning"></i>Security Settings</h6>
                        <p class="text-muted small m-0 mt-1" style="font-size: 11px;">Ganti kata sandi Anda secara berkala demi menjaga keamanan data sistem</p>
                    </div>
                    <div class="card-body px-4 pb-4 pt-3">
                        <form action="{{ route('administrator.profile.password') }}" method="POST" class="mx-auto" style="max-width: 500px;">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary mb-1">Current Password</label>
                                <input type="password" name="current_password" class="form-control bg-light border-0 py-2 rounded-3" placeholder="••••••••" required>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-secondary mb-1">New Password</label>
                                    <input type="password" name="password" class="form-control bg-light border-0 py-2 rounded-3" placeholder="••••••••" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-secondary mb-1">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control bg-light border-0 py-2 rounded-3" placeholder="••••••••" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 py-2 rounded-3 fw-bold text-dark small shadow-sm border-0 mt-2">Update Password Security</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@include('partials.foot')