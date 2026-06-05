// Setup CSRF & Load Pertama
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadMessages();
});

let targetMessageId = null;
let currentSearch = '';

// Listener Kolom Search (Pencarian Nama/Subjek)
$('#search').on('keyup', function() {
    currentSearch = $(this).val();
    loadMessages(1, currentSearch);
});

// Function Muat Data Tabel Messages via AJAX
function loadMessages(page = 1, search = '') {
    $.ajax({
        url: `/administrator/message/?page=${page}&search=${encodeURIComponent(search)}`, 
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            let $tableBody = $('#messageTableBody');
            $tableBody.empty(); 

            if (response.data.length === 0) {
                $tableBody.append(`<tr><td colspan="6" class="text-center py-4">Belum ada pesan masuk.</td></tr>`);
                $('#paginationContainer').empty();
                return;
            }

            response.data.forEach(function(message, index) {
                // Format tanggal biar rapi dibaca admin
                let date = new Date(message.created_at);
                let formattedDate = date.toLocaleDateString('id-ID', { 
                    day: '2-digit', 
                    month: 'short', 
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                // Kalkulasi nomor urut baris sesuai halaman aktif (Bebas dari bug NaN)
                let currentPage = response.current_page || 1;
                let rowNumber = ((currentPage - 1) * 10) + (index + 1);

                // FIX: Memasukkan semua data ke dalam data-attribute di tag <tr>
                let rowHtml = `
                    <tr data-id="${message.id}" 
                        data-name="${message.name}" 
                        data-email="${message.email}" 
                        data-subject="${message.subject}" 
                        data-message="${message.message}" 
                        data-date="${formattedDate}">
                        <td>${rowNumber}</td>
                        <td class="fw-bold text-dark">${message.name}</td>
                        <td class="text-start">${message.email}</td>
                        <td class="text-start text-muted fw-medium">${message.subject}</td>
                        <td>${formattedDate}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-delete px-2.5 py-1 rounded-3" data-id="${message.id}">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $tableBody.append(rowHtml);
            });

            renderPagination(response.current_page, response.last_page);
        },
        error: function(xhr) {
            console.error('Gagal memuat data tabel pesan:', xhr.responseJSON);
        }
    });
}

// Function Render Tombol Paginasi
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

// Event Klik Navigasi Paginasi
$('#paginationContainer').on('click', '.page-link', function(e) {
    e.preventDefault();
    let targetPage = $(this).data('page');
    if (targetPage) {
        loadMessages(targetPage, currentSearch);
    }
});

// Listener Klik Baris Tabel (KONSEP ALA GMAIL: Click row untuk buka detail)
// Trik :not(button, i) dipakai supaya kalau tombol delete diklik, modal baca pesan gak ikut ngebuka
$('#messageTableBody').on('click', 'tr :not(button, i)', function() {
    let $row = $(this).closest('tr');
    
    targetMessageId = $row.data('id');
    
    // Tarik data dari baris tr, lalu suntik langsung ke modal detail pembaca
    $('#msg-name').text($row.data('name'));
    $('#msg-email').text($row.data('email'));
    $('#msg-subject').text($row.data('subject'));
    $('#msg-content').text($row.data('message'));
    $('#msg-date').text($row.data('date'));

    // Munculkan modal Gmail detail pesan
    $('#detailMessageModal').modal('show');
});

// Pemicu Klik Tombol Hapus dari Kolom Aksi Tabel Utama
$('#messageTableBody').on('click', '.btn-delete', function(e) {
    e.preventDefault();
    targetMessageId = $(this).data('id'); 
    $('#deleteMessageModal').modal('show');
});

// Pemicu Tombol Hapus dari Dalam Modal Detail Baca Pesan
$('#btnDeleteFromModal').on('click', function() {
    if (!targetMessageId) return;
    $('#detailMessageModal').modal('hide'); // Tutup modal baca pesan
    $('#deleteMessageModal').modal('show');  // Langsung oper lempar ke modal konfirmasi hapus
});

// Eksekusi Konfirmasi Hapus via AJAX
$('#btnConfirmDeleteMessage').on('click', function() {
    if (!targetMessageId) return;
    let $confirmBtn = $(this);
    $confirmBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Erasing...');

    $.ajax({
        url: `/administrator/message/delete/${targetMessageId}`, 
        method: 'DELETE',
        success: function(response) {
            if(response.success) {
                $('#deleteMessageModal').modal('hide'); 
                loadMessages(); 
                showToast(response.message || 'Pesan berhasil dihapus permanen!', 'success');
            } else {
                showToast(response.message || 'Gagal menghapus data.', 'danger');
            }
        },
        error: function(xhr) {
            $('#deleteMessageModal').modal('hide'); 
            showToast('Eror server sistem hapus pesan.', 'danger');
        },
        complete: function() {
            $confirmBtn.prop('disabled', false).text('Ya, Hapus');
            targetMessageId = null; 
        }
    });
});

// Function Tampilkan Pop-Up Toast Modern
function showToast(message, type = 'success') {
    let $toast = $('#liveToast');
    $toast.removeClass('text-bg-success text-bg-danger');
    $toast.addClass(type === 'success' ? 'text-bg-success' : 'text-bg-danger');
    $('#toastMessage').text(message);
    bootstrap.Toast.getOrCreateInstance($toast[0]).show();
}