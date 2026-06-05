// Setup CSRF & Load Pertama
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadBanners();
});

let targetBannerId = null;
let currentSearch = '';
let currentStatus = '';

// Listener Kolom Search
$('#search').on('keyup', function() {
    currentSearch = $(this).val();
    loadBanners(1, currentSearch, currentStatus);
});

// Listener Dropdown Filter Status
$('#filterStatus').on('change', function() {
    currentStatus = $(this).val();
    loadBanners(1, currentSearch, currentStatus);
});

// Image Preview Upload Handler
document.addEventListener('DOMContentLoaded', () => {
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');
    const iconPlaceholder = document.getElementById('icon-placeholder');

    if(imageInput && preview){
        imageInput.addEventListener('change', () => {
            const file = imageInput.files[0];
            if(file){
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
                if(iconPlaceholder) iconPlaceholder.classList.add('d-none');
            }
        });
    }

    const editImageInput = document.getElementById('edit-image');
    const editPreview = document.getElementById('edit-preview');

    if(editImageInput && editPreview){
        editImageInput.addEventListener('change', () => {
            const file = editImageInput.files[0];
            if(file){
                editPreview.src = URL.createObjectURL(file);
            }
        });
    }
});

// Function Load Banners via AJAX
function loadBanners(page = 1, search = '', status = '') {
    $.ajax({
        url: `/administrator/banner/?page=${page}&search=${encodeURIComponent(search)}&status=${status}`,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            let $tableBody = $('#bannerTableBody');
            $tableBody.empty();

            if (response.data.length === 0) {
                $tableBody.append(`<tr><td colspan="8" class="text-center py-4">Belum ada data spanduk banner.</td></tr>`);
                $('#paginationContainer').empty();
                return;
            }

            response.data.forEach(function(item, index) {
                let imgUrl = item.image ? `/storage/${item.image}` : '/images/no-image.png';
                
                // Format Badge Status Keaktifan (Modern Soft Badge)
                let statusBadge = item.is_active == 1 
                    ? `<span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Aktif</span>` 
                    : `<span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Tidak Aktif</span>`;
                
                // Format Tanggal Rapi Indonesia (Misal: 05 Jun 2026)
                let formatDate = (dateStr) => {
                    if(!dateStr) return '-';
                    let d = new Date(dateStr);
                    return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                };

                // Kalkulasi nomor urut baris (Aman dari bug NaN)
                let currentPage = response.current_page || 1;
                let rowNumber = ((currentPage - 1) * 10) + (index + 1);

                let rowHtml = `
                    <tr>
                        <td>${rowNumber}</td>
                        <td>
                            <img src="${imgUrl}" alt="Banner" style="width: 140px; height: 65px; object-fit: cover;" class="rounded shadow-sm">
                        </td>
                        <td class="text-start fw-bold text-dark">${item.title}</td>
                        <td class="text-start text-muted">${item.subtitle || '-'}</td>
                        <td>${statusBadge}</td>
                        <td>${formatDate(item.start_date)}</td>
                        <td>${formatDate(item.end_date)}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" 
                                        class="btn btn-warning btn-sm btn-edit" 
                                        data-id="${item.id}"
                                        data-title="${item.title}"
                                        data-subtitle="${item.subtitle || ''}"
                                        data-start="${item.start_date || ''}"
                                        data-end="${item.end_date || ''}"
                                        data-active="${item.is_active}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${item.id}">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                $tableBody.append(rowHtml);
            });

            renderPagination(response.current_page, response.last_page);
        },
        error: function(xhr) {
            console.error('Gagal memuat data banner:', xhr.responseJSON);
        }
    });
}

// Function Render Pagination Buttons
function renderPagination(currentPage, lastPage) {
    let $pagination = $('#paginationContainer');
    $pagination.empty();

    if (lastPage <= 1) return;

    let prevDisabled = (currentPage === 1) ? 'disabled' : '';
    $pagination.append(`<li class="page-item ${prevDisabled}"><a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a></li>`);

    for (let i = 1; i <= lastPage; i++) {
        let activeClass = (i === currentPage) ? 'active' : '';
        $pagination.append(`<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`);
    }

    let nextDisabled = (currentPage === lastPage) ? 'disabled' : '';
    $pagination.append(`<li class="page-item ${nextDisabled}"><a class="page-link" href="#" data-page="${currentPage + 1}">Next</a></li>`);
}

// Event Paginasi Click
$('#paginationContainer').on('click', '.page-link', function(e) {
    e.preventDefault();
    let targetPage = $(this).data('page');
    if (targetPage) {
        loadBanners(targetPage, currentSearch, currentStatus);
    }
});

// Action Form Create Submit via AJAX
$('#formTambahBanner').on('submit', function(e) {
    e.preventDefault();
    let $submitBtn = $(this).find('button[type="submit"]');
    $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

    let formData = new FormData(this);

    $.ajax({
        url: '/administrator/banner/create/',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if(response.success) {
                $('#createBanner').modal('hide');
                $('#formTambahBanner')[0].reset();
                $('#preview').addClass('d-none');
                $('#icon-placeholder').removeClass('d-none');
                loadBanners();
                showToast(response.message || 'Banner promo berhasil disimpan!', 'success');
            } else {
                showToast(response.message || 'Gagal menyimpan banner.', 'danger');
            }
        },
        error: function(xhr) {
            $('#createBanner').modal('hide');
            showToast('Gagal memproses data banner.', 'danger');
        },
        complete: function() {
            $submitBtn.prop('disabled', false).text('Save Banner');
        }
    });
});

// Populate Edit Modal Banner (Menangkap data dari baris tabel ke form modal)
$('#bannerTableBody').on('click', '.btn-edit', function() {
    let id = $(this).data('id');
    let title = $(this).data('title');
    let subtitle = $(this).data('subtitle');
    let start = $(this).data('start');
    let end = $(this).data('end');
    let active = $(this).data('active'); // Mengambil data-active="${item.is_active}"
    let currentThumbUrl = $(this).closest('tr').find('img').attr('src');

    // Tembak data ke element form modal edit
    $('#edit-id').val(id);
    $('#edit-title').val(title);
    $('#edit-subtitle').val(subtitle);
    $('#edit-start_date').val(start); // Memastikan format YYYY-MM-DD masuk ke input date
    $('#edit-end_date').val(end);
    $('#edit-preview').attr('src', currentThumbUrl);

    // Sinkronisasi status Switch Toggle Aktif/Tidak Aktif
    if (active == 1) {
        $('#edit-is-active').prop('checked', true);
    } else {
        $('#edit-is-active').prop('checked', false);
    }

    $('#formUpdateBanner').attr('action', `/administrator/banner/update/${id}`);
    $('#updateBanner').modal('show');
});

// Action Form Update Submit via AJAX (FIXED FORCED DATA PASSING)
$('#formUpdateBanner').on('submit', function(e) {
    e.preventDefault();
    let $submitBtn = $(this).find('button[type="submit"]');
    $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');

    let formData = new FormData(this);
    formData.append('_method', 'PUT');

    let actionUrl = $(this).attr('action');

    $.ajax({
        url: actionUrl,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if(response.success) {
                $('#updateBanner').modal('hide');
                loadBanners();
                showToast(response.message || 'Banner berhasil diperbarui!', 'success');
            } else {
                showToast(response.message || 'Gagal merubah data.', 'danger');
            }
        },
        error: function(xhr) {
            $('#updateBanner').modal('hide');
            showToast('Gagal memperbarui data banner.', 'danger');
        },
        complete: function() {
            $submitBtn.prop('disabled', false).text('Simpan Perubahan');
        }
    });
});

// Trigger Delete Modal Confirmation
$('#bannerTableBody').on('click', '.btn-delete', function() {
    targetBannerId = $(this).data('id');
    $('#deleteBannerModal').modal('show');
});

// Confirm Delete Banner Action via AJAX
$('#btnConfirmDeleteBanner').on('click', function() {
    if (!targetBannerId) return;
    let $confirmBtn = $(this);
    $confirmBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');

    $.ajax({
        url: `/administrator/banner/delete/${targetBannerId}`,
        method: 'DELETE',
        success: function(response) {
            if(response.success) {
                $('#deleteBannerModal').modal('hide');
                loadBanners();
                showToast(response.message || 'Banner berhasil dihapus permanen!', 'success');
            } else {
                showToast(response.message || 'Gagal menghapus data.', 'danger');
            }
        },
        error: function(xhr) {
            $('#deleteBannerModal').modal('hide');
            showToast('Kesalahan server saat memproses hapus.', 'danger');
        },
        complete: function() {
            $confirmBtn.prop('disabled', false).text('Ya, Hapus');
            targetBannerId = null;
        }
    });
});

// Function Show Toast Notification (Pojok Kanan Bawah)
function showToast(message, type = 'success') {
    let $toast = $('#liveToast');
    $toast.removeClass('text-bg-success text-bg-danger');
    $toast.addClass(type === 'success' ? 'text-bg-success' : 'text-bg-danger');
    $('#toastMessage').text(message);
    bootstrap.Toast.getOrCreateInstance($toast[0]).show();
}