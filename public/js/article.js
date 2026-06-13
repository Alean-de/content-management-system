// Setup CSRF & Load Pertama
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadArticles();
});

let targetArticleId = null;
let currentSearch = '';

// Listener Kolom Search
$('#search').on('keyup', function() {
    currentSearch = $(this).val();
    loadArticles(1, currentSearch);
});

// Character Counter Real-Time Handler
$('#content').on('input', function() {
    $('#counter').text($(this).val().length);
});

$('#edit-content').on('input', function() {
    $('#edit-counter').text($(this).val().length);
});

// Image Preview Handler
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

// Function Load Articles
function loadArticles(page = 1, search = '') {
    $.ajax({
        url: `/administrator/article/?page=${page}&search=${encodeURIComponent(search)}`,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            let $tableBody = $('#articleTableBody');
            $tableBody.empty();

            if (response.data.length === 0) {
                $tableBody.append(`<tr><td colspan="6" class="text-center py-4">Belum ada data artikel.</td></tr>`);
                $('#paginationContainer').empty();
                return;
            }

            response.data.forEach(function(item, index) {
                let thumbUrl = item.thumbnail ? `/storage/${item.thumbnail}` : '/images/no-image.png';
                let authorName = item.user ? item.user.name : (item.author || 'Admin');
                let date = new Date(item.created_at);
                let formattedDate = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                
                let rowNumber = ((response.current_page - 1) * 10) + (index + 1);

                let rowHtml = `
                    <tr>
                        <td>${rowNumber}</td>
                        <td>
                            <img src="${thumbUrl}" alt="Thumb" style="width: 100px; height: 60px; object-fit: cover;" class="rounded shadow-sm">
                        </td>
                        <td class="text-start fw-bold text-body">${item.title}</td>
                        <td class="text-start text-muted small">${authorName}</td>
                        <td class="text-start text-muted small">${formattedDate}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" 
                                        class="btn btn-warning btn-sm btn-edit" 
                                        data-id="${item.id}"
                                        data-title="${item.title}"
                                        data-content="${item.content || ''}">
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
            console.error('Gagal memuat data artikel:', xhr.responseJSON);
        }
    });
}

// Function Render Pagination
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

// Click Paginasi
$('#paginationContainer').on('click', '.page-link', function(e) {
    e.preventDefault();
    let targetPage = $(this).data('page');
    if (targetPage) {
        loadArticles(targetPage, currentSearch);
    }
});

// Action Create Article
$('#formTambahArticle').on('submit', function(e) {
    e.preventDefault();
    let $submitBtn = $(this).find('button[type="submit"]');
    $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

    let formData = new FormData(this);

    $.ajax({
        url: '/administrator/article/create/',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if(response.success) {
                $('#createArticle').modal('hide');
                $('#formTambahArticle')[0].reset();
                $('#preview').addClass('d-none');
                $('#icon-placeholder').removeClass('d-none');
                $('#counter').text('0');
                loadArticles();
                showToast(response.message || 'Artikel berhasil diterbitkan!', 'success');
            } else {
                showToast(response.message || 'Gagal menyimpan artikel.', 'danger');

                $('#formTambahArticle').find('input[type="file"]').val('');
                $('#preview').addClass('d-none');
                $('#icon-placeholder').removeClass('d-none');
            }
        },
        error: function(xhr) {
           let errorMsg = 'Gagal menyimpan data.';
            
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                let firstKey = Object.keys(errors)[0];
                errorMsg = errors[firstKey][0];
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            
            showToast(errorMsg, 'danger');
            console.log(xhr.responseJSON);

            $('#formTambahArticle').find('input[type="file"]').val('');
            $('#preview').addClass('d-none');
            $('#icon-placeholder').removeClass('d-none');
        },
        complete: function() {
            $submitBtn.prop('disabled', false).text('Add Article');
        }
    });
});

// Populate Edit Modal
$('#articleTableBody').on('click', '.btn-edit', function() {
    let id = $(this).data('id');
    let title = $(this).data('title');
    let content = $(this).data('content');
    let currentThumbUrl = $(this).closest('tr').find('img').attr('src');

    $('#edit-id').val(id);
    $('#edit-title').val(title);
    $('#edit-content').val(content);
    $('#edit-counter').text(content.length);
    $('#edit-preview').attr('src', currentThumbUrl);

    $('#formUpdateArticle').attr('action', `/administrator/article/update/${id}`);
    $('#updateArticle').modal('show');
});

// Action Update Article Submit
$('#formUpdateArticle').on('submit', function(e) {
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
                $('#updateArticle').modal('hide');
                loadArticles();
                showToast(response.message || 'Artikel berhasil diperbarui!', 'success');
            } else {
                showToast(response.message || 'Gagal memperbarui data.', 'danger');
            }
        },
        error: function(xhr) {
           let errorMsg = 'Gagal menyimpan data.';
            
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                let firstKey = Object.keys(errors)[0];
                errorMsg = errors[firstKey][0];
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            
            showToast(errorMsg, 'danger');
            console.log(xhr.responseJSON);

            $('#formUpdateArticle').find('input[type="file"]').val('');
            $('#preview').addClass('d-none');
            $('#icon-placeholder').removeClass('d-none');
        },
        complete: function() {
            $submitBtn.prop('disabled', false).text('Simpan Perubahan');
        }
    });
});

// Trigger Delete Modal
$('#articleTableBody').on('click', '.btn-delete', function() {
    targetArticleId = $(this).data('id');
    $('#deleteArticleModal').modal('show');
});

// Confirm Delete Action
$('#btnConfirmDeleteArticle').on('click', function() {
    if (!targetArticleId) return;
    let $confirmBtn = $(this);
    $confirmBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Erasing...');

    $.ajax({
        url: `/administrator/article/delete/${targetArticleId}`,
        method: 'DELETE',
        success: function(response) {
            if(response.success) {
                $('#deleteArticleModal').modal('hide');
                loadArticles();
                showToast(response.message || 'Artikel berhasil dihapus permanen!', 'success');
            } else {
                showToast(response.message || 'Gagal menghapus data.', 'danger');
            }
        },
        error: function(xhr) {
            $('#deleteArticleModal').modal('hide');
            showToast('Kesalahan server saat menghapus data.', 'danger');
        },
        complete: function() {
            $confirmBtn.prop('disabled', false).text('Ya, Hapus');
            targetArticleId = null;
        }
    });
});

// Function Show Toast
function showToast(message, type = 'success') {
    let $toast = $('#liveToast');
    $toast.removeClass('text-bg-success text-bg-danger');
    $toast.addClass(type === 'success' ? 'text-bg-success' : 'text-bg-danger');
    $('#toastMessage').text(message);
    bootstrap.Toast.getOrCreateInstance($toast[0]).show();
}