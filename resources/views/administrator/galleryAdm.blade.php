@include('partials.head')
@include('partials.navbar')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">

<div class="container-fluid bg-light min-vh-100 py-4 px-md-5" style="background-color: #f8f9fa !important;">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold text-dark m-0 tracking-tight">Gallery Management</h4>
            <p class="text-muted small m-0 mt-1">Kelola dokumentasi foto suasana restoran, event, dan fasilitas secara real-time</p>
        </div>
        <div class="mt-3 mt-md-0">
            <button class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="modal" data-bs-target="#createGallery">
                <i class="bi bi-cloud-arrow-up"></i> Upload New Image
            </button>
        </div>
    </div>

    <div class="row g-3 justify-content-end align-items-center mb-4">
        <div class="col-12 col-md-4 col-lg-3">
            <div class="input-group shadow-sm bg-white rounded-3 overflow-hidden">
                <span class="input-group-text bg-white border-0 text-muted pe-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="search" class="form-control border-0 py-2 shadow-none" placeholder="Cari judul foto...">
            </div>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle text-center mb-0 w-100">
                <thead class="table-light text-secondary small fw-bold text-uppercase border-bottom">
                    <tr>
                        <th scope="col" class="py-3" style="width: 5%">No</th>
                        <th scope="col" class="py-3" style="width: 15%">Image</th>
                        <th scope="col" class="py-3">Title / Caption</th>
                        <th scope="col" class="py-3" style="width: 12%">Action</th>
                    </tr>
                </thead>
                <tbody id="galleryTableBody" class="text-secondary">
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

<div class="modal fade" id="createGallery" tabindex="-1" aria-labelledby="createGalleryModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2">
                <h5 class="modal-title fw-bold text-dark" id="createGalleryModal">Upload Image to Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="formTambahGallery" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 pb-0">
                    <div class="row g-3">
                        <div class="col-12 col-md-5 d-flex flex-column justify-content-between">
                            <div class="text-center bg-light p-3 rounded-3 border border-2 border-dashed h-100 d-flex flex-column justify-content-center align-items-center" style="min-height: 200px;">
                                <img id="gallery-preview" width="140" height="140" class="rounded-3 shadow-sm mb-3 object-fit-cover d-none" alt="Preview">
                                <i class="bi bi-images text-muted display-5 mb-2" id="icon-placeholder"></i>
                                <label for="gallery-image" class="form-label text-primary small fw-bold cursor-pointer m-0">Choose Image File</label>
                                <input type="file" class="form-control form-control-sm mt-2" id="gallery-image" name="image" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-7">
                            <div class="mb-3">
                                <label for="title" class="form-label small fw-bold text-secondary mb-1">Title / Caption</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" id="title" name="title" placeholder="Masukkan judul atau deskripsi foto galeri" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4 pt-3">
                    <button type="button" class="btn btn-light px-3 py-2 rounded-3 fw-semibold small" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold small shadow-sm">Upload Now</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteGalleryModal" tabindex="-1" aria-labelledby="deleteGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="bi bi-exclamation-triangle fs-4"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Delete Image?</h5>
                <p class="text-muted small mb-0">Apakah Anda yakin? Foto akan dihapus permanen dari server.</p>
                
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button" class="btn btn-light w-50 py-2 rounded-3 small fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnConfirmDeleteGallery" class="btn btn-danger w-50 py-2 rounded-3 small fw-semibold shadow-sm">Ya, Hapus</button>
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
<script src="{{ asset('js/gallery.js') }}"></script>
@include('partials.foot')