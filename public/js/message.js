$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadMessages();

    function loadMessages() {
        $.ajax({
            url: '/administrator/message', // Jalur rute indeks utama
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let $tableBody = $('#messageTableBody');
                $tableBody.empty(); // Bersihkan baris lama

                if (response.data.length === 0) {
                    $tableBody.append(`<tr><td colspan="6" align="center">Belum ada pesan masuk.</td></tr>`);
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

                    let rowHtml = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${message.name}</td>
                            <td>${message.email}</td>
                            <td>${message.subject}</td>
                            <td>${formattedDate}</td>
                            <td>
                                <a href="/administrator/message/show/${message.id}">View</a>
                                <button type="button" class="btn-delete" data-id="${message.id}" style="color:red; cursor:pointer; background:none; border:none; padding:0; margin-left:10px;">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                    $tableBody.append(rowHtml);
                });
            },
            error: function(xhr) {
                console.error('Gagal mengambil data pesan:', xhr.responseJSON);
            }
        });
    }

    $('#messageTableBody').on('click', '.btn-delete', function(e) {
        e.preventDefault();

        let messageId = $(this).data('id');

        if (confirm('Apakah Anda yakin ingin menghapus pesan ini?')) {
            let $thisBtn = $(this);
            $thisBtn.prop('disabled', true).text('Deleting...');

            $.ajax({
                url: `/administrator/message/delete/${messageId}`,
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        loadMessages();
                    }
                },
                error: function(xhr) {
                    alert('Gagal menghapus pesan.');
                    console.log(xhr.responseJSON);
                    $thisBtn.prop('disabled', false).text('Delete');
                }
            });
        }
    });

});