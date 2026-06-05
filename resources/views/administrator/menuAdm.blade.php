@include('partials.head')
@include('partials.navbar')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">

<!-- Menggunakan background abu-abu sangat lembut agar kartu putih di atasnya terlihat stand-out -->
<div class="container-fluid bg-light min-vh-100 py-4 px-md-5" style="background-color: #f8f9fa !important;">
    
    <!-- Title Section: Dibuat rata kiri khas dashboard modern -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold text-dark m-0 tracking-tight">Menu Management</h4>
            <p class="text-muted small m-0 mt-1">Kelola daftar menu makanan, kategori, serta harga secara real-time</p>
        </div>
        <div class="mt-3 mt-md-0">
            <!-- Tombol dibuat lebih tebal dan elegan dengan bayangan halus -->
            <button class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="modal" data-bs-target="#createMenu">
                <i class="bi bi-plus-lg"></i> Add New Menu
            </button>
        </div>
    </div>

    <!-- Action Bar: Filter & Search digabung dalam satu baris bersih -->
    <div class="row g-3 justify-content-end align-items-center mb-4">
        <div class="col-12 col-md-auto d-flex gap-2">
            <!-- Dropdown Filter Kategori: Menggunakan style borderless/soft-border -->
            <select id="filterCategory" class="form-select border-0 shadow-sm py-2 rounded-3 text-secondary bg-white" style="min-width: 180px;">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <!-- Kolom Search -->
            <div class="input-group shadow-sm bg-white rounded-3 overflow-hidden" style="min-width: 260px;">
                <span class="input-group-text bg-white border-0 text-muted pe-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="search" class="form-control border-0 py-2 shadow-none" placeholder="Cari menu...">
            </div>
        </div>
    </div>
    
    <!-- Table Canvas: Menghapus border kaku, diganti bayangan lembut -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
        <div class="table-responsive">
            <!-- Menggunakan table-borderless agar tidak pusing melihat garis kotak-kotak kaku -->
            <table class="table table-hover table-borderless align-middle mb-0 w-100">
                <thead class="table-light text-center text-secondary small fw-bold text-uppercase border-bottom">
                    <tr>
                        <th scope="col" class="py-3" style="width: 5%">No</th>
                        <th scope="col" class="py-3" style="width: 12%">Image</th>
                        <th scope="col" class="py-3 text-start">Nama Menu</th>
                        <th scope="col" class="py-3 text-start" style="width: 25%">Description</th>
                        <th scope="col" class="py-3">Harga</th>
                        <th scope="col" class="py-3">Kategori</th>
                        <th scope="col" class="py-3">Tanggal Ditambahkan</th>
                        <th scope="col" class="py-3" style="width: 10%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="menuTableBody" class="text-center text-secondary">
                    <!-- Data di-render dinamis via AJAX -->
                </tbody>
            </table>
        </div> 
        
        <!-- Paginasi -->
        <div class="d-flex justify-content-center py-3 bg-white border-top">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0 gap-1" id="paginationContainer"></ul>
            </nav>
        </div>
    </div>
</div>

<!-- ==========================================
     MODAL COMPONENT: CREATE MENU
     ========================================== -->
<div class="modal fade" id="createMenu" tabindex="-1" aria-labelledby="createMenuModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2">
                <h5 class="modal-title fw-bold text-dark" id="createMenuModal">Add New Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="formTambahMenu" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 pb-0">
                    <div class="row g-3">
                        <!-- KOLOM KIRI (PREVIEW GAMBAR) -->
                        <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
                            <div class="text-center bg-light p-3 rounded-3 border border-2 border-dashed h-100 d-flex flex-column justify-content-center align-items-center" style="min-height: 220px;">
                                <img id="preview" width="140" height="140" class="rounded-3 shadow-sm mb-3 object-fit-cover d-none" alt="Preview">
                                <i class="bi bi-image text-muted display-5 mb-2"></i>
                                <label for="image" class="form-label text-primary small fw-bold cursor-pointer m-0">Upload Menu Image</label>
                                <input type="file" class="form-control form-control-sm mt-2" id="image" name="image" required>
                            </div>
                        </div>

                        <!-- KOLOM KANAN (FORM INPUT DATA) -->
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label small fw-bold text-secondary mb-1">Name</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" id="name" name="name" placeholder="Masukkan nama menu" required>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label small fw-bold text-secondary mb-1">Category</label>
                                <select name="category_id" id="category_id" class="form-select bg-light border-0 py-2 rounded-3" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label small fw-bold text-secondary mb-1">Price (IDR)</label>
                                <input type="number" class="form-control bg-light border-0 py-2 rounded-3" id="price" name="price" placeholder="Contoh: 25000" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label small fw-bold text-secondary mb-1">Description</label>
                                <textarea class="form-control bg-light border-0 py-2 rounded-3 textarea-fixed" id="description" name="description" rows="2" placeholder="Tulis deskripsi singkat..." required></textarea>
                            </div>

                            <div class="form-check form-switch mt-2 p-2 bg-light rounded-3 ps-5">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured">
                                <label class="form-check-label small fw-bold text-secondary" for="is_featured">Set sebagai Menu Unggulan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4 pt-3">
                    <button type="button" class="btn btn-light px-3 py-2 rounded-3 fw-semibold small" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold small shadow-sm">Add Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==========================================
     MODAL COMPONENT: UPDATE MENU
     ========================================== -->
<div class="modal fade" id="updateMenu" tabindex="-1" aria-labelledby="updateMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2">
                <h5 class="modal-title fw-bold text-dark" id="updateMenuModalLabel">Edit Menu Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="formUpdateMenu" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 pb-0">
                    <input type="hidden" id="edit-id" name="id">

                    <div class="row g-3">
                        <!-- KOLOM KIRI (PREVIEW GAMBAR CURRENT) -->
                        <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
                            <div class="text-center bg-light p-3 rounded-3 border h-100 d-flex flex-column justify-content-center align-items-center" style="min-height: 220px;">
                                <img id="edit-preview" width="140" height="140" class="rounded-3 mb-3 object-fit-cover shadow-sm d-block mx-auto" alt="Current Image">
                                <label for="edit-image" class="form-label text-muted small fw-bold d-block">Ubah Gambar (Kosongkan jika tidak diganti)</label>
                                <input type="file" class="form-control form-control-sm mt-2" id="edit-image" name="image">
                            </div>
                        </div>

                        <!-- KOLOM KANAN (FORM EDIT DATA) -->
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="edit-name" class="form-label small fw-bold text-secondary mb-1">Name</label>
                                <input type="text" class="form-control bg-light border-0 py-2 rounded-3" id="edit-name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-category" class="form-label small fw-bold text-secondary mb-1">Category</label>
                                <select name="category_id" id="edit-category" class="form-select bg-light border-0 py-2 rounded-3" required>
                                    <option value="" disabled>Pilih Kategori</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="edit-price" class="form-label small fw-bold text-secondary mb-1">Price (IDR)</label>
                                <input type="number" class="form-control bg-light border-0 py-2 rounded-3" id="edit-price" name="price" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-description" class="form-label small fw-bold text-secondary mb-1">Description</label>
                                <textarea class="form-control bg-light border-0 py-2 rounded-3 textarea-fixed" id="edit-description" name="description" rows="2" required></textarea>
                            </div>

                            <div class="form-check form-switch mt-2 p-2 bg-light rounded-3 ps-5">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="edit-is-featured">
                                <label class="form-check-label small fw-bold text-secondary" for="edit-is-featured">Featured Menu</label>
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

<!-- ==========================================
     MODAL COMPONENT: DELETE CONFIRMATION
     ========================================== -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center p-4">
                <!-- Icon alert dibuat melingkar halus -->
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                    <i class="bi bi-exclamation-triangle fs-4"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Hapus Menu?</h5>
                <p class="text-muted small mb-0">Apakah Anda yakin? Tindakan ini tidak dapat dibatalkan.</p>
                
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button" class="btn btn-light w-50 py-2 rounded-3 small fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnConfirmDelete" class="btn btn-danger w-50 py-2 rounded-3 small fw-semibold shadow-sm">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     GLOBAL TOAST CONTAINER
     ========================================== -->
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
<script src="{{ asset('js/menu.js') }}"></script>
@include('partials.foot')