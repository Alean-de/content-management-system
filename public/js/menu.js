$(document).ready(function() {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadMenuItems();
});

document.addEventListener('DOMContentLoaded', () => {
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');

    if(imageInput && preview){
        imageInput.addEventListener('change', () => {
            const file = imageInput.files[0];
            if(file){
                preview.src = URL.createObjectURL(file);
            }
        });
    }
});


function loadMenuItems() {
    $.ajax({
        url: '/administrator/menu/', 
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            let $tableBody = $('#menuTableBody');
            $tableBody.empty(); 

            if (response.data.length === 0) {
                $tableBody.append(`<tr><td colspan="8" class="text-center">Belum ada data menu.</td></tr>`);
                return;
            }

            response.data.forEach(function(item, index) {
                let imageUrl = item.image 
                    ? `/storage/${item.image}` 
                    : '/images/no-image.png';

                let formattedPrice = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(item.price);

                let categoryName = item.category ? item.category.name : 'Tanpa Kategori';

                let date = new Date(item.created_at);
                let formattedDate = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

                let rowHtml = `
                    <tr>
                        <td>${index + 1}</td>
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
                                <a href="/administrator/menu/update/${item.id}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${item.id}">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                $tableBody.append(rowHtml);
            });
        },
        error: function(xhr) {
            console.error('Gagal memuat data tabel:', xhr.responseJSON);
        }
    });
}

$('#formTambahMenu').on('submit', function(e) {
    e.preventDefault();

    // Mengunci tombol simpan agar tidak bisa di-spam
    let $submitBtn = $(this).find('button[type="submit"]');
    $submitBtn.prop('disabled', true).text('Menyimpan...');

    let formData = new FormData(this);

    $.ajax({
        url: '/administrator/menu/create/',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if(response.success) {
                alert(response.message);
                
                // Reset form dan preview gambar
                $('#formTambahMenu')[0].reset();
                $('#preview').attr('src', '');

                loadMenuItems(); 
            }
        },
        error: function(xhr) {
            alert('Gagal menyimpan');
            console.log(xhr.responseJSON);
        },
        complete: function() {
            // Membuka kembali kunci tombol simpan setelah proses selesai
            $submitBtn.prop('disabled', false).text('Simpan Menu');
        }
    });
});

$('#menuTableBody').on('click', '.btn-delete', function() {
    let menuId = $(this).data('id');
    
    if (confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
        
        let $thisButton = $(this);
        $thisButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>...');

        $.ajax({
            url: `/administrator/menu/delete/${menuId}`, 
            method: 'DELETE',
            success: function(response) {
                if(response.success) {
                    alert(response.message);
                    
                    loadMenuItems(); 
                }
            },
            error: function(xhr) {
                alert('Waduh, gagal menghapus data.');
                console.log(xhr.responseJSON);
                
                $thisButton.prop('disabled', false).html('<i class="fas fa-trash"></i> Hapus');
            }
        });
    }
});