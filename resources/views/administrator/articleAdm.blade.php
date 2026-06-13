@section('title', 'Article')
@include('partials.admin.header')
@include('partials.admin.navbar')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">

<!-- Menggunakan background yang adaptif terhadap perubahan tema -->
<div class="container-fluid bg-body-secondary min-vh-100 py-4 px-md-5">
    
    <!-- Title Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-light-subtle">
        <div>
            <h4 class="fw-bold text-body m-0 tracking-tight">Article Management</h4>
            <p class="text-body small m-0 mt-1">Tulis, edit, dan kelola artikel atau berita seputar restoran secara real-time</p>
        </div>
        <div class="mt-3 mt-md-0">
            <button class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="modal" data-bs-target="#createArticle">
                <i class="bi bi-plus-lg"></i> Add New Article
            </button>
        </div>
    </div>

    <!-- Action Bar / Search Input -->
    <div class="row g-3 justify-content-end align-items-center mb-4">
        <div class="col-12 col-md-4 col-lg-3">
            <div class="input-group shadow-sm bg-body rounded-3 overflow-hidden">
                <span class="input-group-text bg-body border-0 text-secondary pe-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="search" class="form-control bg-body text-body border-0 py-2 shadow-none" placeholder="Cari judul artikel...">
            </div>
        </div>
    </div>
    
    <!-- Table Canvas Card -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-body">
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle mb-0 w-100">
                <thead class="text-center text-secondary small fw-bold text-uppercase border-bottom border-light-subtle">
                    <tr>
                        <th scope="col" class="py-3" style="width: 5%">No</th>
                        <th scope="col" class="py-3" style="width: 15%">Thumbnail</th>
                        <th scope="col" class="py-3 text-start">Title</th>
                        <th scope="col" class="py-3 text-center">Author</th>
                        <th scope="col" class="py-3 text-center">Published At</th>
                        <th scope="col" class="py-3" style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody id="articleTableBody" class="text-center text-secondary">
                    <!-- Data di-render dinamis via AJAX (Pastikan title di JS menggunakan kelas text-body) -->
                </tbody>
            </table>
        </div> 
        
        <!-- Paginasi -->
        <div class="d-flex justify-content-center py-3 bg-body border-top border-light-subtle">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0 gap-1" id="paginationContainer"></ul>
            </nav>
        </div>
    </div>
</div>

<!-- ==========================================
     MODAL COMPONENT: CREATE ARTICLE
     ========================================== -->
<div class="modal fade" id="createArticle" tabindex="-1" aria-labelledby="createArticleModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content border-0 shadow-lg rounded-4 bg-body text-body">
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2">
                <h5 class="modal-title fw-bold text-body" id="createArticleModal">Add New Article</h5>
            </div>
            <form method="POST" id="formTambahArticle" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 pb-0">
                    <div class="row g-3">
                        <!-- KOLOM KIRI (UPLOAD FILE) -->
                        <div class="col-12 col-md-5 d-flex flex-column justify-content-between">
                            <div class="text-center bg-body-tertiary p-3 rounded-3 border border-2 border-dashed border-secondary-subtle h-100 d-flex flex-column justify-content-center align-items-center" style="min-height: 240px;">
                                <img id="preview" width="100%" style="height: 140px;" class="rounded-3 shadow-sm mb-3 object-fit-cover d-none" alt="Preview">
                                <i class="bi bi-image text-secondary display-5 mb-2" id="icon-placeholder"></i>
                                <label for="image" class="form-label text-primary small fw-bold cursor-pointer m-0">Choose Thumbnail</label>
                                <input type="file" class="form-control form-control-sm bg-body text-body border-secondary-subtle mt-2" id="image" name="thumbnail" required>
                            </div>
                        </div>

                        <!-- KOLOM KANAN (INPUT TEXT) -->
                        <div class="col-12 col-md-7">
                            <div class="mb-3">
                                <label for="title" class="form-label small fw-bold text-secondary mb-1">Title</label>
                                <input type="text" class="form-control bg-body-tertiary text-body border-0 py-2 rounded-3" id="title" name="title" placeholder="Masukkan judul artikel" required>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="content" class="form-label small fw-bold text-secondary m-0">Content</label>
                                    <span class="text-secondary" style="font-size: 11px;">Characters: <span id="counter" class="fw-bold text-primary">0</span></span>
                                </div>
                                <textarea class="form-control bg-body-tertiary text-body border-0 py-2 rounded-3 textarea-fixed" id="content" name="content" rows="6" placeholder="Tulis isi konten artikel di sini..." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4 pt-3">
                    <button type="button" class="btn btn-secondary bg-opacity-10 border-0 px-3 py-2 rounded-3 fw-semibold small" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold small shadow-sm">Add Article</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==========================================
     MODAL COMPONENT: UPDATE ARTICLE
     ========================================== -->
<div class="modal fade" id="updateArticle" tabindex="-1" aria-labelledby="updateArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content border-0 shadow-lg rounded-4 bg-body text-body">
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2">
                <h5 class="modal-title fw-bold text-body" id="updateArticleModalLabel">Edit Article</h5>
            </div>
            <form method="POST" id="formUpdateArticle" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 pb-0">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="row g-3">
                        <!-- KOLOM KIRI (PREVIEW CURRENT) -->
                        <div class="col-12 col-md-5 d-flex flex-column justify-content-between">
                            <div class="text-center bg-body-tertiary p-3 rounded-3 border border-secondary-subtle h-100 d-flex flex-column justify-content-center align-items-center" style="min-height: 240px;">
                                <img id="edit-preview" width="100%" style="height: 140px;" class="rounded-3 shadow-sm mb-3 object-fit-cover d-block mx-auto" alt="Current Thumbnail">
                                <label for="edit-image" class="form-label text-secondary small fw-bold d-block mt-2">Ubah Thumbnail (Kosongkan jika sama)</label>
                                <input type="file" class="form-control form-control-sm bg-body text-body border-secondary-subtle mt-2" id="edit-image" name="thumbnail">
                            </div>
                        </div>

                        <!-- KOLOM KANAN (EDIT INPUT) -->
                        <div class="col-12 col-md-7">
                            <div class="mb-3">
                                <label for="edit-title" class="form-label small fw-bold text-secondary mb-1">Title</label>
                                <input type="text" class="form-control bg-body-tertiary text-body border-0 py-2 rounded-3" id="edit-title" name="title" required>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="edit-content" class="form-label small fw-bold text-secondary m-0">Content</label>
                                    <span class="text-secondary" style="font-size: 11px;">Characters: <span id="edit-counter" class="fw-bold text-primary">0</span></span>
                                </div>
                                <textarea class="form-control bg-body-tertiary text-body border-0 py-2 rounded-3 textarea-fixed" id="edit-content" name="content" rows="6" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4 pt-3">
                    <button type="button" class="btn btn-secondary bg-opacity-10  border-0 px-3 py-2 rounded-3 fw-semibold small" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold small shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==========================================
     MODAL COMPONENT: DELETE CONFIRMATION
     ========================================== -->
<div class="modal fade" id="deleteArticleModal" tabindex="-1" aria-labelledby="deleteArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4 bg-body text-body">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="bi bi-exclamation-triangle fs-4"></i>
                </div>
                <h5 class="fw-bold text-body mb-1">Hapus Artikel?</h5>
                <p class="text-secondary small mb-0">Apakah Anda yakin? Tindakan ini tidak dapat dibatalkan.</p>
                
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button" class="btn btn-secondary bg-opacity-10 border-0 w-50 py-2 rounded-3 small fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnConfirmDeleteArticle" class="btn btn-danger w-50 py-2 rounded-3 small fw-semibold shadow-sm">Ya, Hapus</button>
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

<script src="{{ asset('js/article.js') }}"></script>
@include('partials.admin.footer')