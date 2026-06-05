// Setup CSRF & Load Pertama
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadMenuItems();
});

let targetMenuId = null;
let $clickedButton = null;
let currentSearch = '';
let currentCategory = '';

// Listener Kolom Search
$('#search').on('keyup', function() {
    currentSearch = $(this).val();
    loadMenuItems(1, currentSearch, currentCategory);
});

// Listener Filter Kategori
$('#filterCategory').on('change', function() {
    currentCategory = $(this).val();
    loadMenuItems(1, currentSearch, currentCategory); // Reset ke hal 1 tiap ganti filter
});

// Image Preview Handler
document.addEventListener('DOMContentLoaded', () => {
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');

    if(imageInput && preview){
        imageInput.addEventListener('change', () => {
            const file = imageInput.files[0];
            if(file){
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
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

// Function Load Menu Items
function loadMenuItems(page = 1, search = '', category = '') {
    $.ajax({
        url: `/administrator/menu/?page=${page}&search=${encodeURIComponent(search)}&category=${category}`, 
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            let $tableBody = $('#menuTableBody');
            $tableBody.empty(); 

            if (response.data.length === 0) {
                $tableBody.append(`<tr><td colspan="8" class="text-center">Belum ada data menu.</td></tr>`);
                $('#paginationContainer').empty();
                return;
            }

            response.data.forEach(function(item, index) {
                let imageUrl = item.image ? `/storage/${item.image}` : '/images/no-image.png';
                let formattedPrice = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(item.price);

                let categoryName = item.category ? item.category.name : 'Tanpa Kategori';
                let date = new Date(item.created_at);
                let formattedDate = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                
                // Kalkulasi nomor urut baris sesuai halaman aktif
                let rowNumber = ((response.current_page - 1) * 10) + (index + 1);

                let rowHtml = `
                    <tr>
                        <td>${rowNumber}</td>
                        <td>
                            <img src="${imageUrl}" alt="${item.name}" style="width: 100px; height: auto; object-fit: cover;" class="img-thumbnail">
                        </td>
                        <td>${item.name}</td>
                        <td>${item.description || ''}</td>
                        <td>${formattedPrice}</td>
                        <td>${categoryName}</td>
                        <td>${formattedDate}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" 
                                        class="btn btn-warning btn-sm btn-edit" 
                                        data-id="${item.id}"
                                        data-name="${item.name}"
                                        data-description="${item.description || ''}"
                                        data-price="${item.price}"
                                        data-category="${item.category_id || ''}"
                                        data-featured="${item.is_featured}">
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
            console.error('Gagal memuat data tabel:', xhr.responseJSON);
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

// Event Click Tombol Paginasi
$('#paginationContainer').on('click', '.page-link', function(e) {
    e.preventDefault();
    let targetPage = $(this).data('page');
    if (targetPage) {
        loadMenuItems(targetPage, currentSearch, currentCategory);
    }
});

// Function Create Menu
$('#formTambahMenu').on('submit', function(e) {
    e.preventDefault();

    let $submitBtn = $(this).find('button[type="submit"]');
    $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');

    let formData = new FormData(this);

    $.ajax({
        url: '/administrator/menu/create/',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if(response.success) {
                $('#createMenu').modal('hide'); 
                $('#formTambahMenu')[0].reset();
                $('#preview').attr('src', '').addClass('d-none');
                loadMenuItems(); 
                showToast(response.message || 'Menu berhasil ditambahkan!', 'success');
            } else {
                showToast(response.message || 'Gagal menyimpan data.', 'danger');
            }
        },
        error: function(xhr) {
            $('#createMenu').modal('hide');
            let errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal menyimpan data.';
            showToast(errorMsg, 'danger');
            console.log(xhr.responseJSON);
        },
        complete: function() {
            $submitBtn.prop('disabled', false).text('Add Menu');
        }
    });
});

// Function Update Menu Submit
$('#formUpdateMenu').on('submit', function(e) {
    e.preventDefault();

    let $submitBtn = $(this).find('button[type="submit"]');
    $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');

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
                $('#updateMenu').modal('hide'); 
                loadMenuItems(); 
                showToast(response.message || 'Perubahan berhasil disimpan!', 'success');
            } else {
                showToast(response.message || 'Gagal mengubah data.', 'danger');
            }
        },
        error: function(xhr) {
            $('#updateMenu').modal('hide');
            let errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal memperbarui data.';
            showToast(errorMsg, 'danger');
            console.log(xhr.responseJSON);
        },
        complete: function() {
            $submitBtn.prop('disabled', false).text('Simpan Perubahan');
        }
    });
});

// Function Populate Edit Modal
$(document).ready(function() {
    $('#menuTableBody').on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let description = $(this).data('description');
        let price = Math.round($(this).data('price')); 
        let category = $(this).data('category'); 
        let isFeatured = $(this).data('featured'); 
        
        let currentImageUrl = $(this).closest('tr').find('img').attr('src');    

        $('#edit-id').val(id);
        $('#edit-name').val(name);
        $('#edit-description').val(description);
        $('#edit-price').val(price); 
        $('#edit-category').val(category); 
        $('#edit-preview').attr('src', currentImageUrl);

        // Kontrol switch checkbox modal sesuai status basis data asli
        if (isFeatured == 1) {
            $('#edit-is-featured').prop('checked', true);
        } else {
            $('#edit-is-featured').prop('checked', false);
        }

        $('#formUpdateMenu').attr('action', `/administrator/menu/update/${id}`);
        $('#updateMenu').modal('show');
    });
});

// Function Trigger Delete Modal
$('#menuTableBody').on('click', '.btn-delete', function() {
    targetMenuId = $(this).data('id'); 
    $clickedButton = $(this); 
    $('#deleteMenuModal').modal('show');
});

// Function Confirm Delete
$('#btnConfirmDelete').on('click', function() {
    if (!targetMenuId) return;

    let $confirmBtn = $(this);
    $confirmBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghapus...');

    $.ajax({
        url: `/administrator/menu/delete/${targetMenuId}`, 
        method: 'DELETE',
        success: function(response) {
            if(response.success) {
                $('#deleteMenuModal').modal('hide'); 
                loadMenuItems(); 
                showToast(response.message || 'Data berhasil dihapus!', 'success');
            } else {
                showToast(response.message || 'Gagal menghapus data.', 'danger');
            }
        },
        error: function(xhr) {
            $('#deleteMenuModal').modal('hide'); 
            let errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Waduh, koneksi gagal atau terjadi kesalahan server.';
            showToast(errorMsg, 'danger');
            console.log(xhr.responseJSON);
        },
        complete: function() {
            $confirmBtn.prop('disabled', false).text('Ya, Hapus');
            targetMenuId = null; 
        }
    });
});

// Function Show Toast
function showToast(message, type = 'success') {
    let $toast = $('#liveToast');
    $toast.removeClass('text-bg-success text-bg-danger');
    
    if (type === 'success') {
        $toast.addClass('text-bg-success');
    } else {
        $toast.addClass('text-bg-danger');
    }
    
    $('#toastMessage').text(message);
    let toastInstance = bootstrap.Toast.getOrCreateInstance($toast[0]);
    toastInstance.show();
}