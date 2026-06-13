<nav class="navbar navbar-expand-lg bg-white sticky-top py-3 border-bottom border-light shadow-sm">
    <div class="container px-md-5">
        
        <!-- Branding Logo / Nama Kafe -->
        <a class="navbar-brand d-flex align-items-center position-relative" href="{{ route('index') }}" style="min-width: 150px; min-height: 40px;">
            <img src="{{ asset('image/logo.png') }}" alt="Addawn Logo" 
                style="height: 70px; width: auto; position: absolute; top: 50%; transform: translateY(-50%); z-index: 1050;">
        </a>

        <!-- Tombol Hamburger Menu Pas Layar HP/Mobile -->
        <button class="navbar-toggler border-0 shadow-none px-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavPublic" aria-controls="navbarNavPublic" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Kumpulan Link Menu Navigasi Publik (8 Pages Target) -->
        <div class="collapse navbar-collapse" id="navbarNavPublic">
            <ul class="navbar-nav mx-auto mt-3 mt-lg-0 gap-1 gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link public-nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link public-nav-link {{ Request::is('public/about-us') ? 'active' : '' }}" href="{{ route('public.aboutUs') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link public-nav-link {{ Request::is('public/beverage') ? 'active' : '' }}" href="{{ route('public.drink') }}">Beverage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link public-nav-link {{ Request::is('public/food') ? 'active' : '' }}" href="{{ route('public.food') }}">Food</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link public-nav-link {{ Request::is('public/article') ? 'active' : '' }}" href="{{ route('public.article') }}">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link public-nav-link {{ Request::is('public/gallery') ? 'active' : '' }}" href="{{ route('public.gallery') }}">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link public-nav-link {{ Request::is('public/contact') ? 'active' : '' }}" href="{{ route('public.messageLoc') }}">Contact</a>
                </li>

            </ul>
        </div>

    </div>
</nav>

<!-- --- CUSTOM STYLE HOVER SLIDING EFFECT --- -->
<style>
    /* Styling Dasar Link Teks */
    .public-nav-link {
        color: #6c757d !important;
        font-weight: 600;
        font-size: 15px;
        padding: 6px 4px !important;
        position: relative;
        transition: color 0.3s ease;
    }

    /* Efek Garis Bawah (Underline Sliding Hidden) */
    .public-nav-link::after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 3px;
        bottom: 0;
        left: 0;
        background-color: #f2cb05; /* Kuning Pintu Ikonik Addawn */
        transform-origin: bottom right;
        transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-radius: 2px;
    }

    /* Saat Mouse Mendekat (Hover) / Menu Sedang Aktif */
    .public-nav-link:hover,
    .public-nav-link.active {
        color: #121212 !important; /* Berubah jadi hitam pekat */
    }

    .public-nav-link:hover::after,
    .public-nav-link.active::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }

    /* Tombol Aksi Kanan */
    .btn-addawn-nav {
        background-color: #121212;
        color: #f2cb05 !important; /* Kombinasi Hitam & Kuning */
        font-weight: 700;
        font-size: 14px;
        border: none;
        letter-spacing: 0.3px;
        transition: all 0.25s ease;
    }

    .btn-addawn-nav:hover {
        background-color: #f2cb05;
        color: #121212 !important;
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(242, 203, 5, 0.25);
    }
</style>