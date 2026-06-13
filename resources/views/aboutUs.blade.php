@section('title', 'About Us')
@include('partials.public.header')
@include('partials.public.navbar') {{-- Memanggil navbar public yang sliding border kuning kemarin --}}

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

    /* --- HERO BANNER --- */
    .about-header {
        /* Filter gelap biar teks putihnya kontras dan cozy */
        background: linear-gradient(rgba(18, 18, 18, 0.75), rgba(18, 18, 18, 0.85)), 
                    url('/image/interior.jpg') no-repeat center center/cover;
        padding: 100px 0;
        color: #ffffff;
    }

    /* --- STORY SECTION --- */
    .story-img-wrapper {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        border: 6px solid #ffffff;
    }

    .story-img-wrapper img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .story-img-wrapper:hover img {
        transform: scale(1.03);
    }

    /* --- PHILOSOPHY STATS --- */
    .stat-card {
        background-color: #ffffff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.02);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        background-color: rgba(242, 203, 5, 0.1);
        color: var(--addawn-wood);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
</style>

<div class="about-header text-center">
    <div class="container">
        <span class="text-uppercase fw-bold tracking-wider small" style="color: var(--addawn-yellow); letter-spacing: 2px;">Our Journey</span>
        <h1 class="display-4 fw-bold mt-1 text-white">Tentang Adddawn</h1>
    </div>
</div>

<section class="py-5 mt-4">
    <div class="container px-md-5">
        <div class="row align-items-center g-5">
            
            <div class="col-12 col-lg-6 text-center text-lg-start">
                <h2 class="fw-bold text-dark mb-3">Membawa Kehangatan di Setiap Awal</h2>
                <p class="text-secondary small mb-3" style="line-height: 1.7; font-size: 15px;">
                    Bagi kami, sebuah kafe bukan hanya tentang apa yang tersaji di meja, tetapi juga tentang bagaimana setiap orang merasa saat berada di dalamnya. Itulah alasan Addawn hadir: untuk menciptakan ruang yang hangat, nyaman, dan selalu menyenangkan untuk kembali.</p>
                <p class="text-secondary small mb-0" style="line-height: 1.7; font-size: 15px;">
                    Pintu kuning mustard yang menjadi ciri khas Addawn hadir sebagai simbol kehangatan dan optimisme. Terinspirasi dari cahaya fajar yang menandai awal hari, kami ingin menghadirkan suasana yang sama bagi setiap pengunjung: tempat yang nyaman untuk memulai aktivitas, melepas penat, bertemu orang-orang terdekat, atau sekadar menikmati waktu untuk diri sendiri.
                </p>
            </div>

            <div class="col-12 col-lg-6">
                <div class="story-img-wrapper">
                    <img src="{{ asset('image/frontDoor.jpg') }}" alt="Addawn Facade View">
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-5" style="background-color: #ffffff;">
    <div class="container px-md-5">
        <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">
            
            <div class="col-12 col-lg-6">
                <div class="story-img-wrapper">
                    <img src="{{ asset('image/interior.jpg') }}" alt="Addawn Interior Concept">
                </div>
            </div>

            <div class="col-12 col-lg-6 text-center text-lg-start">
                <h2 class="fw-bold text-dark mb-3">Estetika Retro, Kenyamanan Modern</h2>
                <p class="text-secondary small mb-3" style="line-height: 1.7; font-size: 15px;">
                    Kami mengadopsi konsep desain mid-century modern yang menonjolkan rona material alami. Dinding bertekstur batu alam, langit-langit kayu yang simetris, serta lantai tegel bermotif kotak klasik dikombinasikan secara apik untuk menghadirkan atmosfer cozy yang otentik. Setiap sudut dirancang untuk menciptakan rasa nyaman yang tidak berlebihan—hangat, tenang, dan mengundang siapa saja untuk berlama-lama. Baik untuk menikmati secangkir kopi di pagi hari, menyelesaikan pekerjaan, berbincang bersama sahabat, maupun menghabiskan waktu berkualitas bersama keluarga.
                </p>
                <p class="text-secondary small mb-0" style="line-height: 1.7; font-size: 15px;">
                    Ditambah dengan sofa panjang berlapis busa empuk dan lampu gantung klasik yang memancarkan kehangatan, setiap sudut dirancang untuk mendukung berbagai aktivitas—mulai dari berbincang santai, menikmati waktu sendiri dengan sebuah buku, hingga bekerja dan berkarya dengan lebih nyaman.
                </p>
            </div>

        </div>
    </div>
</section>

<section class="py-5">
    <div class="container px-md-5 py-3">
        <div class="text-center mb-5">
            <h3 class="fw-bold text-dark">Komitmen Adddawn</h3>
            <p class="text-muted small">Tiga pilar utama yang selalu kami jaga untuk kenyamanan Anda</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="card stat-card p-4 h-100 text-center text-md-start">
                    <div class="icon-circle mx-auto mx-md-0 mb-3">
                        <i class="bi bi-heart-fill" style="color: #de3545;"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Hospitality</h5>
                    <p class="text-muted small m-0">Menyambut setiap pengunjung layaknya keluarga dengan pelayanan ramah dan tulus semenjak injakan kaki pertama.</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card stat-card p-4 h-100 text-center text-md-start">
                    <div class="icon-circle mx-auto mx-md-0 mb-3">
                        <i class="bi bi-gem" style="color: var(--addawn-wood)"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Quality Control</h5>
                    <p class="text-muted small m-0">Menyajikan kopi pilihan serta hidangan makanan berstandar tinggi yang diracik bersih oleh barista dan tim dapur.</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card stat-card p-4 h-100 text-center text-md-start">
                    <div class="icon-circle mx-auto mx-md-0 mb-3">
                        <i class="bi bi-geo-alt-fill" style="color: var(--addawn-yellow)"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">The Real Spot (RI 19)</h5>
                    <p class="text-muted small m-0">Konsisten mengelola titik temu estetik ruko R1 No. 19 Meruya sebagai wadah kreatif dan ruang santai andalan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.public.footer') {{-- Memanggil footer public rich premium dark kemarin --}}