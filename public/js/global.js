// ==========================================
// 1. DETEKSI DINI ANTI-FLICKER (Taruh Paling Atas, di luar DOMContentLoaded)
// ==========================================
(function () {
    // Ambil tema dari localStorage khusus admin, jika tidak ada default ke 'light'
    const savedTheme = localStorage.getItem('admin-theme') || 'light';
    
    // Terapkan langsung ke tag <html> sebelum element body sempat digambar browser
    document.documentElement.setAttribute('data-bs-theme', savedTheme);
})();


// ==========================================
// 2. LOGIC JALAN SETELAH DOM SELESAI DIMUAT
// ==========================================
document.addEventListener('DOMContentLoaded', () => {

    // --- LOGIC BUTTON DELETE BAWAAN KAMU ---
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const confirmDelete = confirm('Yakin ingin menghapus data?');
            if (!confirmDelete) {
                e.preventDefault();
            }
        });
    });

    // --- LOGIC TOGGLE DARK MODE BARU ---
    const toggleBtn = document.getElementById('btnDarkModeToggle');
    const icon = document.getElementById('darkModeIcon');

    // Pastikan skrip ini hanya dieksekusi jika tombol toggle ada di halaman (khusus admin)
    if (toggleBtn && icon) {
        
        // Fungsi sinkronisasi icon matahari / bulan
        function syncIcon(theme) {
            if (theme === 'dark') {
                icon.className = 'bi bi-moon-stars-fill fs-5 text-info';
                toggleBtn.className = 'btn btn-link text-info p-2 rounded-3 text-decoration-none shadow-none border-0 d-flex align-items-center justify-content-center';
            } else {
                icon.className = 'bi bi-sun-fill fs-5 text-warning';
                toggleBtn.className = 'btn btn-link text-secondary p-2 rounded-3 text-decoration-none shadow-none border-0 d-flex align-items-center justify-content-center';
            }
        }

        // Jalankan sinkronisasi ikon pertama kali saat halaman dibuka
        const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
        syncIcon(currentTheme);

        // Event klik pada tombol toggle
        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();

            const activeTheme = document.documentElement.getAttribute('data-bs-theme');
            let newTheme = 'light';

            if (activeTheme === 'light') {
                newTheme = 'dark';
            }

            // Terapkan tema baru ke tag <html> dan simpan di memori browser
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('admin-theme', newTheme);

            // Perbarui visual ikon secara instan
            syncIcon(newTheme);
        });
    }

});