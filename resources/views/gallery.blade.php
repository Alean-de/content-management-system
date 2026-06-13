@section('title', 'Gallery')
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
        overflow-x: hidden; /* Wajib biar halaman gak jebol ke kanan gara-gara slider */
    }

    /* --- HEADER GALLERY --- */
    .gallery-header {
        background: linear-gradient(rgba(18, 18, 18, 0.82), rgba(18, 18, 18, 0.92)), 
                    url('/image/interior.jpg') no-repeat center center/cover;
        padding: 80px 0;
        color: #ffffff;
    }

    /* --- INFINITE MARQUEE SLIDER CORE --- */
    .marquee-wrapper {
        position: relative;
        width: 100%;
        padding: 20px 0;
        overflow: hidden; /* Memotong gambar yang keluar dari layar */
        display: flex;
        flex-direction: column;
        gap: 30px; /* Jarak antara slider baris atas dan bawah */
    }

    .marquee-track {
        display: flex;
        width: max-content; /* Biar track membentang sepanjang jumlah gambar */
        gap: 20px; /* Jarak antar foto di dalam slider */
    }

    /* --- ANIMASI TRACK RUNNING (Pelan & Halus) --- */
    .track-to-left {
        /* Durasi 40 detik biar gerakannya pelan dan cozy */
        animation: scrollLeft 40s linear infinite; 
    }

    .track-to-right {
        animation: scrollRight 40s linear infinite;
    }

    /* Efek Berhenti Jalan saat Kursor Mouse Menempel (Hover) */
    .marquee-wrapper:hover .marquee-track {
        animation-play-state: paused;
    }

    /* --- GAMBAR DI DALAM GALLERY CARD --- */
    .gallery-card {
        width: 320px; /* Lebar paten tiap foto biar rapi */
        height: 240px; /* Tinggi paten */
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 10px 25px rgba(18, 18, 18, 0.05);
        border: 4px solid #ffffff;
        cursor: pointer;
    }

    .gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    /* Efek Overlay Teks Muncul Lembut saat Foto Didekati */
    .gallery-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(transparent, rgba(18, 18, 18, 0.85));
        opacity: 0;
        display: flex;
        align-items: flex-end;
        padding: 20px;
        transition: opacity 0.3s ease;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-card:hover img {
        transform: scale(1.05);
    }

    /* --- KEYFRAMES LOGIC ANIMATION --- */
    @keyframes scrollLeft {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); } /* Bergeser setengah panjang kloningan track */
    }

    @keyframes scrollRight {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }
</style>

<div class="gallery-header text-center">
    <div class="container">
        <span class="text-uppercase fw-bold tracking-wider small" style="color: var(--addawn-yellow); letter-spacing: 2px;">Visual Ambience</span>
        <h1 class="display-5 fw-bold mt-1 text-white">Sudut Estetik Adddawn</h1>
    </div>
</div>

<div class="py-5" style="background-color: #ffffff;">
    <div class="marquee-wrapper">
        
        <div class="marquee-track track-to-left">
            @forelse($galleries as $gallery)
                <div class="gallery-card">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}">
                    <div class="gallery-overlay">
                        <p class="m-0 text-white fw-bold small"><i class="bi bi-camera me-1 text-warning"></i> {{ $gallery->title }}</p>
                    </div>
                </div>
            @empty
                @for($i = 1; $i <= 4; $i++)
                    <div class="gallery-card d-flex flex-column align-items-center justify-content-center bg-white border rounded-4 p-4 shadow-sm text-center" style="min-width: 280px; height: 200px; border: 2px dashed rgba(0,0,0,0.1) !important;">
                        <i class="bi bi-images text-muted fs-2 mb-2"></i>
                        <h6 class="fw-bold text-dark m-0">Visual Gallery</h6>
                        <p class="text-muted small m-0 mt-1">Coming Soon</p>
                    </div>
                @endfor
            @endforelse

            {{-- Duplikasi Track Pertama buat Seamless Loop --}}
            @foreach($galleries as $gallery)
                <div class="gallery-card">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}">
                    <div class="gallery-overlay">
                        <p class="m-0 text-white fw-bold small"><i class="bi bi-camera me-1 text-warning"></i> {{ $gallery->title }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="marquee-track track-to-right mt-3">
            @forelse($galleries->reverse() as $gallery)
                <div class="gallery-card">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}">
                    <div class="gallery-overlay">
                        <p class="m-0 text-white fw-bold small"><i class="bi bi-geo-alt me-1 text-warning"></i> {{ $gallery->title }}</p>
                    </div>
                </div>
            @empty
                @for($i = 1; $i <= 4; $i++)
                    <div class="gallery-card d-flex flex-column align-items-center justify-content-center bg-white border rounded-4 p-4 shadow-sm text-center" style="min-width: 280px; height: 200px; border: 2px dashed rgba(0,0,0,0.1) !important;">
                        <i class="bi bi-images text-muted fs-2 mb-2"></i>
                        <h6 class="fw-bold text-dark m-0">Visual Gallery</h6>
                        <p class="text-muted small m-0 mt-1">Coming Soon</p>
                    </div>
                @endfor
            @endforelse

            {{-- Duplikasi Track Kedua --}}
            @foreach($galleries->reverse() as $gallery)
                <div class="gallery-card">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}">
                    <div class="gallery-overlay">
                        <p class="m-0 text-white fw-bold small"><i class="bi bi-geo-alt me-1 text-warning"></i> {{ $gallery->title }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

@include('partials.public.footer')