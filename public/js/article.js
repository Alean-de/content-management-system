$(document).ready(function() {

    // 1. Setup CSRF Token Global
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Panggil tabel saat halaman pertama dimuat
    loadArticles();

    // 2. Live Preview Thumbnail & Character Counter (Gabungan)
    $('#thumbnail').on('change', function() {
        let file = this.files[0];
        if (file) {
            $('#thumbnail-preview').attr('src', URL.createObjectURL(file));
        }
    });

    $('#content').on('input', function() {
        let len = this.value.length;
        $('#counter').text(len);
    });

    // 3. FEATURE: READ DATA KE TABEL
    function loadArticles() {
        $.ajax({
            url: '/administrator/article', // Menembak route index utama
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let $tableBody = $('#articleTableBody');
                $tableBody.empty();

                if (response.data.length === 0) {
                    $tableBody.append(`<tr><td colspan="6" align="center">Belum ada artikel.</td></tr>`);
                    return;
                }

                response.data.forEach(function(article, index) {
                    let thumbUrl = article.thumbnail 
                        ? `/storage/${article.thumbnail}` 
                        : '/images/no-image.png';

                    let rowHtml = `
                        <tr>
                            <td>${index + 1}</td>
                            <td><img src="${thumbUrl}" width="100"></td>
                            <td>${article.title}</td>
                            <td>${article.user ? article.user.name : 'Unknown'}</td>
                            <td>${article.published_at || '-'}</td>
                            <td>
                                <a href="/administrator/article/update/${article.id}">Edit</a>
                                <button type="button" class="btn-delete" data-id="${article.id}" style="color:red; cursor:pointer; background:none; border:none; padding:0; margin-left:10px;">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                    $tableBody.append(rowHtml);
                });
            },
            error: function(xhr) {
                console.error('Gagal mengambil data artikel:', xhr.responseJSON);
            }
        });
    }

    // 4. FEATURE: CREATE DATA (ANTI-SPAM)
    $('#formTambahArticle').on('submit', function(e) {
        e.preventDefault();

        let $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true).text('Adding Article...');

        let formData = new FormData(this);

        $.ajax({
            url: '/administrator/article/create',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $('#formTambahArticle')[0].reset();
                    $('#thumbnail-preview').attr('src', '');
                    $('#counter').text('0');

                    // Sinkronisasi instan! Ambil ulang data tabel terbaru
                    loadArticles();
                }
            },
            error: function(xhr) {
                alert('Gagal menyimpan artikel.');
                console.log(xhr.responseJSON);
            },
            complete: function() {
                $submitBtn.prop('disabled', false).text('Add Article');
            }
        });
    });

    // 5. FEATURE: DELETE DATA (INSTAN & TERDELEGASI)
    $('#articleTableBody').on('click', '.btn-delete', function(e) {
        e.preventDefault();
        
        let articleId = $(this).data('id');
        
        if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
            let $thisBtn = $(this);
            $thisBtn.prop('disabled', true).text('Deleting...');

            $.ajax({
                url: `/administrator/article/delete/${articleId}`,
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        // Ambil ulang data tabel terbaru tanpa kedip
                        loadArticles();
                    }
                },
                error: function(xhr) {
                    alert('Gagal menghapus artikel.');
                    console.log(xhr.responseJSON);
                    $thisBtn.prop('disabled', false).text('Delete');
                }
            });
        }
    });

});