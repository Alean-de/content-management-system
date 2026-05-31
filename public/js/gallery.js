$(document).ready(function() {

    // 1. Setup Token CSRF Global untuk Keamanan AJAX Laravel
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Panggil fungsi muat data tabel galeri saat pertama kali halaman terbuka
    loadGalleries();

    // 2. Logika Live Preview Gambar Bawaan Kamu (Konversi JQuery)
    $('#gallery-image').on('change', function() {
        let file = this.files[0];
        if (file) {
            $('#gallery-preview').attr('src', URL.createObjectURL(file));
        }
    });


    // 3. FEATURE: READ DATA KE TABEL GALERI
    function loadGalleries() {
        $.ajax({
            url: '/administrator/gallery', // Jalur rute indeks utama
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let $tableBody = $('#galleryTableBody');
                $tableBody.empty(); // Kosongkan baris lama sebelum dicetak ulang

                if (response.data.length === 0) {
                    $tableBody.append(`<tr><td colspan="4" align="center">Belum ada foto di dalam galeri.</td></tr>`);
                    return;
                }

                response.data.forEach(function(gallery, index) {
                    let imgUrl = gallery.image 
                        ? `/storage/${gallery.image}` 
                        : '/images/no-image.png';

                    let rowHtml = `
                        <tr>
                            <td>${index + 1}</td>
                            <td><img src="${imgUrl}" width="100"></td>
                            <td>${gallery.title}</td>
                            <td>
                                <button type="button" class="btn-delete" data-id="${gallery.id}" style="color:red; cursor:pointer; background:none; border:none; padding:0;">
                                    Delete
                                </button>
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

        // Kunci tombol biar dosen gak lihat server kena hit duplikat pas di-spam klik
        let $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true).text('Uploading...');

        let formData = new FormData(this);

        $.ajax({
            url: '/administrator/gallery/create', // Sesuaikan URL post route kamu
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    
                    // Bersihkan form & preview gambar sisa upload
                    $('#formTambahGallery')[0].reset();
                    $('#gallery-preview').attr('src', '');

                    // Sinkronisasi tabel instan tanpa kedip reload!
                    loadGalleries();
                }
            },
            error: function(xhr) {
                alert('Gagal mengunggah foto.');
                console.log(xhr.responseJSON);
            },
            complete: function() {
                // Buka kembali akses tombol simpan
                $submitBtn.prop('disabled', false).text('Upload');
            }
        });
    });


    // 5. FEATURE: DELETE DATA GALERI (INSTAN & DELEGASI)
    $('#galleryTableBody').on('click', '.btn-delete', function(e) {
        e.preventDefault();

        let galleryId = $(this).data('id');

        if (confirm('Apakah Anda yakin ingin menghapus foto ini dari galeri?')) {
            let $thisBtn = $(this);
            $thisBtn.prop('disabled', true).text('Deleting...');

            $.ajax({
                url: `/administrator/gallery/delete/${galleryId}`, // Sesuaikan rute delete kamu
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        // Refresh isi tabel secara dinamis
                        loadGalleries();
                    }
                },
                error: function(xhr) {
                    alert('Gagal menghapus foto.');
                    console.log(xhr.responseJSON);
                    $thisBtn.prop('disabled', false).text('Delete');
                }
            });
        }
    });

});