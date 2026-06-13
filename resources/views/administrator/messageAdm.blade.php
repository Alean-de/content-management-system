@section('title', 'Message')
@include('partials.admin.header')
@include('partials.admin.navbar')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">

<div class="container-fluid bg-body-secondary min-vh-100 py-4 px-md-5">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-light-subtle">
        <div>
            <h4 class="fw-bold text-body m-0 tracking-tight">Message Management</h4>
            <p class="text-body small m-0 mt-1">Baca, periksa, dan kelola pesan masuk dari pelanggan secara real-time</p>
        </div>
    </div>

    <div class="row g-3 justify-content-end align-items-center mb-4">
        <div class="col-12 col-md-4 col-lg-3">
            <div class="input-group shadow-sm bg-body rounded-3 overflow-hidden">
                <span class="input-group-text bg-body border-0 text-secondary pe-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="search" class="form-control bg-body text-body border-0 py-2 shadow-none" placeholder="Cari nama atau subjek...">
            </div>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-body">
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle text-center mb-0 w-100">
                <thead class="text-secondary small fw-bold text-uppercase border-bottom border-light-subtle">
                    <tr>
                        <th scope="col" class="py-3" style="width: 5%">No</th>
                        <th scope="col" class="py-3" style="width: 20%">Sender Name</th>
                        <th scope="col" class="py-3 text-start" style="width: 20%">Whatsapp</th>
                        <th scope="col" class="py-3 text-start">Subject</th>
                        <th scope="col" class="py-3" style="width: 15%">Received At</th>
                    </tr>
                </thead>
                <tbody id="messageTableBody" class="text-secondary" style="cursor: pointer;">
                    </tbody>
            </table>
        </div> 
        
        <div class="d-flex justify-content-center py-3 bg-body border-top border-light-subtle">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0 gap-1" id="paginationContainer"></ul>
            </nav>
        </div>
    </div>
</div>

<div class="modal fade" id="detailMessageModal" tabindex="-1" aria-labelledby="detailMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 bg-body text-body">
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-envelope-open fs-5"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-body" id="detailMessageModalLabel">Read Message</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body px-4 py-3">
                <div class="row g-3">
                    <div class="col-md-6 text-start">
                        <label class="small fw-bold text-secondary mb-1">Sender Name</label>
                        <p id="msg-name" class="bg-body-tertiary p-2.5 rounded-3 text-body fw-semibold mb-0">-</p>
                    </div>
                    <div class="col-md-6 text-start">
                        <label class="small fw-bold text-secondary mb-1">Whatsapp</label>
                        <p id="msg-whatsapp" class="bg-body-tertiary p-2.5 rounded-3 text-secondary mb-0">-</p>
                    </div>
                    <div class="col-12 text-start">
                        <label class="small fw-bold text-secondary mb-1">Subject</label>
                        <p id="msg-subject" class="bg-body-tertiary p-2.5 rounded-3 text-body fw-bold mb-0">-</p>
                    </div>
                    <div class="col-12 text-start">
                        <label class="small fw-bold text-secondary mb-1">Message Content</label>
                        <div id="msg-content" class="bg-body-tertiary p-3 rounded-3 text-body small border border-light-subtle" style="min-height: 120px; white-space: pre-line;">-</div>
                    </div>
                    <div class="col-12 text-end">
                        <span class="text-secondary" style="font-size: 11px;">Received At: <span id="msg-date" class="fw-semibold text-primary"></span></span>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer border-top-0 px-4 pb-4 pt-2 d-flex justify-content-between">
                <button type="button" id="btnDeleteFromModal" class="btn btn-danger px-3 py-2 rounded-3 fw-semibold small d-flex align-items-center gap-1 shadow-sm">
                    <i class="bi bi-trash3"></i> Delete Message
                </button>
                <button type="button" class="btn btn-secondary bg-opacity-10 border-0 px-4 py-2 rounded-3 fw-semibold small" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteMessageModal" tabindex="-1" aria-labelledby="deleteMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4 bg-body text-body">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="bi bi-exclamation-triangle fs-4"></i>
                </div>
                <h5 class="fw-bold text-body mb-1">Hapus Pesan?</h5>
                <p class="text-secondary small mb-0">Apakah Anda yakin? Pesan ini akan dihapus permanen dari sistem.</p>
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button" class="btn btn-secondary bg-opacity-10 border-0 w-50 py-2 rounded-3 small fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnConfirmDeleteMessage" class="btn btn-danger w-50 py-2 rounded-3 small fw-semibold shadow-sm">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="liveToast" class="toast align-items-center border-0 text-white shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body fw-semibold small">
                <span id="toastMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script src="{{ asset('js/message.js') }}"></script>
@include('partials.admin.footer')