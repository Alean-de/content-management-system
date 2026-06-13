# Cafe CMS & Promotion Platform

Platform *Content Management System* (CMS) berbasis web yang dirancang khusus untuk mengelola konten dan membantu promosi cafe lokal, sekaligus menjadi media untuk meningkatkan *personal branding*.

---

## 1. Latar Belakang
Banyak cafe lokal yang memiliki potensi besar namun menghadapi kesulitan dalam menjangkau audiens yang lebih luas karena keterbatasan media promosi. Proyek ini hadir sebagai solusi untuk **membantu mendongkrak ekonomi cafe lokal** dengan menyediakan platform CMS promosi yang efektif, terstruktur, dan mudah dikelola oleh pihak manajemen cafe.

## 2. Tujuan
* **Pemberdayaan Ekonomi Lokal:** Menyediakan platform digital khusus untuk mempublikasikan menu, suasana, dan fasilitas cafe lokal agar lebih dikenal luas.
* **Meningkatkan Personal Branding:** Berfungsi sebagai portofolio pengembangan aplikasi yang nyata, terstruktur, dan siap pakai.
* **Manajemen Konten yang Efektif:** Memudahkan pihak cafe dalam memperbarui informasi secara berkala tanpa perlu memahami hal teknis.

## 3. Kelebihan
* **Fokus Terhadap CMS:** Sistem murni berfokus pada manajemen konten (tanpa beban fitur POS), membuat performa aplikasi lebih ringan dan efisien.
* **Antarmuka yang Dinamis:** Menggabungkan interaktivitas halaman dengan manipulasi DOM yang responsif menggunakan jQuery dan AJAX.
* **Kemudahan Pengelolaan:** Struktur navigasi admin dirancang agar *user-friendly* bagi pengelola konten.

## 4. Fitur Saat Ini (Sisi Admin)
Sebagai platform CMS murni, seluruh fitur yang tersedia saat ini berfokus pada pengelolaan konten internal melalui panel Admin:

* **Authentication:** Sistem login dan registrasi dasar untuk mengamankan akses masuk ke panel *dashboard* admin.
* **Manajemen Menu:** Fitur CRUD lengkap untuk mengelola daftar menu kuliner cafe, deskripsi, harga, serta foto produk.
* **Manajemen Artikel:** Pengelolaan konten artikel/berita seputar event, promo, atau info terbaru terkait cafe.
* **Manajemen Banner:** Mengatur visual banner utama (slider/hero image) yang digunakan sebagai media promosi visual di halaman depan.
* **Manajemen Gallery:** Dokumentasi foto suasana, fasilitas, dan keunikan cafe untuk menarik minat pelanggan.
* **Manajemen Kategori:** Sistem pengelompokan yang dinamis untuk merapikan data menu maupun artikel agar lebih terstruktur.
* **Manajemen Pesan:** Menampung dan mengelola pesan masuk, kritik, saran, atau inquiries dari pelanggan/pengunjung web.
* **REST API (JSON/XML):** Menyediakan endpoint API berbasis JSON atau XML yang siap pakai, memudahkan integrasi atau distribusi data CMS ini ke platform/aplikasi lain di masa mendatang.

## 5. Kekurangan & Celah Keamanan Saat Ini
* **Belum Menerapkan RBAC:** Sistem otorisasi belum berjalan, sehingga belum ada pemisahan hak akses yang jelas antara pemilik platform dan pengelola harian.
* **Akses Admin Terbuka:** Pengguna luar (di luar manajemen) saat ini masih dapat mengakses halaman atau fungsi administratif secara langsung.

## 🔮 6. Rencana Pengembangan (Roadmap & Next Targets)

### v1.1 Security Foundation
* **Fitur:** RBAC (Owner & Admin), Account Approval, Role Middleware, Approval Middleware, Login Rate Limiting, File Validation Hardening.
* **Target:** Semua user tidak lagi memiliki akses yang sama.

### v1.2 Content Workflow
* **Fitur:** Draft, Review, Approved, Published, Rejected, Archived, Scheduled Publish, Auto Archive.
* **Target:** Konten tidak lagi langsung tayang setelah dibuat.

### v1.3 Monitoring & Audit
* **Fitur:** Activity Log, Approval History, Notification, Dashboard Summary.
* **Target:** Owner tahu siapa melakukan apa.

### v1.4 Code Quality & Architecture (Refactoring)
* **Fitur:** Form Request Validation, Service Layer (opsional), Reusable Upload Service, Reusable Activity Logger.
* **Target:** Mengurangi duplikasi kode sebelum fitur makin banyak. Mengingat pola controller yang mulai berulang, melakukan refactoring sejak awal akan mencegah kompleksitas kode yang berlebihan daripada menundanya sampai belasan controller selesai dibuat.

### v1.5 Security Hardening
* **Fitur:** XSS Sanitization, Security Headers, Email Verification, Owner 2FA, Cloudflare Integration.
* **Target:** Memperkuat keamanan aplikasi yang sudah berjalan.

### v1.6 Performance Optimization
* **Fitur:** Image Compression, Thumbnail Generation, Cache, Query Optimization, Lazy Loading.
* **Target:** Menjaga performa sistem agar tetap optimal saat traffic dan volume data bertambah.

### v1.7 Marketing & SEO
* **Fitur:** Dynamic Meta Tags, Sitemap, robots.txt, Open Graph, Structured Data.
* **Target:** Meningkatkan *discoverability* dan visibilitas platform di mesin pencari.

### v2.0 Business Insight
* **Fitur:** Rating Menu, Most Viewed Article, Most Viewed Menu, Click Tracking, Recommendation Section.
* **Target:** Mengubah peran platform dari sekadar CMS pasif menjadi alat bantu pengambilan keputusan bisnis yang strategis.

### v3.0 Enterprise Expansion
* **Fitur:** POS Integration, Inventory, Purchase Order, Supplier, Best Seller Analysis.
* **Target:** Transformasi skala besar dari aplikasi CMS promosi biasa menjadi **Cafe Management System** end-to-end yang komprehensif.

## 7. Tech Stack (Teknologi yang Digunakan)
* **Framework Backend:** Laravel
* **Templating Engine:** Blade
* **Frontend Scripting:** JavaScript (jQuery / AJAX)
* **Database:** MySQL

## 8. Kesimpulan
Platform ini merupakan solusi CMS yang potensial untuk mengdigitalisasi data promosi cafe lokal. Meskipun saat ini masih memiliki keterbatasan keamanan karena belum adanya pembatasan akses, rencana implementasi RBAC (Owner & Admin) serta sistem approval konten akan mengubah platform ini menjadi sistem manajemen yang aman, tepercaya, dan siap diimplementasikan secara profesional.
