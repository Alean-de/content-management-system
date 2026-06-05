$(document).ready(function() {

    // 1. Setup Token CSRF Global untuk Keamanan AJAX Laravel
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Panggil fungsi muat data tabel galeri saat pertama kali halaman terbuka
    loadGalleries();

    // ID penampung global untuk menahan data galeri yang mau dihapus
    let targetGalleryId = null;

    // 2. Logika Live Preview Gambar Modul Tambah
    $('#gallery-image').on('change', function() {
        let file = this.files[0];
        if (file) {
            $('#gallery-preview').attr('src', URL.createObjectURL(file)).removeClass('d-none');
            $('#icon-placeholder').addClass('d-none');
        }
    });


    // 3. FEATURE: READ DATA KE TABEL GALERI (FIXED RATA TENGAH & MODERN BUTTON)
    function loadGalleries() {
        $.ajax({
            url: '/administrator/gallery', 
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let $tableBody = $('#galleryTableBody');
                $tableBody.empty(); 

                if (response.data.length === 0) {
                    $tableBody.append(`<tr><td colspan="4" class="text-center py-4">Belum ada foto di dalam galeri.</td></tr>`);
                    return;
                }

                response.data.forEach(function(gallery, index) {
                    let imgUrl = gallery.image 
                        ? `/storage/${gallery.image}` 
                        : '/images/no-image.png';

                    // FIX: Button delete diganti pakai standar Bootstrap 5 + Ikon Font-Bi
                    let rowHtml = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>
                                <img src="${imgUrl}" alt="${gallery.title}" style="width: 75px; height: 75px; object-fit: cover;" class="rounded shadow-sm border">
                            </td>
                            <td class="text-center fw-semibold text-dark">${gallery.title}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-danger btn-sm btn-delete d-flex align-items-center gap-1 px-3 py-1.5 rounded-3" data-id="${gallery.id}">
                                        <i class="bi bi-trash3"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                    $tableBody.append(rowHtml);
                });
            },
            error: function(xhr) {
                console.error('Gagal mengambil data galeri:', xhr.responseJSON);
            }
        });
    }


    // 4. FEATURE: CREATE DATA GALERI (ANTI-SPAM)
    $('#formTambahGallery').on('submit', function(e) {
        e.preventDefault();

        let $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...');

        let formData = new FormData(this);

        $.ajax({
            url: '/administrator/gallery/create', 
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#createGallery').modal('hide'); // Tutup modal tambah
                    $('#formTambahGallery')[0].reset();
                    $('#gallery-preview').attr('src', '').addClass('d-none');
                    $('#icon-placeholder').removeClass('d-none');

                    loadGalleries();
                    showToast(response.message || 'Foto berhasil diunggah!', 'success');
                }
            },
            error: function(xhr) {
                showToast('Gagal mengunggah foto.', 'danger');
                console.log(xhr.responseJSON);
            },
            complete: function() {
                $submitBtn.prop('disabled', false).text('Upload Now');
            }
        });
    });


    // 5. FEATURE: TRIGGER MEMBUKA MODAL DELETE DI BLADE
    $('#galleryTableBody').on('click', '.btn-delete', function(e) {
        e.preventDefault();
        
        // Ambil ID dari atribut tombol baris tabel, lalu simpan ke variabel global
        targetGalleryId = $(this).data('id');
        
        // Perintahkan Bootstrap untuk memunculkan modal hapus yang ada di Blade cukk!
        $('#deleteGalleryModal').modal('show');
    });


    // 6. FEATURE: EKSEKUSI HAPUS DATA KETIKA TOMBOL "YA, HAPUS" DI MODAL DIKLIK
    $('#btnConfirmDeleteGallery').on('click', function() {
        if (!targetGalleryId) return;

        let $confirmBtn = $(this);
        $confirmBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Erasing...');

        $.ajax({
            url: `/administrator/gallery/delete/${targetGalleryId}`, 
            method: 'DELETE',
            success: function(response) {
                if (response.success) {
                    $('#deleteGalleryModal').modal('hide'); // Sembunyikan modal konfirmasi
                    loadGalleries(); // Reload isi tabel secara instan
                    showToast(response.message || 'Foto berhasil dihapus dari galeri!', 'success');
                }
            },
            error: function(xhr) {
                $('#deleteGalleryModal').modal('hide');
                showToast('Gagal menghapus foto.', 'danger');
                console.log(xhr.responseJSON);
            },
            complete: function() {
                $confirmBtn.prop('disabled', false).text('Ya, Hapus');
                targetGalleryId = null; // Reset kembali ID penampung sampah
            }
        });
    });


    // 7. GLOBAL TOAST ALERTS (Pengganti alert() jadul browser)
    function showToast(message, type = 'success') {
        let $toast = $('#liveToast');
        $toast.removeClass('text-bg-success text-bg-danger');
        $toast.addClass(type === 'success' ? 'text-bg-success' : 'text-bg-danger');
        $('#toastMessage').text(message);
        bootstrap.Toast.getOrCreateInstance($toast[0]).show();
    }

});