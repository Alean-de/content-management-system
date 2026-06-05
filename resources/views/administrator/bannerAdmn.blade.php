@include('partials.head')
@include('partials.navbar')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">

<div class="container-fluid bg-light min-vh-100 py-4 px-md-5" style="background-color: #f8f9fa !important;">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold text-dark m-0 tracking-tight">Banner Management</h4>
            <p class="text-muted small m-0 mt-1">Atur spanduk promo, pengumuman, dan konten *slider* utama halaman depan</p>
        </div>
        <div class="mt-3 mt-md-0">
            <button class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="modal" data-bs-target="#createBanner">
                <i class="bi bi-plus-lg"></i> Add New Banner
            </button>
        </div>
    </div>

    <div class="row g-3 justify-content-end align-items-center mb-4">
        <div class="col-12 col-md-auto d-flex gap-2">
            <select id="filterStatus" class="form-select border-0 shadow-sm py-2 rounded-3 text-secondary bg-white" style="min-width: 160px;">
                <option value="">Semua Status</option>
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            </select>

            <div class="input-group shadow-sm bg-white rounded-3 overflow-hidden" style="min-width: 260px;">
                <span class="input-group-text bg-white border-0 text-muted pe-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="search" class="form-control border-0 py-2 shadow-none" placeholder="Cari judul banner...">
            </div>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle mb-0 w-100">
                <thead class="table-light text-center text-secondary small fw-bold text-uppercase border-bottom">
                    <tr>
                        <th scope="col" class="py-3" style="width: 5%">No</th>
                        <th scope="col" class="py-3" style="width: 18%">Image</th>
                        <th scope="col" class="py-3 text-start">Title</th>
                        <th scope="col" class="py-3 text-start">Subtitle</th>
                        <th scope="col" class="py-3">Status</th>
                        <th scope="col" class="py-3">Start Date</th>
                        <th scope="col" class="py-3">End Date</th>
                        <th scope="col" class="py-3" style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody id="bannerTableBody" class="text-center text-secondary">
                    </tbody>
            </table>
        </div> 
        
        <div class="d-flex justify-content-center py-3 bg-white border-top">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0 gap-1" id="paginationContainer"></ul>
            </nav>
        </div>
    </div>
</div>

<div class="modal fade" id="createBanner" tabindex="-1" aria-labelledby="createBannerModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2">
                <h5 class="modal-title fw-bold text-dark" id="createBannerModal">Add New Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="formTambahBanner" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 pb-0">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
                            <div class="text-center bg-light p-3 rounded-3 border border-2 border-dashed h-100 d-flex flex-column justify-content-center align-items-center" style="min-height: 250px;">
                                <img id="preview" width="100%" style="height: 130px;" class="rounded-3 shadow-sm mb-3 object-fit-cover d-none" alt="Preview">
                                <i class="bi bi-images text-muted display-5 mb-2" id="icon-placeholder"></i>
                                <label for="image" class="form-label text-primary small fw-bold cursor-pointer m-0">Upload Banner Image</label>
                                <input type="file" class="form-control form-control-sm mt-2" id="image" name="image" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-2">
                                <label for="title" class="form-label small fw-bold text-secondary mb-1">Title</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3 form-control-sm" id="title" name="title" placeholder="Masukkan judul utama spanduk" required>
                            </div>

                            <div class="mb-2">
                                <label for="subtitle" class="form-label small fw-bold text-secondary mb-1">Subtitle</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3 form-control-sm" id="subtitle" name="subtitle" placeholder="Masukkan sub-judul (opsional)">
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label for="start_date" class="form-label small fw-bold text-secondary mb-1">Start Date</label>
                                    <input type="date" class="form-control bg-light border-0 py-2 rounded-3 form-control-sm" id="start_date" name="start_date" required>
                                </div>
                                <div class="col-6">
                                    <label for="end_date" class="form-label small fw-bold text-secondary mb-1">End Date</label>
                                    <input type="date" class="form-control bg-light border-0 py-2 rounded-3 form-control-sm" id="end_date" name="end_date" required>
                                </div>
                            </div>

                            <div class="form-check form-switch mt-3 p-2 bg-light rounded-3 ps-5">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                                <label class="form-check-label small fw-bold text-secondary" for="is_active">Aktifkan Spanduk Sekarang</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4 pt-3">
                    <button type="button" class="btn btn-light px-3 py-2 rounded-3 fw-semibold small" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold small shadow-sm">Save Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="updateBanner" tabindex="-1" aria-labelledby="updateBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2">
                <h5 class="modal-title fw-bold text-dark" id="updateBannerModalLabel">Edit Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="formUpdateBanner" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 pb-0">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
                            <div class="text-center bg-light p-3 rounded-3 border h-100 d-flex flex-column justify-content-center align-items-center" style="min-height: 250px;">
                                <img id="edit-preview" width="100%" style="height: 130px;" class="rounded-3 shadow-sm mb-3 object-fit-cover d-block mx-auto" alt="Current Banner">
                                <label for="edit-image" class="form-label text-muted small fw-bold d-block">Ubah Spanduk (Kosongkan jika sama)</label>
                                <input type="file" class="form-control form-control-sm mt-2" id="edit-image" name="image">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-2">
                                <label for="edit-title" class="form-label small fw-bold text-secondary mb-1">Title</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3 form-control-sm" id="edit-title" name="title" required>
                            </div>

                            <div class="mb-2">
                                <label for="edit-subtitle" class="form-label small fw-bold text-secondary mb-1">Subtitle</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3 form-control-sm" id="edit-subtitle" name="subtitle">
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label for="edit-start_date" class="form-label small fw-bold text-secondary mb-1">Start Date</label>
                                    <input type="date" class="form-control bg-light border-0 py-2 rounded-3 form-control-sm" id="edit-start_date" name="start_date" required>
                                </div>
                                <div class="col-6">
                                    <label for="edit-end_date" class="form-label small fw-bold text-secondary mb-1">End Date</label>
                                    <input type="date" class="form-control bg-light border-0 py-2 rounded-3 form-control-sm" id="edit-end_date" name="end_date" required>
                                </div>
                            </div>

                            <div class="form-check form-switch mt-3 p-2 bg-light rounded-3 ps-5">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="edit-is-active">
                                <label class="form-check-label small fw-bold text-secondary" for="edit-is-active">Banner Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4 pt-3">
                    <button type="button" class="btn btn-light px-3 py-2 rounded-3 fw-semibold small" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold small shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteBannerModal" tabindex="-1" aria-labelledby="deleteBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="bi bi-exclamation-triangle fs-4"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Hapus Banner?</h5>
                <p class="text-muted small mb-0">Apakah Anda yakin? Tindakan ini tidak dapat dibatalkan.</p>
                
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button" class="btn btn-light w-50 py-2 rounded-3 small fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnConfirmDeleteBanner" class="btn btn-danger w-50 py-2 rounded-3 small fw-semibold shadow-sm">Ya, Hapus</button>
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

<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/banner.js') }}"></script>
@include('partials.foot')