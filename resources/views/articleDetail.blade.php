@include('partials.public.header')
@include('partials.public.navbar')

@php
    $cleanThumbnail = str_replace('..', '.', $article->thumbnail);
@endphp

<style>
    :root {
        --addawn-dark: #121212;
        --addawn-yellow: #f2cb05;
        --addawn-wood: #a66038;
        --addawn-bg: #faf8f5;
    }

    body {
        background-color: var(--addawn-bg);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* --- HERO BACKGROUND THUMBNAIL --- */
    .article-detail-hero {
        background: linear-gradient(rgba(18, 18, 18, 0.65), rgba(18, 18, 18, 0.85)), 
                    url("{{ asset('storage/' . $cleanThumbnail) }}") no-repeat center center/cover;
        padding: 140px 0 80px 0;
        color: #ffffff;
        min-height: 450px;
        display: flex;
        align-items: flex-end;
    }

    /* --- CONTENT WRAPPER --- */
    .content-card {
        background-color: #ffffff;
        border: none;
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(18, 18, 18, 0.03);
        margin-top: -60px; /* Trik biar kontennya naik memotong hero background (mewah parah) */
        position: relative;
        z-index: 10;
    }

    .article-body-text {
        font-size: 16px;
        line-height: 1.8;
        color: #333333;
    }

    .article-body-text p {
        margin-bottom: 1.5rem;
    }

    .btn-back {
        color: var(--addawn-wood);
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        color: var(--addawn-dark);
    }
</style>

<!-- 1. HERO BACKGROUND SECTION -->
<section class="article-detail-hero">
    <div class="container px-md-5">
        <div class="row">
            <div class="col-12 col-lg-10">
                <!-- Badge Tanggal -->
                <span class="badge px-3 py-1.5 rounded-pill mb-3" style="background-color: var(--addawn-yellow); color: var(--addawn-dark); font-weight: 700;">
                    <i class="bi bi-calendar3 me-1"></i> {{ $article->created_at->format('d M Y') }}
                </span>
                <!-- Judul Raksasa -->
                <h1 class="display-4 fw-bold text-white mb-0" style="line-height: 1.2;">
                    {{ $article->title }}
                </h1>
            </div>
        </div>
    </div>
</section>

<!-- 2. INTI KONTEN ARTIKEL -->
<div class="container px-md-5 mb-5">
    <div class="row">
        <div class="col-12 col-lg-9 mx-auto">
            
            <div class="card content-card p-4 p-md-5">
                <!-- Tombol Kembali -->
                <div class="mb-4">
                    <a href="{{ route('public.article') }}" class="btn-back">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Jurnal
                    </a>
                </div>

                <hr class="border-light mb-4">

                <!-- Isi Artikel Lengkap -->
                <div class="article-body-text">
                    {!! nl2br(e($article->content)) !!} 
                </div>
            </div>

        </div>
    </div>
</div>

@include('partials.public.footer')