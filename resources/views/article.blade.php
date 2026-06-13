@section('title', 'Article')
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

    /* --- HEADER SECTION --- */
    .article-header {
        background: linear-gradient(rgba(18, 18, 18, 0.8), rgba(18, 18, 18, 0.9)), 
                    url('/image/interior.jpg') no-repeat center center/cover;
        padding: 80px 0;
        color: #ffffff;
    }

    /* --- FEATURED CARD (ARTIKEL UTAMA) --- */
    .featured-card {
        border: none;
        border-radius: 24px;
        background-color: #ffffff;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        transition: transform 0.4s ease;
    }

    .featured-img-wrapper {
        height: 100%;
        min-height: 350px;
        overflow: hidden;
    }

    .featured-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .featured-card:hover .featured-img-wrapper img {
        transform: scale(1.03);
    }

    /* --- STANDARD ARTICLE CARD --- */
    .article-card {
        border: none;
        border-radius: 16px;
        background-color: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s ease;
    }

    .article-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(18, 18, 18, 0.08);
    }

    .article-img-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .article-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .article-card:hover .article-img-wrapper img {
        transform: scale(1.05);
    }

    /* --- BADGE & LINK BUTTON --- */
    .date-badge {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--addawn-wood);
        background-color: rgba(166, 96, 56, 0.1);
    }

    .btn-read-more {
        font-size: 13px;
        font-weight: 700;
        color: var(--addawn-dark);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.3s ease;
    }

    .btn-read-more:hover {
        color: var(--addawn-wood);
    }

    .btn-read-more i {
        transition: transform 0.3s ease;
    }

    .btn-read-more:hover i {
        transform: translateX(4px);
    }
</style>

<div class="article-header text-center">
    <div class="container">
        <span class="text-uppercase fw-bold tracking-wider small" style="color: var(--addawn-yellow); letter-spacing: 2px;">Addawn Journal</span>
        <h1 class="display-5 fw-bold mt-1 text-white">Artikel & Cerita Kami</h1>
    </div>
</div>

<div class="container px-md-5 py-5 my-2">
    
    @if($articles->count() > 0)
        @php $featured = $articles->first(); @endphp
        <div class="card featured-card mb-5 p-3 p-md-0">
            <div class="row g-0 align-items-center">
                <div class="col-12 col-md-6">
                    <div class="featured-img-wrapper rounded-4">
                        <img src="{{ asset('storage/' . $featured->thumbnail) }}" alt="{{ $featured->title }}">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card-body p-4 p-md-5">
                        <span class="badge date-badge px-3 py-1.5 rounded-pill mb-3">
                            <i class="bi bi-calendar3 me-1"></i> {{ $featured->created_at->format('d M Y') }}
                        </span>
                        <h2 class="fw-bold text-dark mb-3" style="line-height: 1.3;">{{ $featured->title }}</h2>
                        <p class="text-secondary small mb-4" style="line-height: 1.6;">
                            {{ Str::limit(strip_tags($featured->content), 180) }}
                        </p>
                        <a href="{{ route('public.article.show', $featured->slug) }}" class="btn-read-more">
                            Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 mb-4 pt-3">
            <h4 class="fw-bold text-dark m-0">Latest Updates</h4>
            <div class="flex-grow-1 border-bottom border-light" style="height: 1px;"></div>
        </div>

        <div class="row g-4">
            @foreach($articles->skip(1) as $article)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card article-card h-100">
                        <div class="article-img-wrapper">
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}">
                        </div>
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge date-badge px-2.5 py-1.5 rounded-pill mb-2">
                                    {{ $article->created_at->format('d M Y') }}
                                </span>
                                <h5 class="fw-bold text-dark mb-2" style="line-height: 1.4;">
                                    {{ Str::limit($article->title, 55) }}
                                </h5>
                                <p class="text-muted small mb-0" style="line-height: 1.5;">
                                    {{ Str::limit(strip_tags($article->content), 95) }}
                                </p>
                            </div>
                            
                            <div class="mt-4 pt-2 border-top border-light">
                                <a href="{{ route('public.article.show', $article->slug) }}" class="btn-read-more">
                                    Baca Cerita <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-journal-text text-muted display-3 mb-3 d-block"></i>
            <p class="text-muted small">Belum ada artikel atau kabar terbaru yang diterbitkan</p>
        </div>
    @endif

</div>

@include('partials.public.footer')