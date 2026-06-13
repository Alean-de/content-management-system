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

## 6. Rencana Pengembangan (Roadmap)
* **Implementasi RBAC (Role-Based Access Control):** Menambahkan pembagian hak akses yang tegas antara dua *role* utama:
  * **Owner:** Memegang kendali penuh atas sistem, persetujuan akun, dan moderasi akhir.
  * **Admin:** Bertugas mengelola konten harian cafe (menu, event, detail informasi).
* **Sistem Approval Pendaftaran Akun:** Pendaftaran akun Admin baru wajib melalui persetujuan (*approval*) dari Owner terlebih dahulu sebelum bisa mengakses *dashboard*.
* **Moderasi Konten & Validasi Foto:** Semua unggahan foto dari Admin wajib melewati kurasi atau *approval* Owner guna menghindari konten yang tidak sesuai aturan (seperti konten 18+, web judi, atau gambar *corrupt*).
  * **Aturan Validasi Berkas:** Format gambar dibatasi ketat hanya menerima file berekstensi `jpg`, `jpeg`, dan `png` dengan batas ukuran maksimal tertentu (maks. 2048 KB) sebelum diajukan ke Owner.

## 7. Tech Stack (Teknologi yang Digunakan)
* **Framework Backend:** Laravel
* **Templating Engine:** Blade
* **Frontend Scripting:** JavaScript (jQuery / AJAX)
* **Database:** MySQL

## 8. Kesimpulan
Platform ini merupakan solusi CMS yang potensial untuk mengdigitalisasi data promosi cafe lokal. Meskipun saat ini masih memiliki keterbatasan keamanan karena belum adanya pembatasan akses, rencana implementasi RBAC (Owner & Admin) serta sistem approval konten akan mengubah platform ini menjadi sistem manajemen yang aman, tepercaya, dan siap diimplementasikan secara profesional.
