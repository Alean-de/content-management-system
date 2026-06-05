@include('partials.head')
@include('partials.navbar')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">

<div class="container-fluid bg-light min-vh-100 py-4 px-md-5" style="background-color: #f8f9fa !important;">
    
    <!-- Title Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold text-dark m-0 tracking-tight">Overview Dashboard</h4>
            <p class="text-muted small m-0 mt-1">Selamat datang kembali, {{ auth()->user()->name }}. Berikut adalah ringkasan data restoran Anda hari ini.</p>
        </div>
        <div class="mt-3 mt-md-0 text-muted small fw-medium">
            <i class="bi bi-calendar3 me-1"></i> {{ date('d M Y') }}
        </div>
    </div>

    <!-- ==========================================
         BAGIAN 1: CARD METRICS (ANGKA RINGKASAN)
         ========================================== -->
    <div class="row g-3 mb-4">
        <!-- Total Menu -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 bg-white p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Menu</span>
                        <h3 class="fw-bold text-dark m-0">{{ \App\Models\Menu::count() }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-egg-fried fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Articles -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 bg-white p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Articles</span>
                        <h3 class="fw-bold text-dark m-0">{{ \App\Models\Article::count() }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-journal-text fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Banners -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 bg-white p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1">Active Banners</span>
                        <h3 class="fw-bold text-dark m-0">{{ \App\Models\Banner::where('is_active', 1)->count() }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-images fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Messages -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 bg-white p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1">New Messages</span>
                        <h3 class="fw-bold text-dark m-0">{{ App\Models\Messages::count() }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-envelope fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- ==========================================
             BAGIAN 2: LIST PESAN MASUK TERBARU (KIRI)
             ========================================== -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-3 bg-white h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark m-0"><i class="bi bi-chat-left-text me-2 text-primary"></i>Recent Messages</h6>
                    <a href="{{ route('administrator.message.') }}" class="text-primary text-decoration-none small fw-semibold" style="font-size: 12px;">View All</a>
                </div>
                <div class="card-body px-4 pb-4 pt-1">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0 small">
                            <tbody class="text-secondary">
                                @php
                                    $recentMessages = \App\Models\Messages::latest()->take(5)->get();
                                @endphp
                                @forelse($recentMessages as $msg)
                                    <tr class="border-bottom">
                                        <td class="py-3 ps-0" style="width: 30%">
                                            <span class="text-dark fw-bold d-block">{{ $msg->name }}</span>
                                            <span class="text-muted" style="font-size: 11px;">{{ $msg->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td class="py-3 text-muted">{{ Str::limit($msg->subject, 40) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-4">Belum ada pesan masuk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==========================================
             BAGIAN 3: FEATURED MENU / MENU UNGGULAN (KANAN)
             ========================================== -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-3 bg-white h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                    <h6 class="fw-bold text-dark m-0"><i class="bi bi-star me-2 text-warning"></i>Featured Items</h6>
                </div>
                <div class="card-body px-4 pb-4 pt-1">
                    <div class="d-flex flex-column gap-3 mt-2">
                        @php
                            $featuredMenus = \App\Models\Menu::where('is_featured', 1)->take(3)->get();
                        @endphp
                        @forelse($featuredMenus as $menu)
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-light">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $menu->image ? asset('storage/'.$menu->image) : asset('images/no-image.png') }}" 
                                         alt="{{ $menu->name }}" class="rounded shadow-sm object-fit-cover" style="width: 50px; height: 50px;">
                                    <div>
                                        <span class="text-dark fw-bold d-block" style="font-size: 13px;">{{ $menu->name }}</span>
                                        <span class="text-muted" style="font-size: 11px;">{{ $menu->category ? $menu->category->name : 'No Category' }}</span>
                                    </div>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-3 font-semibold" style="font-size: 12px;">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4 small">Belum ada menu unggulan yang diset.</div>
                        @endforelse <!-- FIX: Di sini kemarin salah ketik jadi forelseend -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.foot')