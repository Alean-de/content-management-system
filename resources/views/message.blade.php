@section('title', 'Contact')
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
    .contact-header {
        background: linear-gradient(rgba(18, 18, 18, 0.8), rgba(18, 18, 18, 0.9)), 
                    url('/image/interior.jpg') no-repeat center center/cover;
        padding: 80px 0;
        color: #ffffff;
    }

    /* --- MAPS & INFO CARD (LEFT) --- */
    .info-card {
        background-color: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .map-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
    }

    /* --- PREMIUM FORM STYLING (RIGHT) --- */
    .form-card {
        background-color: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    /* Input minimalis dengan border bottom tipis pas fokus */
    .form-control-addawn {
        background-color: #f8f9fa;
        border: 1px solid #e2e8f0;
        padding: 14px 18px;
        border-radius: 12px;
        font-size: 14px;
        color: var(--addawn-dark);
        transition: all 0.3s ease;
    }

    .form-control-addawn:focus {
        background-color: #ffffff;
        border-color: var(--addawn-wood);
        box-shadow: 0 0 0 4px rgba(166, 96, 56, 0.1);
        outline: none;
    }

    .btn-submit-message {
        background-color: var(--addawn-dark);
        color: #ffffff;
        font-weight: 700;
        border: none;
        padding: 14px 28px;
        border-radius: 12px;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .btn-submit-message:hover {
        background-color: var(--addawn-wood);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(166, 96, 56, 0.2);
    }
</style>

<div class="contact-header text-center">
    <div class="container">
        <span class="text-uppercase fw-bold tracking-wider small" style="color: var(--addawn-yellow); letter-spacing: 2px;">Get In Touch</span>
        <h1 class="display-5 fw-bold mt-1 text-white">Hubungi Adddawn</h1>
    </div>
</div>

<div class="container px-md-5 py-5 my-3">
    <div class="row g-5">
        
        <div class="col-12 col-lg-6">
            <div class="card info-card p-4 p-md-5 h-100">
                <span class="fw-bold text-uppercase small mb-2 d-inline-block" style="color: var(--addawn-wood); letter-spacing: 0.5px;">
                    <i class="bi bi-geo-alt-fill me-1" style="color: var(--addawn-yellow);"></i> Our Location
                </span>
                <h3 class="fw-bold text-dark mb-3">Adddawn Coffee & Space</h3>
                
                <p class="text-secondary small mb-4" style="line-height: 1.6;">
                    Ruko Bumi Permata Indah Blok R1 No. 19, Meruya, RT.001/RW.012, <br>
                    Karang Mulya, Kec. Karang Tengah, Kota Tangerang, Banten 15157
                </p>

                <div class="map-container mb-4">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.525702657919!2d106.71961667600642!3d-6.194150177790444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f71b21b032ff%3A0x7997ac190c3dc8d1!2sAdddawn%20Cafe!5e0!3m2!1sid!2sid!4v1780883717365!5m2!1sid!2sid" 
                        width="100%" 
                        height="280" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <div class="row g-3 pt-2">
                    <div class="col-6">
                        <div class="small fw-bold text-dark"><i class="bi bi-whatsapp text-success me-1"></i> WhatsApp</div>
                        <div class="text-muted small">+62 878-1560-5433</div>
                    </div>
                    <div class="col-6">
                        <div class="small fw-bold text-dark"><i class="bi bi-envelope-fill text-danger me-1"></i> Email</div>
                        <div class="text-muted small">hello@adddawn.space</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card form-card p-4 p-md-5">
                <span class="fw-bold text-uppercase small mb-2 d-inline-block" style="color: var(--addawn-wood); letter-spacing: 0.5px;">
                    <i class="bi bi-chat-left-text-fill me-1" style="color: var(--addawn-yellow);"></i> Drop a Message
                </span>
                <h3 class="fw-bold text-dark mb-4">Kirim Pesan</h3>

                <form action="{{ route('administrator.message.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control-addawn" placeholder="Masukkan nama kamu" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Whatsapp</label>
                        <input type="number" name="whatsapp" class="form-control form-control-addawn" placeholder="Whatsapp">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Subjek / Perihal</label>
                        <input type="text" name="subject" class="form-control form-control-addawn" placeholder="Contoh: Tanya Sewa Space / Saran Menu">
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-dark">Isi Pesan / Saran</label>
                        <textarea name="message" class="form-control form-control-addawn" rows="4" placeholder="Tulis cerita atau pertanyaanmu untuk Addawn..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-submit-message w-100 shadow-sm">
                        <i class="bi bi-send-fill me-2"></i> Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@include('partials.public.footer')