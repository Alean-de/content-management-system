# Addawn Restaurant - Content Management System (CMS) & Branding Website

Selamat datang di repositori proyek website **Addawn Restaurant**. Proyek ini adalah platform berbasis *Content Management System* (CMS) yang dirancang khusus sebagai media branding, promosi digital, dan pengelolaan konten secara mandiri dan efisien.

---

## 📌 Latar Belakang
Di era digital saat ini, kehadiran media online menjadi salah satu faktor penting dalam mendukung branding dan promosi sebuah bisnis. Café dan restoran tidak hanya mengandalkan media sosial seperti Instagram, TikTok, dan Facebook untuk menjangkau pelanggan, tetapi juga memerlukan platform yang mampu menyajikan informasi secara lebih terstruktur dan profesional. Informasi seperti profil usaha, daftar menu, galeri, artikel, serta informasi terbaru sering kali sulit diakses secara optimal apabila hanya disampaikan melalui media sosial.

Oleh karena itu, dikembangkan sebuah website berbasis *Content Management System* (CMS) untuk Addawn Restaurant yang berfungsi sebagai salah satu media branding dan promosi digital. Sistem ini memungkinkan pengelolaan konten website secara mandiri melalui panel administrator tanpa perlu melakukan perubahan langsung pada kode program. Dengan adanya sistem ini, informasi yang ditampilkan kepada pelanggan dapat dikelola dengan lebih mudah, cepat, dan efisien.

## 🎯 Tujuan
Proyek ini bertujuan untuk membangun sebuah website berbasis *Content Management System* (CMS) yang dapat digunakan sebagai salah satu media branding dan promosi digital bagi Addawn Restaurant. Sistem ini dirancang untuk memudahkan administrator dalam mengelola berbagai konten website, seperti menu, kategori menu, artikel, banner, galeri, dan pesan pelanggan melalui satu panel administrasi terpusat. Selain itu, website ini diharapkan dapat membantu meningkatkan kredibilitas bisnis, memperluas jangkauan informasi kepada pelanggan, serta mendukung kebutuhan publikasi dan promosi secara digital.

---

## 🚀 Fitur Utama
* **Authentication & Authorization:** Sistem login aman untuk administrator.
* **Manajemen Menu:** Operasi CRUD (*Create, Read, Update, Delete*) untuk menu restoran.
* **Manajemen Kategori:** Pengelompokan menu yang dinamis.
* **Manajemen Artikel/Berita:** Publikasi konten artikel atau promosi terbaru.
* **Manajemen Banner Website:** Pengaturan visual *hero component* pada halaman utama.
* **Manajemen Galeri Foto:** Media dokumentasi visual suasana dan fasilitas restoran.
* **Manajemen Pesan:** Menampung dan mengelola feedback dari pengunjung website.
* **Image Upload Handling:** Manajemen file gambar langsung melalui panel admin.
* **AJAX Search:** Pencarian data real-time tanpa *reload* halaman untuk pengalaman pengguna yang interaktif.
* **Pagination:** Pembagian halaman data untuk performa yang lebih efisien.
* **Responsive UI:** Antarmuka yang optimal diakses melalui desktop, tablet, maupun perangkat mobile.

---

## ⚖️ Analisis Sistem (Kelebihan & Kelemahan)

### Kelebihan
1. **Dynamic CMS Concept:** Konten dapat diperbarui kapan saja tanpa menyentuh atau mengubah kode program.
2. **Centralized Panel:** Pengelolaan seluruh informasi website terpusat dalam satu dashboard admin.
3. **Optimized Branding:** Memudahkan promosi digital secara real-time lewat banner, artikel, dan galeri terintegrasi.
4. **Interactive UX:** Implementasi AJAX meminimalisir *page reload* pada beberapa fungsi manajemen data.
5. **Modern Architecture:** Menggunakan framework Laravel yang membuat struktur kode rapi, aman, dan mudah dipelihara (*maintainable*).

### Kelemahan
1. Belum mendukung transaksi, e-commerce, atau pemesanan online secara langsung.
2. Belum tersedia sistem manajemen *role* dan *permission* tingkat lanjut (Multi-author/Multi-role).
3. Belum dilengkapi dengan notifikasi email otomatis untuk setiap pesan masuk.
4. Belum memiliki fitur analitik pengunjung internal atau laporan statistik grafis.
5. Optimasi performa dan keamanan masih perlu ditingkatkan jika ingin digunakan untuk skala produksi massal.
6. Belum mendukung integrasi dengan layanan pihak ketiga seperti *payment gateway* atau sistem reservasi meja.
7. Fitur SEO (*Search Engine Optimization*) lanjutan belum diimplementasikan secara penuh.

---

## 🔮 Pengembangan Selanjutnya (Roadmap)
Beberapa pengembangan yang direncanakan pada versi berikutnya antara lain:
* [ ] **Head Administrator Role:** Implementasi akun super admin untuk mengelola akun administrator lainnya.
* [ ] **Account Approval:** Sistem persetujuan akun registrasi baru sebelum mendapatkan akses masuk ke CMS.
* [ ] **Granular Role & Permission:** Penerapan hak akses yang lebih fleksibel sesuai struktur organisasi.
* [ ] **Email Notification:** Penambahan notifikasi email (misalnya via SMTP/Mailgun) untuk pesan masuk dan aktivitas krusial.
* [ ] **Analytics Dashboard:** Integrasi visual grafik untuk memantau statistik aktivitas pengunjung website.
* [ ] **Audit Log:** Pencarian jejak digital tindakan dan aktivitas yang dilakukan oleh para administrator.
* [ ] **Security & Performance Tuning:** Optimasi keamanan (SQL Injection, XSS protection lanjutan) dan *caching* data.
* [ ] **Advanced SEO:** Pengaturan meta tags otomatis, sitemap generator, dan optimasi kecepatan *loading*.
* [ ] **Online Reservation:** Integrasi fitur reservasi tempat atau pemesanan menu online.
* [ ] **REST API Development:** Penyediaan endpoint API untuk mendukung integrasi dengan aplikasi mobile atau sistem pihak ketiga.

---

## 🛠️ Teknologi yang Digunakan

### **Backend**
* **Language:** PHP
* **Framework:** Laravel 13

### **Frontend**
* **Markup & Styling:** HTML, CSS, Bootstrap 5
* **Scripting & Library:** JavaScript, jQuery
* **Templating Engine:** Blade Template Engine (Laravel)

### **Database**
* **DBMS:** MySQL

### **Tools & Environment**
* **Database Management:** phpMyAdmin
* **Version Control:** Git
* **Repository Hosting:** GitHub

---

## 📸 Dokumentasi & Antarmuka (Screenshots)

Berikut adalah beberapa tampilan antarmuka dari website dan panel CMS Addawn Restaurant:

### Halaman Utama / Landing Page
*Halaman depan yang diakses oleh pelanggan, menampilkan banner, menu pilihan, artikel, galeri, dan formulir kontak.*
```
[Tempatkan Foto Landing Page di Sini]
Contoh tag markdown: ![Landing Page](path/to/image/landing-page.png)
```

### Dashboard Administrator
*Halaman utama panel kontrol admin yang memberikan ringkasan data masuk dan navigasi manajemen.*
```
[Tempatkan Foto Dashboard Admin di Sini]
Contoh tag markdown: ![Dashboard Admin](path/to/image/dashboard.png)
```

### Manajemen Menu & Kategori
*Fitur CRUD data menu makanan/minuman beserta pengelompokan kategorinya.*
```
[Tempatkan Foto Manajemen Menu di Sini]
Contoh tag markdown: ![Manajemen Menu](path/to/image/manajemen-menu.png)
```

### Manajemen Artikel & Berita
*Antarmuka untuk membuat, mengubah, dan menghapus artikel promosi.*
```
[Tempatkan Foto Manajemen Artikel di Sini]
Contoh tag markdown: ![Manajemen Artikel](path/to/image/manajemen-artikel.png)
```

### Manajemen Galeri, Banner, & Pesan
*Halaman kontrol visual konten statis dan pengelolaan feedback pengunjung.*
```
[Tempatkan Foto Halaman Manajemen Lainnya di Sini]
Contoh tag markdown: ![Manajemen Konten](path/to/image/manajemen-lain.png)
```

---

## 👥 Kontributor
Proyek ini dikembangkan secara mandiri sebagai bagian dari proses pembelajaran, eksplorasi teknologi *web development*, dan pengembangan portofolio pribadi.

* **Developer:** Ndoo