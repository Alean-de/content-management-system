<!-- ==========================================
     COMPONENT: MODERN COZY PUBLIC FOOTER (ADDAWN)
     ========================================== -->
<footer class="pt-5 pb-3 text-white" style="background-color: #121212; font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="container px-md-5">
        <div class="row g-4 justify-content-between">
            
            <!-- KOLOM 1: BRANDING & JAM OPERASIONAL -->
            <div class="col-12 col-md-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center shadow-sm" 
                         style="width: 32px; height: 32px; background-color: #a66038;">
                        <i class="bi bi-cup-hot-fill" style="font-size: 13px; color: #f2cb05;"></i>
                    </div>
                    <span class="fw-bold fs-5 tracking-tight text-white" style="letter-spacing: -0.5px;">
                        adddawn
                    </span>
                </div>
                <p class="text-white-50 small mb-4" style="line-height: 1.6; max-width: 300px;">
                    Temukan kenyamanan, cerita, dan kehangatan dalam setiap kunjungan.
                </p>
                <!-- Info Jam Buka (Biar Makin Kaya Konten) -->
                <div class="small text-white-50">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="bi bi-clock text-warning"></i>
                        <span><strong>Sun - Thur:</strong> 09:00 AM - 07:00 PM</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-warning"></i>
                        <span><strong>Fri - Sat:</strong> 10:00 AM - 08:00 PM</span>
                    </div>
                </div>
            </div>

            <!-- KOLOM 2: DUA BLOK NAVIGASI AKTIF (8 PAGES SYSTEM) -->
            <div class="col-12 col-sm-6 col-md-4">
                <h6 class="fw-bold text-uppercase tracking-wider mb-3" style="color: #f2cb05; font-size: 12px; letter-spacing: 1px;">
                    Quick Navigation
                </h6>
                <div class="row g-2">
                    <!-- Navigasi Kiri -->
                    <div class="col-6">
                        <ul class="list-unstyled d-flex flex-column gap-2 small">
                            <li><a href="{{ route('index') }}" class="footer-public-link">Home</a></li>
                            <li><a href="{{ route('public.aboutUs') }}" class="footer-public-link">About Us</a></li>
                            <li><a href="{{ route('public.drink') }}" class="footer-public-link">Beverages</a></li>
                            <li><a href="{{ route('public.food') }}" class="footer-public-link">Food</a></li>
                        </ul>
                    </div>
                    <!-- Navigasi Kanan -->
                    <div class="col-6">
                        <ul class="list-unstyled d-flex flex-column gap-2 small">
                            <li><a href="{{ route('public.article') }}" class="footer-public-link">Articles</a></li>
                            <li><a href="{{ route('public.messageLoc') }}" class="footer-public-link">Locations</a></li>
                            <li><a href="{{ route('public.gallery') }}" class="footer-public-link">Gallery</a></li>
                            <li><a href="{{ route('public.article') }}" class="footer-public-link">Latest Events</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- KOLOM 3: SOSMED & HUBUNGI LANGSUNG -->
            <div class="col-12 col-sm-6 col-md-3">
                <h6 class="fw-bold text-uppercase tracking-wider mb-3" style="color: #f2cb05; font-size: 12px; letter-spacing: 1px;">
                    Connect With Us
                </h6>
                <p class="text-white-50 small mb-3">Ikuti keseruan event, promo mingguan, dan menu baru kami di sosial media.</p>
                
                <!-- Kumpulan Ikon Sosial Media Interaktif -->
                <div class="d-flex gap-2 mb-4">
                    <a href="https://www.instagram.com/add.dawn?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="sosmed-icon-box" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://www.tiktok.com/@adddawn.caf.west?is_from_webapp=1&sender_device=pc" target="_blank" class="sosmed-icon-box" title="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                    <a href="https://www.facebook.com/adddawncafe/?ref=PROFILE_EDIT_xav_ig_profile_page_web#" target="_blank" class="sosmed-icon-box" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- GARIS BATAS BAWAH & COPYRIGHT -->
        <div class="mt-5 pt-3 border-top border-secondary border-opacity-25 text-center small text-white-50">
            <div>
                &copy; {{ date('Y') }}
                <span class="fw-semibold text-white">Addawn Restaurant</span>.
                All rights reserved.
            </div>
        </div>
    </div>
</footer>

<!-- --- CUSTOM CSS STYLE UNTUK ELEMENT FOOTER PUBLIC --- -->
<style>
    /* Desain Tautan Navigasi Footer */
    .footer-public-link {
        color: rgba(255, 255, 255, 0.6) !important;
        text-decoration: none;
        transition: all 0.25s ease;
        display: inline-block;
    }

    /* Efek Hover Navigasi: Berubah jadi Kuning Addawn & Geser Kanan Dikit */
    .footer-public-link:hover {
        color: #f2cb05 !important;
        transform: translateX(4px);
    }

    /* Kotak Ikon Sosial Media Bulat Minimalis */
    .sosmed-icon-box {
        width: 38px;
        height: 38px;
        background-color: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        font-size: 16px;
    }

    /* Efek Hover Sosmed: Membesar, Background Kuning, Ikon Hitam */
    .sosmed-icon-box:hover {
        background-color: #f2cb05;
        color: #121212;
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 5px 15px rgba(242, 203, 5, 0.3);
    }
</style>