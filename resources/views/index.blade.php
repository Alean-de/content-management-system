@include('partials.public.header')
@section('title', 'Addawn Coffee & Space - Home')
@include('partials.public.navbar')

<style>
    :root {
        --addawn-dark: #121212;       /* Hitam Charcoal Premium */
        --addawn-yellow: #f2cb05;     /* Kuning Ikonik Pintu Addawn */
        --addawn-wood: #a66038;       /* Cokelat Kayu Hangat */
        --addawn-stone: #f4ebd9;      /* Krem Soft Dinding & Batu Alam */
        --addawn-bg: #faf8f5;
    }

    body {
        background-color: var(--addawn-bg);
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    }

    /* --- HERO SPLIT SECTION --- */
    .hero-container {
        min-height: 90vh;
        display: flex;
        align-items: center;
        padding: 60px 0;
    }

    .hero-display-box {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(18, 18, 18, 0.12);
        border: 8px solid #ffffff;
    }

    .hero-display-box img {
        width: 100%;
        height: 500px;
        object-fit: cover;
    }

    .btn-addawn-yellow {
        background-color: var(--addawn-yellow);
        color: var(--addawn-dark);
        font-weight: 700;
        border: none;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .btn-addawn-yellow:hover {
        background-color: #e5bf04;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(242, 203, 5, 0.3);
    }

    .btn-outline-wood {
        border: 2px solid var(--addawn-wood);
        color: var(--addawn-wood);
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-wood:hover {
        background-color: var(--addawn-wood);
        color: #ffffff;
    }

    /* ===================================================
       🔥 TRACK CSS AUTOMATIC MULTI-BANNER MARQUEE SLIDER
       =================================================== */
    .banner-marquee-section {
        width: 100%;
        padding: 20px 0 40px 0;
        background-color: var(--addawn-bg);
        overflow: hidden; /* Gembok kebocoran gambar keluar layar */
        position: relative;
    }

    .banner-marquee-track {
        display: flex;
        gap: 24px; /* Jarak antar flyer promo */
        width: max-content;
        /* Luncurkan animasi ke kiri konstan selama 28 detik */
        animation: scrollBanners 28s linear infinite; 
    }

    /* Auto-pause pergerakan pas kursor user nempel di flyer */
    .banner-marquee-section:hover .banner-marquee-track {
        animation-play-state: paused;
    }

    .banner-flyer-card {
        width: 580px; /* Lebar horizontal flyer biar tulisan diskon terbaca */
        aspect-ratio: 21 / 9; /* Rasio widescreen sinematik */
        border-radius: 20px;
        overflow: hidden;
        flex-shrink: 0; /* Cegah banner menciut atau gepeng */
        border: 6px solid #ffffff;
        box-shadow: 0 12px 28px rgba(18, 18, 18, 0.05);
        transition: transform 0.3s ease;
    }

    .banner-flyer-card:hover {
        transform: scale(1.015);
    }

    .banner-flyer-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    @media (max-width: 768px) {
        .banner-flyer-card {
            width: 340px; /* Ukuran pas ketika dibuka via HP */
        }
    }

    /* Pergerakan tanpa jeda memanfaatkan hardware acceleration */
    @keyframes scrollBanners {
        0% {
            transform: translate3d(0, 0, 0);
        }
        100% {
            transform: translate3d(-50%, 0, 0); 
        }
    }

    /* --- FEATURED ITEMS STYLE --- */
    .featured-card {
        border: none;
        border-radius: 20px;
        background-color: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .featured-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(166, 96, 56, 0.08);
    }

    .featured-img-wrapper {
        width: 100%;
        height: 220px;
        overflow: hidden;
        position: relative;
    }

    .featured-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.5s ease;
    }

    .featured-card:hover .featured-img-wrapper img {
        transform: scale(1.06);
    }

    .badge-recommend {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: var(--addawn-dark);
        color: var(--addawn-yellow);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 6px 14px;
        border-radius: 30px;
        z-index: 2;
    }

    /* --- AMBIENCE GRID SECTION --- */
    .ambience-badge {
        background-color: rgba(166, 96, 56, 0.1);
        color: var(--addawn-wood);
        font-size: 12px;
        letter-spacing: 1px;
    }

    .showcase-card {
        border: none;
        border-radius: 20px;
        background-color: #ffffff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        transition: transform 0.3s ease;
    }

    .showcase-card:hover {
        transform: translateY(-5px);
    }

    .asymmetric-mirror-icon {
        font-size: 2.5rem;
        color: var(--addawn-wood);
    }

    .hover-slide-right {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease, transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        transform-origin: center left;
    }

    .hover-slide-right .arrow-icon {
        display: inline-block;
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .hover-slide-right:hover {
        color: var(--addawn-yellow) !important;
        transform: scale(1.03); 
    }

    .hover-slide-right:hover .arrow-icon {
        transform: translateX(8px);
    }
</style>

<!-- 1. HERO SECTION: VISUAL UTAMA KAFE -->
<section class="hero-container">
    <div class="container px-md-5">
        <div class="row align-items-center g-5">
            
            <div class="col-12 col-lg-6 text-center text-lg-start">
                <span class="ambience-badge fw-bold text-uppercase px-3 py-1.5 rounded-pill mb-3 d-inline-block" 
                    style="background-color: rgba(242, 203, 5, 0.1); color: #a66038;">
                    <i class="bi bi-geo-alt-fill me-1" style="color: #f2cb05;"></i> Adddawn — R1 No. 19 Meruya
                </span>
                <h1 class="display-4 fw-bold text-dark tracking-tight mb-3" style="line-height: 1.2;">
                   Kopi, Cerita, & Momen Hangat di <br> <span style="color: var(--addawn-wood);">Adddawn</span>
                </h1>
                <p class="text-secondary mb-4 mx-auto mx-lg-0" style="max-width: 480px; font-size: 16px; line-height: 1.6;">
                    Lewati pintu kuning ikonik kami dan temukan ruang yang hangat untuk menikmati kopi, berbagi cerita, dan menciptakan momen yang berkesan.
                </p>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ route('public.drink') }}" class="btn btn-addawn-yellow px-4 py-3 rounded-3 shadow-sm fs-6">
                        <i class="bi bi-cup-hot-fill me-2"></i> Jelajahi Menu Kami
                    </a>
                    <a href="{{ route('public.aboutUs') }}" class="btn btn-outline-wood px-4 py-3 rounded-3 fs-6">
                        Tentang Kami
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="hero-display-box">
                    <img src="{{ asset('image/frontDoor.jpg') }}" alt="Adddawn Front Door View">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 2. SECTION MULTI-BANNER MARQUEE SLIDER (REVISI PINDAH KE INDEX) -->
@if($banners->count() > 0)
    {{-- 🔥 TAMPILKAN BANNER MARQUEE JIKA ADA DATA PROMO DI DATABASE --}}
    <section class="banner-marquee-section">
        <div class="banner-marquee-track">
            
            @foreach($banners as $b)
                <div class="banner-flyer-card">
                    <img src="{{ asset('storage/' . str_replace('..', '.', $b->image)) }}" alt="Adddawn Promotion">
                </div>
            @endforeach

            @foreach($banners as $b)
                <div class="banner-flyer-card" aria-hidden="true">
                    <img src="{{ asset('storage/' . str_replace('..', '.', $b->image)) }}" alt="Adddawn Promotion">
                </div>
            @endforeach

        </div>
    </section>
@else
    {{-- 🔥 JIKA DATA KOSONG: Render 1 Section Minimalis Mewah di Tengah Layar Dro! --}}
    <section class="banner-empty-section py-5 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border-bottom: 1px solid rgba(255,255,255,0.05); min-height: 180px;">
        <div class="container">
            <div class="d-flex flex-column align-items-center gap-2">
                <i class="bi bi-megaphone text-muted opacity-100 fs-3"></i>
                <h6 class="text-black text-opacity-50 fw-medium tracking-wide m-0" style="font-size: 14px; letter-spacing: 1px;">
                    Belum ada promo atau info terbaru
                </h6>
                <p class="text-secondary small m-0" style="font-size: 11px;">Pantau terus media sosial kita yaa</p>
            </div>
        </div>
    </section>
@endif

<!-- 3. SECTION: FEATURED ITEMS (CHEF'S CHOICE) -->
<section class="py-5" style="background-color: #fcfbfa;">
    <div class="container px-md-5 py-2">
        
        <div class="row align-items-center g-4 mb-5">
            <div class="col-12 col-md-6 text-center text-md-start">
                <span class="fw-bold text-uppercase small" style="color: var(--addawn-wood); letter-spacing: 1.5px;">Chef's Choice</span>
                <h2 class="fw-bold text-dark m-0 mt-1">Menu Terfavorit Pekan Ini</h2>
            </div>
            <div class="col-12 col-md-6 text-center text-md-end">
                <a href="{{ route('public.drink') }}" class="text-decoration-none fw-bold hover-slide-right" style="color: var(--addawn-dark);">
                    Lihat Semua Menu Resto <i class="bi bi-arrow-right ms-1 d-inline-block arrow-icon"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            @forelse($featuredMenus as $menu)
                <div class="col-12 col-md-4">
                    <div class="card featured-card h-100">
                        <div class="featured-img-wrapper">
                            
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
                            @else
                                <img src="{{ asset('image/default-food.jpg') }}" alt="Default Food">
                            @endif
                        </div>
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="fw-bold text-dark mb-2">{{ $menu->name }}</h5>
                                <p class="text-secondary small mb-3" style="line-height: 1.6; min-height: 48px;">
                                    {{ Str::limit($menu->description, 90, '...') }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light">
                                <span class="fw-extrabold fs-5" style="color: var(--addawn-wood); font-weight: 800;">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </span>
                                <span class="badge bg-light text-dark rounded-pill px-3 py-2 small fw-semibold">
                                    {{ $menu->category->name ?? 'Addawn Specialty' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted italic">Belum ada menu unggulan yang ditetapkan</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

<!-- 4. SECTION: HIGHLIGHT AMBIENCE (SUDUT RUANGAN) -->
<section class="py-5 border-top border-light" style="background-color: #ffffff;">
    <div class="container px-md-5 py-3">
        
        <div class="row align-items-center g-4 mb-5">
            <div class="col-12 col-md-6 text-center text-md-start">
                <h2 class="fw-bold text-dark m-0">Setiap Sudut Punya Cerita</h2>
                <p class="text-muted m-0 mt-1">Rancangan ruang yang menggabungkan estetika retro dengan kenyamanan maksimal.</p>
            </div>
            <div class="col-12 col-md-6 text-center text-md-end">
                <a href="{{ route('public.gallery') }}" 
                class="text-decoration-none fw-bold hover-slide-right" 
                style="color: var(--addawn-wood);">
                    Lihat Galeri Foto Lengkap <i class="bi bi-arrow-right ms-1 d-inline-block arrow-icon"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="card showcase-card p-4 h-100">
                    <div class="mb-3" style="color: var(--addawn-yellow); font-size: 2.5rem;">
                        <i class="bi bi-door-open-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">The Yellow Door</h5>
                    <p class="text-muted small m-0">Fasad depan ikonik dengan warna kuning mustard yang menjadi gerbang masuk menuju ruang santaimu.</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card showcase-card p-4 h-100">
                    <div class="mb-3">
                        <i class="bi bi-bounding-box asymmetric-mirror-icon"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Asymmetric Vibes</h5>
                    <p class="text-muted small m-0">Sentuhan cermin asimetris dengan bingkai kayu jati kontras serta dinding batu alam yang menghadirkan rasa hangat.</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card showcase-card p-4 h-100">
                    <div class="mb-3" style="color: var(--addawn-wood); font-size: 2.5rem;">
                        <i class="bi bi-cup-hot-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Cozy Seating</h5>
                    <p class="text-muted small m-0">Sofa panjang beralas busa empuk, meja bermotif tegel, lengkap dengan colokan listrik tersembunyi untuk WFH atau tugas kuliah.</p>
                </div>
            </div>
        </div>

    </div>
</section>

@include('partials.public.footer')