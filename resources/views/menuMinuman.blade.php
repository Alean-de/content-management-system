@section('title', 'Beverage')
@include('partials.public.header')
@include('partials.public.navbar')

<style>
    :root {
        --addawn-dark: #121212;
        --addawn-yellow: #f2cb05;
        --addawn-wood: #a66038;
        --addawn-bg: #faf8f5;
        --addawn-muted: #6c757d;
    }

    body {
        background-color: var(--addawn-bg);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* --- HEADER MENU --- */
    .menu-header {
        background: linear-gradient(rgba(18, 18, 18, 0.8), rgba(18, 18, 18, 0.9)), 
                    url('/image/interior.jpg') no-repeat center center/cover;
        padding: 80px 0;
        color: #ffffff;
    }

    /* --- PREMIUM BEVERAGE CARD --- */
    .menu-card {
        border: none;
        border-radius: 16px;
        background-color: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s ease;
    }

    .menu-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(18, 18, 18, 0.08);
    }

    /* Wrapper Gambar biar pas di-hover membesar di dalam area card */
    .menu-img-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
        background-color: #f1f1f1;
    }

    .menu-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .menu-card:hover .menu-img-wrapper img {
        transform: scale(1.06);
    }

    /* Badge penanda kategori minuman melayang di atas gambar */
    .menu-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background-color: rgba(18, 18, 18, 0.85);
        color: var(--addawn-yellow);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 6px 14px;
        border-radius: 20px;
        backdrop-filter: blur(4px);
    }

    .menu-price {
        color: var(--addawn-wood);
        font-weight: 800;
        font-size: 1.15rem;
    }
</style>

<!-- 1. HEADER BANNER BEVERAGES -->
<div class="menu-header text-center">
    <div class="container">
        <span class="text-uppercase fw-bold tracking-wider small" style="color: var(--addawn-yellow); letter-spacing: 2px;">Crafted Beverages</span>
        <h1 class="display-5 fw-bold mt-1 text-white">Menu Minuman Adddawn</h1>
    </div>
</div>



<!-- KONTEN DAFTAR MINUMAN -->
<div class="py-5">
    
    <!-- ===================================================
         BLOK 1: KATEGORI COFFEE
         =================================================== -->
    <section class="mb-5">
        <div class="container px-md-5">
            <!-- Judul Sub-Kategori Premium -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <h3 class="fw-bold text-dark m-0">Coffee Series</h3>
                <div class="flex-grow-1 border-bottom border-light" style="height: 1px;"></div>
            </div>

            <div class="row g-4">
                <!-- Looping data khusus kopi -->
                @forelse($coffeeMenus as $cm)
                    {{-- Kita tetep filter apakah kategorinya mengandung bakery atau pastry --}}
                    @if(Str::contains(Str::lower($cm->category->name), 'coffee') || Str::contains(Str::lower($cm->category->name), 'non-coffee'))
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card menu-card h-100">
                                <div class="menu-img-wrapper">
                                    <img src="{{ asset('storage/' . $cm->image) }}" alt="{{ $cm->name }}">
                                </div>
                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-2">{{ $cm->name }}</h5>
                                        <p class="text-muted small mb-0" style="line-height: 1.5;">
                                            {{ $cm->description }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-4 pt-2 border-top border-light">
                                        <span class="menu-price">Rp {{ number_format($cm->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    {{-- 🔥 JIKA DATABASE SAKLEK KOSONG, BLOK INI YANG DIKIRIM (ANTI-PERULANGAN BADUT) --}}
                    <div class="col-12 text-center py-5 my-4">
                        <div class="bg-white rounded-4 p-5 shadow-sm max-width-md mx-auto" style="max-width: 450px;">
                            <i class="bi bi-clock-history text-muted display-4 mb-3 d-block"></i>
                            <h5 class="fw-bold text-dark mb-2">Coffee Series Coming Soon!</h5>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ===================================================
         BLOK 2: KATEGORI NON-COFFEE
         =================================================== -->
    <section class="py-4">
        <div class="container px-md-5">
            <!-- Judul Sub-Kategori Premium -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <h3 class="fw-bold text-dark m-0">Non-Coffee Series</h3>
                <div class="flex-grow-1 border-bottom border-light" style="height: 1px;"></div>
            </div>

            <div class="row g-4">
                <!-- Looping data khusus non-kopi -->
                @forelse($nonCoffeeMenus as $ncm)
                    {{-- Kita tetep filter apakah kategorinya mengandung bakery atau pastry --}}
                    @if(Str::contains(Str::lower($ncm->category->name), 'coffee') || Str::contains(Str::lower($ncm->category->name), 'non'))
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card menu-card h-100">
                                <div class="menu-img-wrapper">
                                    <img src="{{ asset('storage/' . $ncm->image) }}" alt="{{ $ncm->name }}">
                                </div>
                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-2">{{ $ncm->name }}</h5>
                                        <p class="text-muted small mb-0" style="line-height: 1.5;">
                                            {{ $ncm->description }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-4 pt-2 border-top border-light">
                                        <span class="menu-price">Rp {{ number_format($ncm->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    {{-- 🔥 JIKA DATABASE SAKLEK KOSONG, BLOK INI YANG DIKIRIM (ANTI-PERULANGAN BADUT) --}}
                    <div class="col-12 text-center py-5 my-4">
                        <div class="bg-white rounded-4 p-5 shadow-sm max-width-md mx-auto" style="max-width: 450px;">
                            <i class="bi bi-clock-history text-muted display-4 mb-3 d-block"></i>
                            <h5 class="fw-bold text-dark mb-2">Non Coffee Series Coming Soon!</h5>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

</div>

@include('partials.public.footer')