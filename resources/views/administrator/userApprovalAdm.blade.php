@include('partials.admin.header')
@include('partials.admin.navbar')

<div class="container-fluid bg-body-secondary min-vh-100 py-4 px-md-5">

    <!-- Title Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-light-subtle">
        <div>
            <h4 class="fw-bold text-body m-0 tracking-tight">User Approval</h4>
            <p class="text-secondary small m-0 mt-1">Periksa dan setujui pendaftaran akun administrator baru secara real-time</p>
        </div>
        {{-- Badge count per status --}}
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2 small fw-semibold">
                Pending: <span id="countPending">{{ $counts['pending'] }}</span>
            </span>
            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2 small fw-semibold">
                Approved: <span id="countApproved">{{ $counts['approved'] }}</span>
            </span>
            <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2 small fw-semibold">
                Rejected: <span id="countRejected">{{ $counts['rejected'] }}</span>
            </span>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="row g-3 justify-content-end align-items-center mb-4">
        <div class="col-12 col-md-auto d-flex gap-2">
            <select id="filterApproval" class="form-select border-0 shadow-sm py-2 rounded-3 text-secondary bg-body" style="min-width: 180px;">
                <option value="pending">Pending Approval</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
            <div class="input-group shadow-sm bg-body rounded-3 overflow-hidden" style="min-width: 260px;">
                <span class="input-group-text bg-body border-0 text-secondary pe-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="searchUser" class="form-control bg-body text-body border-0 py-2 shadow-none" placeholder="Cari nama atau email...">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-body">
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle text-center mb-0 w-100">
                <thead class="text-secondary small fw-bold text-uppercase border-bottom border-light-subtle">
                    <tr>
                        <th class="py-3" style="width: 5%">No</th>
                        <th class="py-3 text-start" style="width: 25%">User Information</th>
                        <th class="py-3 text-start">Username</th>
                        <th class="py-3">Registered At</th>
                        {{-- <th class="py-3">Approved By</th> --}}
                        <th class="py-3">Status</th>
                        <th class="py-3" style="width: 20%">Action</th>
                    </tr>
                </thead>
                <tbody id="userApprovalTableBody" class="text-secondary">
                    {{-- Diisi via AJAX --}}
                    <tr id="loadingRow">
                        <td colspan="6" class="py-5 text-secondary">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            Memuat data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center py-3 bg-body border-top border-light-subtle">
            <nav>
                <ul class="pagination pagination-sm mb-0 gap-1" id="paginationContainer"></ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4 bg-body text-body">
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-body m-0">Tolak Pendaftaran Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-secondary small mb-3">Tindakan ini akan mencegah user login ke sistem.</p>
                <div class="d-flex justify-content-end gap-2 mt-2">
                    <button type="button" class="btn btn-secondary bg-opacity-10 border-0 px-3 py-2 rounded-3 fw-semibold small" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnConfirmReject" class="btn btn-danger px-4 py-2 rounded-3 fw-semibold small shadow-sm">Tolak Akun</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="liveToast" class="toast align-items-center border-0 text-white shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body fw-semibold small">
                <span id="toastMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    // ── State ──────────────────────────────────────────────
    let currentPage   = 1;
    let currentStatus = 'pending';
    let currentSearch = '';
    let rejectUserId  = null;
    let searchTimer   = null;

    // ── CSRF untuk semua AJAX POST/PATCH/DELETE ────────────
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ── Load awal ──────────────────────────────────────────
    loadUsers();

    // ── Filter status berubah ──────────────────────────────
    $('#filterApproval').on('change', function () {
        currentStatus = $(this).val();
        currentPage   = 1;
        loadUsers();
    });

    // ── Search dengan debounce 400ms ───────────────────────
    $('#searchUser').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            currentSearch = $('#searchUser').val();
            currentPage   = 1;
            loadUsers();
        }, 400);
    });

    // ── Fungsi utama load data via AJAX ───────────────────
    function loadUsers() {
        $('#userApprovalTableBody').html(`
            <tr>
                <td colspan="6" class="py-5 text-secondary">
                    <div class="spinner-border spinner-border-sm me-2"></div>Memuat data...
                </td>
            </tr>
        `);

        $.ajax({
            url: '{{ route("administrator.users.index") }}',
            method: 'GET',
            data: {
                status: currentStatus,
                search: currentSearch,
                page:   currentPage,
            },
            success: function (res) {
                renderTable(res.data, res.from);
                renderPagination(res.current_page, res.last_page);
                updateCounts(res.counts);
            },
            error: function () {
                showToast('Gagal memuat data. Silakan refresh halaman.', 'danger');
            }
        });
    }

    // ── Render baris tabel ────────────────────────────────
    function renderTable(users, from) {
        if (!users || users.length === 0) {
            $('#userApprovalTableBody').html(`
                <tr>
                    <td colspan="6" class="py-5 text-secondary">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        Tidak ada data untuk ditampilkan.
                    </td>
                </tr>
            `);
            return;
        }

        let rows = '';
        users.forEach(function (user, index) {
            const statusBadge = getStatusBadge(user.status);
            const actions     = getActionButtons(user);
            const avatar      = getAvatar(user.name);
            const date        = formatDate(user.created_at);

            rows += `
                <tr>
                    <td class="py-3 text-secondary small">${(from + index)}</td>
                    <td class="py-3 text-start">
                        <div class="d-flex align-items-center gap-2">
                            ${avatar}
                            <div>
                                <div class="fw-semibold text-body small">${escapeHtml(user.name)}</div>
                                <div class="text-secondary" style="font-size:0.78rem">${escapeHtml(user.email)}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 text-start small">${escapeHtml(user.name)}</td>
                    <td class="py-3 small">${date}</td>
                    <td class="py-3">${statusBadge}</td>
                    <td class="py-3">${actions}</td>
                </tr>
            `;
        });

        $('#userApprovalTableBody').html(rows);
    }

    // ── Render pagination ─────────────────────────────────
    function renderPagination(current, last) {
        if (last <= 1) {
            $('#paginationContainer').html('');
            return;
        }

        let html = '';

        // Prev
        html += `
            <li class="page-item ${current === 1 ? 'disabled' : ''}">
                <a class="page-link rounded-2 border-0 shadow-sm" href="#" data-page="${current - 1}">
                    <i class="bi bi-chevron-left small"></i>
                </a>
            </li>`;

        // Angka halaman
        for (let i = 1; i <= last; i++) {
            html += `
                <li class="page-item ${i === current ? 'active' : ''}">
                    <a class="page-link rounded-2 border-0 shadow-sm" href="#" data-page="${i}">${i}</a>
                </li>`;
        }

        // Next
        html += `
            <li class="page-item ${current === last ? 'disabled' : ''}">
                <a class="page-link rounded-2 border-0 shadow-sm" href="#" data-page="${current + 1}">
                    <i class="bi bi-chevron-right small"></i>
                </a>
            </li>`;

        $('#paginationContainer').html(html);
    }

    // ── Klik pagination ───────────────────────────────────
    $(document).on('click', '#paginationContainer .page-link', function (e) {
        e.preventDefault();
        const page = parseInt($(this).data('page'));
        if (!isNaN(page) && page !== currentPage) {
            currentPage = page;
            loadUsers();
        }
    });

    // ── Approve ───────────────────────────────────────────
    $(document).on('click', '.btn-approve', function () {
        const userId   = $(this).data('id');
        const userName = $(this).data('name');
        const $btn     = $(this);

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({
            url:    `/administrator/users/${userId}/approve`,
            method: 'PATCH',
            success: function (res) {
                showToast(res.message, 'success');
                loadUsers();
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message ?? 'Gagal menyetujui akun.';
                showToast(msg, 'danger');
                $btn.prop('disabled', false).html('Setujui');
            }
        });
    });

    // ── Reject — buka modal dulu ──────────────────────────
    $(document).on('click', '.btn-reject', function () {
        rejectUserId = $(this).data('id');
        $('#rejectUserModal').modal('show');
    });

    // ── Confirm reject dari modal ─────────────────────────
    $('#btnConfirmReject').on('click', function () {
        if (!rejectUserId) return;

        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({
            url:    `/administrator/users/${rejectUserId}/reject`,
            method: 'PATCH',
            success: function (res) {
                $('#rejectUserModal').modal('hide');
                showToast(res.message, 'danger');
                loadUsers();
                rejectUserId = null;
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message ?? 'Gagal menolak akun.';
                showToast(msg, 'danger');
            },
            complete: function () {
                $btn.prop('disabled', false).html('Tolak Akun');
            }
        });
    });

    // ── Update badge count ────────────────────────────────
    function updateCounts(counts) {
        if (!counts) return;
        $('#countPending').text(counts.pending);
        $('#countApproved').text(counts.approved);
        $('#countRejected').text(counts.rejected);
    }

    // ── Helper: status badge ──────────────────────────────
    function getStatusBadge(status) {
        const map = {
            pending:  '<span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2 small">Pending</span>',
            approved: '<span class="badge rounded-pill bg-success-subtle text-success px-3 py-2 small">Approved</span>',
            rejected: '<span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2 small">Rejected</span>',
        };
        return map[status] ?? '-';
    }

    // ── Helper: tombol aksi berdasarkan status ────────────
    function getActionButtons(user) {
        if (user.status === 'pending') {
            return `
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-success btn-sm rounded-3 px-3 py-1 small fw-semibold btn-approve shadow-sm"
                        data-id="${user.id}" data-name="${escapeHtml(user.name)}">
                        <i class="bi bi-check-lg me-1"></i>Setujui
                    </button>
                    <button class="btn btn-outline-danger btn-sm rounded-3 px-3 py-1 small fw-semibold btn-reject shadow-sm"
                        data-id="${user.id}">
                        <i class="bi bi-x-lg me-1"></i>Tolak
                    </button>
                </div>`;
        }

        if (user.status === 'approved') {
            return `
                <button class="btn btn-outline-danger btn-sm rounded-3 px-3 py-1 small fw-semibold btn-reject shadow-sm"
                    data-id="${user.id}">
                    <i class="bi bi-slash-circle me-1"></i>Cabut Akses
                </button>`;
        }

        if (user.status === 'rejected') {
            return `
                <button class="btn btn-outline-success btn-sm rounded-3 px-3 py-1 small fw-semibold btn-approve shadow-sm"
                    data-id="${user.id}" data-name="${escapeHtml(user.name)}">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Pulihkan
                </button>`;
        }

        return '-';
    }

    // ── Helper: avatar inisial ────────────────────────────
    function getAvatar(name) {
        const initials = name.split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase();
        const colors   = ['#6366f1','#8b5cf6','#ec4899','#f59e0b','#10b981','#3b82f6'];
        const color    = colors[name.charCodeAt(0) % colors.length];
        return `
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-white fw-bold"
                style="width:36px;height:36px;font-size:0.75rem;background:${color}">
                ${initials}
            </div>`;
    }

    // ── Helper: format tanggal ────────────────────────────
    function formatDate(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
    }

    // ── Helper: escape XSS ───────────────────────────────
    function escapeHtml(str) {
        return String(str)
            .replace(/&/g,'&amp;')
            .replace(/</g,'&lt;')
            .replace(/>/g,'&gt;')
            .replace(/"/g,'&quot;');
    }

    // ── Helper: Toast notifikasi ──────────────────────────
    function showToast(message, type = 'success') {
        const colorMap = {
            success: 'bg-success',
            danger:  'bg-danger',
            warning: 'bg-warning',
            info:    'bg-primary',
        };
        const $toast = $('#liveToast');
        $toast.removeClass('bg-success bg-danger bg-warning bg-primary')
              .addClass(colorMap[type] ?? 'bg-success');
        $('#toastMessage').text(message);
        bootstrap.Toast.getOrCreateInstance($toast[0]).show();
    }

});
</script>

@include('partials.admin.footer')