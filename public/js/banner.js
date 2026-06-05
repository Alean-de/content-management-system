$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadBanners();

    $('#image').on('change', function() {
        let file = this.files[0];
        if (file) {
            $('#preview').attr('src', URL.createObjectURL(file));
        }
    });

    function loadBanners() {
        $.ajax({
            url: '/administrator/banner',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let $tableBody = $('#bannerTableBody');
                $tableBody.empty();

                if (response.data.length === 0) {
                    $tableBody.append(`<tr><td colspan="8" align="center">Belum ada data banner.</td></tr>`);
                    return;
                }

                response.data.forEach(function(banner, index) {
                    let bannerImg = banner.image 
                        ? `/storage/${banner.image}` 
                        : '/images/no-image.png';

                    let statusBadge = banner.is_active 
                        ? '<span style="color: green; font-weight: bold;">Active</span>' 
                        : '<span style="color: red;">Inactive</span>';

                    let rowHtml = `
                        <tr>
                            <td>${index + 1}</td>
                            <td><img src="${bannerImg}" width="120"></td>
                            <td>${banner.title}</td>
                            <td>${banner.subtitle || '-'}</td>
                            <td>${statusBadge}</td>
                            <td>${banner.start_date}</td>
                            <td>${banner.end_date}</td>
                            <td>
                                <a href="/administrator/banner/update/${banner.id}">Edit</a>
                                <button type="button" class="btn-delete" data-id="${banner.id}" style="color:red; cursor:pointer; background:none; border:none; padding:0; margin-left:10px;">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                    $tableBody.append(rowHtml);
                });
            },
            error: function(xhr) {
                console.error('Gagal memuat tabel banner:', xhr.responseJSON);
            }
        });
    }

    $('#formTambahBanner').on('submit', function(e) {
        e.preventDefault();

        let $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true).text('Saving...');

        let formData = new FormData(this);

        $.ajax({
            url: '/administrator/banner/create',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $('#formTambahBanner')[0].reset();
                    $('#preview').attr('src', '');

                    loadBanners();
                }
            },
            error: function(xhr) {
                alert('Gagal menyimpan banner.');
                console.log(xhr.responseJSON);
            },
            complete: function() {
                $submitBtn.prop('disabled', false).text('Save');
            }
        });
    });

    $('#bannerTableBody').on('click', '.btn-delete', function(e) {
        e.preventDefault();

        let bannerId = $(this).data('id');

        if (confirm('Apakah Anda yakin ingin menghapus banner ini?')) {
            let $thisBtn = $(this);
            $thisBtn.prop('disabled', true).text('Deleting...');

            $.ajax({
                url: `/administrator/banner/delete/${bannerId}`,
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        
                        loadBanners();
                    }
                },
                error: function(xhr) {
                    alert('Gagal menghapus banner.');
                    console.log(xhr.responseJSON);
                    $thisBtn.prop('disabled', false).text('Delete');
                }
            });
        }
    });

});