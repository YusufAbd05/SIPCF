<?= $this->extend('template/admin/base') ?>
<?= $this->section('title') ?>Kelola Lapang<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    /* ===== PAGE HEADER ===== */
    .page-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .page-header__title {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--admin-on-surface);
        margin-bottom: 0.15rem;
    }
    .page-header__subtitle {
        font-size: 0.8rem;
        color: var(--admin-secondary);
        margin-bottom: 0;
    }
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.25rem;
        background: linear-gradient(135deg, #0057cd 0%, #0d6efd 100%);
        color: #fff;
        border: none;
        border-radius: 0.625rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px -2px rgba(0, 87, 205, 0.3);
    }
    .btn-add:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px -4px rgba(0, 87, 205, 0.4);
        color: #fff;
    }
    .btn-add:active { transform: scale(0.97); }
    .btn-add .material-symbols-outlined { font-size: 1.1rem; }

    /* ===== STATS ===== */
    .stats-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .stat-chip {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--admin-surface-lowest);
        border: 1px solid rgba(194, 198, 216, 0.1);
        border-radius: 0.625rem;
        padding: 0.75rem 1.25rem;
        flex: 1;
        min-width: 140px;
    }
    .stat-chip__icon {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-chip__icon .material-symbols-outlined { font-size: 1.15rem; }
    .stat-chip__icon.blue  { background: #eff6ff; color: #2563eb; }
    .stat-chip__icon.green { background: #ecfdf5; color: #059669; }
    .stat-chip__icon.amber { background: #fffbeb; color: #d97706; }
    .stat-chip__label {
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--admin-secondary);
        margin-bottom: 0;
    }
    .stat-chip__value {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--admin-on-surface);
        line-height: 1;
        margin-bottom: 0;
    }

    /* ===== TABLE CARD ===== */
    .table-card {
        background: var(--admin-surface-lowest);
        border-radius: 0.75rem;
        border: 1px solid rgba(194, 198, 216, 0.05);
        overflow: hidden;
    }
    .table-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--admin-surface-container);
    }
    .table-search {
        display: flex;
        align-items: center;
        background: var(--admin-surface-low);
        border-radius: 0.5rem;
        padding: 0.4rem 0.75rem;
        border: 1px solid transparent;
        transition: all 0.2s;
    }
    .table-search:focus-within {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(0, 87, 205, 0.08);
        background: #fff;
    }
    .table-search .material-symbols-outlined {
        font-size: 1.1rem;
        color: var(--admin-outline);
        margin-right: 0.5rem;
    }
    .table-search input {
        border: none;
        background: transparent;
        font-size: 0.8rem;
        outline: none;
        width: 14rem;
        font-family: 'Inter', sans-serif;
    }
    .table-search input::placeholder { color: var(--admin-outline); }
    .table-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.45rem 0.85rem;
        border: 1.5px solid var(--admin-outline-variant);
        border-radius: 0.5rem;
        background: transparent;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--admin-on-surface-variant);
        cursor: pointer;
        transition: all 0.2s;
    }
    .table-filter-btn:hover {
        background: var(--admin-surface-low);
        border-color: var(--admin-primary-fixed-dim);
    }
    .table-filter-btn .material-symbols-outlined { font-size: 1rem; }

    /* Table */
    .lapang-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .lapang-table thead th {
        background: var(--admin-surface-low);
        font-family: 'Inter', sans-serif;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--admin-secondary);
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid var(--admin-surface-container);
        white-space: nowrap;
    }
    .lapang-table tbody td {
        font-family: 'Inter', sans-serif;
        font-size: 0.825rem;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--admin-surface-container);
        vertical-align: middle;
        color: var(--admin-on-surface);
    }
    .lapang-table tbody tr {
        transition: background 0.15s;
    }
    .lapang-table tbody tr:hover {
        background: rgba(0, 87, 205, 0.02);
    }
    .lapang-table tbody tr:last-child td {
        border-bottom: none;
    }
    .td-name {
        font-weight: 700;
        color: var(--admin-on-surface);
    }
    .td-price {
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--admin-on-surface);
    }

    /* Operating hours in table */
    .td-hours {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }
    .td-hours-item {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.68rem;
        color: var(--admin-on-surface-variant);
    }
    .td-hours-item .day {
        font-weight: 700;
        font-size: 0.62rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--admin-secondary);
        min-width: 2.8rem;
    }
    .td-hours-item .time {
        font-weight: 600;
        color: var(--admin-on-surface);
        font-size: 0.72rem;
    }

    /* Status badges */
    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.25rem 0.7rem;
        border-radius: 9999px;
    }
    .badge-pill .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .badge-pill.dapat-digunakan       { background: #ecfdf5; color: #059669; }
    .badge-pill.dapat-digunakan .dot  { background: #059669; }
    .badge-pill.perbaikan             { background: #fffbeb; color: #d97706; }
    .badge-pill.perbaikan .dot        { background: #d97706; }

    /* Action buttons */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
        padding: 0.35rem 0.65rem;
        border-radius: 0.375rem;
        border: 1.5px solid transparent;
        background: transparent;
        cursor: pointer;
        transition: all 0.15s;
        font-family: 'Inter', sans-serif;
        font-size: 0.68rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .action-btn .material-symbols-outlined { font-size: 0.95rem; }
    .action-btn.edit {
        color: var(--admin-primary);
        border-color: #dbeafe;
        background: #eff6ff;
    }
    .action-btn.edit:hover {
        background: #dbeafe;
        border-color: #93c5fd;
    }

    /* Pagination */
    .table-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        gap: 0.75rem;
    }
    .table-footer__info { font-size: 0.75rem; color: var(--admin-secondary); }
    .pagination-custom { display: flex; gap: 0.25rem; }
    .page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
        height: 2rem;
        border-radius: 0.375rem;
        border: 1px solid var(--admin-outline-variant);
        background: transparent;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--admin-on-surface-variant);
        cursor: pointer;
        transition: all 0.15s;
    }
    .page-btn:hover { background: var(--admin-surface-low); border-color: var(--admin-primary-fixed-dim); }
    .page-btn.active { background: var(--admin-primary); color: #fff; border-color: var(--admin-primary); }
    .page-btn .material-symbols-outlined { font-size: 1rem; }

    /* ===== MODAL ===== */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }
    .modal-header {
        border-bottom: 1px solid var(--admin-surface-container);
        padding: 1.5rem 1.75rem 1.25rem;
    }
    .modal-title {
        font-family: 'Inter', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--admin-on-surface);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .modal-title .material-symbols-outlined { font-size: 1.35rem; color: var(--admin-primary); }
    .modal-body { padding: 1.5rem 1.75rem; }
    .modal-footer {
        border-top: 1px solid var(--admin-surface-container);
        padding: 1rem 1.75rem 1.25rem;
    }
    .form-label-custom {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--admin-on-surface-variant);
        margin-bottom: 0.4rem;
    }
    .form-label-custom .material-symbols-outlined { font-size: 0.95rem; color: var(--admin-primary); }
    .form-control-custom {
        width: 100%;
        padding: 0.6rem 0.85rem;
        border: 1.5px solid var(--admin-outline-variant);
        border-radius: 0.5rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: var(--admin-on-surface);
        background: var(--admin-surface-lowest);
        outline: none;
        transition: all 0.2s;
    }
    .form-control-custom:focus {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(0, 87, 205, 0.08);
    }
    .form-control-custom::placeholder { color: var(--admin-outline); }
    select.form-control-custom { cursor: pointer; }
    .btn-modal-save {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.6rem 1.5rem;
        background: linear-gradient(135deg, #0057cd 0%, #0d6efd 100%);
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px -2px rgba(0, 87, 205, 0.3);
    }
    .btn-modal-save:hover { transform: translateY(-1px); color: #fff; }
    .btn-modal-save .material-symbols-outlined { font-size: 1rem; }
    .btn-modal-cancel {
        padding: 0.6rem 1.25rem;
        border: 1.5px solid var(--admin-outline-variant);
        border-radius: 0.5rem;
        background: transparent;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--admin-on-surface-variant);
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-modal-cancel:hover { background: var(--admin-surface-low); }
    .form-section-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--admin-primary);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--admin-primary-fixed);
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }
    .form-section-title .material-symbols-outlined { font-size: 1rem; }

    /* Price input */
    .price-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .price-input-wrap .prefix {
        position: absolute;
        left: 0.75rem;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--admin-secondary);
    }
    .price-input-wrap input { padding-left: 2.5rem; }

    /* Operating hours rows */
    .hours-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0;
        font-size: 0.78rem;
    }
    .hours-row .day-label {
        width: 3.5rem;
        font-weight: 600;
        font-size: 0.7rem;
        color: var(--admin-on-surface-variant);
    }
    .hours-input {
        width: 5.5rem;
        padding: 0.35rem 0.5rem;
        border: 1.5px solid var(--admin-outline-variant);
        border-radius: 0.375rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.72rem;
        text-align: center;
        outline: none;
        transition: all 0.2s;
    }
    .hours-input:focus {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 2px rgba(0, 87, 205, 0.06);
    }
    .hours-sep {
        font-size: 0.7rem;
        color: var(--admin-outline);
        font-weight: 600;
    }
</style>

<main class="flex-grow-1 p-3 p-md-5" style="background:var(--admin-surface);">

    <!-- Page Header -->
    <div class="page-header animate-in">
        <div>
            <h2 class="page-header__title">Kelola Lapang</h2>
            <p class="page-header__subtitle">Manajemen data lapangan olahraga</p>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addLapangModal">
            <span class="material-symbols-outlined">add_circle</span>
            Tambah Lapang
        </button>
    </div>

    <!-- Stats -->
    <div class="stats-row animate-in" style="animation-delay:.06s;">
        <div class="stat-chip">
            <div class="stat-chip__icon blue"><span class="material-symbols-outlined">stadium</span></div>
            <div>
                <p class="stat-chip__label">Total Lapang</p>
                <p class="stat-chip__value">6</p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon green"><span class="material-symbols-outlined">check_circle</span></div>
            <div>
                <p class="stat-chip__label">Dapat Digunakan</p>
                <p class="stat-chip__value">5</p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon amber"><span class="material-symbols-outlined">build</span></div>
            <div>
                <p class="stat-chip__label">Perbaikan</p>
                <p class="stat-chip__value">1</p>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card animate-in" style="animation-delay:.12s;">
        <div class="table-toolbar">
            <div class="table-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" placeholder="Cari nama lapang..." />
            </div>
            <div class="d-flex gap-2">
                <button class="table-filter-btn">
                    <span class="material-symbols-outlined">filter_list</span> Filter Status
                </button>
                <button class="table-filter-btn">
                    <span class="material-symbols-outlined">download</span> Export
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="lapang-table">
                <thead>
                    <tr>
                        <th>Nama Lapang</th>
                        <th>Jam Operasional</th>
                        <th>Harga Per Jam</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="td-name">Lapang Futsal A</span></td>
                        <td>
                            <div class="td-hours">
                                <div class="td-hours-item"><span class="day">Sen-Jum</span> <span class="time">08:00 — 22:00</span></div>
                                <div class="td-hours-item"><span class="day">Sabtu</span> <span class="time">07:00 — 23:00</span></div>
                                <div class="td-hours-item"><span class="day">Minggu</span> <span class="time">07:00 — 21:00</span></div>
                            </div>
                        </td>
                        <td class="td-price">Rp 150.000</td>
                        <td><span class="badge-pill dapat-digunakan"><span class="dot"></span>Dapat Digunakan</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editLapangModal">
                                <span class="material-symbols-outlined">edit</span> Edit
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="td-name">Lapang Futsal B</span></td>
                        <td>
                            <div class="td-hours">
                                <div class="td-hours-item"><span class="day">Sen-Jum</span> <span class="time">08:00 — 22:00</span></div>
                                <div class="td-hours-item"><span class="day">Sabtu</span> <span class="time">07:00 — 23:00</span></div>
                                <div class="td-hours-item"><span class="day">Minggu</span> <span class="time">07:00 — 21:00</span></div>
                            </div>
                        </td>
                        <td class="td-price">Rp 150.000</td>
                        <td><span class="badge-pill dapat-digunakan"><span class="dot"></span>Dapat Digunakan</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editLapangModal">
                                <span class="material-symbols-outlined">edit</span> Edit
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="td-name">Lapang Badminton 1</span></td>
                        <td>
                            <div class="td-hours">
                                <div class="td-hours-item"><span class="day">Sen-Jum</span> <span class="time">08:00 — 22:00</span></div>
                                <div class="td-hours-item"><span class="day">Sabtu</span> <span class="time">07:00 — 23:00</span></div>
                                <div class="td-hours-item"><span class="day">Minggu</span> <span class="time">07:00 — 21:00</span></div>
                            </div>
                        </td>
                        <td class="td-price">Rp 75.000</td>
                        <td><span class="badge-pill dapat-digunakan"><span class="dot"></span>Dapat Digunakan</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editLapangModal">
                                <span class="material-symbols-outlined">edit</span> Edit
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="td-name">Lapang Basket Indoor</span></td>
                        <td>
                            <div class="td-hours">
                                <div class="td-hours-item"><span class="day">Sen-Jum</span> <span class="time">08:00 — 22:00</span></div>
                                <div class="td-hours-item"><span class="day">Sabtu</span> <span class="time">07:00 — 23:00</span></div>
                                <div class="td-hours-item"><span class="day">Minggu</span> <span class="time">07:00 — 21:00</span></div>
                            </div>
                        </td>
                        <td class="td-price">Rp 200.000</td>
                        <td><span class="badge-pill perbaikan"><span class="dot"></span>Perbaikan</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editLapangModal">
                                <span class="material-symbols-outlined">edit</span> Edit
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="td-name">Lapang Voli Outdoor</span></td>
                        <td>
                            <div class="td-hours">
                                <div class="td-hours-item"><span class="day">Sen-Jum</span> <span class="time">08:00 — 22:00</span></div>
                                <div class="td-hours-item"><span class="day">Sabtu</span> <span class="time">07:00 — 23:00</span></div>
                                <div class="td-hours-item"><span class="day">Minggu</span> <span class="time">07:00 — 21:00</span></div>
                            </div>
                        </td>
                        <td class="td-price">Rp 100.000</td>
                        <td><span class="badge-pill dapat-digunakan"><span class="dot"></span>Dapat Digunakan</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editLapangModal">
                                <span class="material-symbols-outlined">edit</span> Edit
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="td-name">Lapang Tenis Meja</span></td>
                        <td>
                            <div class="td-hours">
                                <div class="td-hours-item"><span class="day">Sen-Jum</span> <span class="time">08:00 — 22:00</span></div>
                                <div class="td-hours-item"><span class="day">Sabtu</span> <span class="time">07:00 — 23:00</span></div>
                                <div class="td-hours-item"><span class="day">Minggu</span> <span class="time">07:00 — 21:00</span></div>
                            </div>
                        </td>
                        <td class="td-price">Rp 50.000</td>
                        <td><span class="badge-pill dapat-digunakan"><span class="dot"></span>Dapat Digunakan</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editLapangModal">
                                <span class="material-symbols-outlined">edit</span> Edit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span class="table-footer__info">Menampilkan 1-6 dari 6 data</span>
            <div class="pagination-custom">
                <button class="page-btn"><span class="material-symbols-outlined">chevron_left</span></button>
                <button class="page-btn active">1</button>
                <button class="page-btn"><span class="material-symbols-outlined">chevron_right</span></button>
            </div>
        </div>
    </div>

</main>

<!-- ===== MODAL: TAMBAH LAPANG ===== -->
<div class="modal fade" id="addLapangModal" tabindex="-1" aria-labelledby="addLapangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLapangLabel">
                    <span class="material-symbols-outlined">add_circle</span>
                    Tambah Lapang Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddLapang">
                    <!-- Section: Informasi Lapang -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">info</span>
                        Informasi Lapang
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">stadium</span> Nama Lapang
                            </label>
                            <input type="text" class="form-control-custom" placeholder="Contoh: Lapang Futsal A" required />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">payments</span> Harga Per Jam
                            </label>
                            <div class="price-input-wrap">
                                <span class="prefix">Rp</span>
                                <input type="number" class="form-control-custom" placeholder="0" required />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">flag</span> Status
                            </label>
                            <select class="form-control-custom" required>
                                <option value="dapat_digunakan">Dapat Digunakan</option>
                                <option value="perbaikan">Perbaikan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section: Jam Operasional -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">schedule</span>
                        Jam Operasional
                    </div>
                    <div class="mb-3">
                        <div class="hours-row">
                            <span class="day-label">Sen-Jum</span>
                            <input type="time" class="hours-input" value="08:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="22:00">
                        </div>
                        <div class="hours-row">
                            <span class="day-label">Sabtu</span>
                            <input type="time" class="hours-input" value="07:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="23:00">
                        </div>
                        <div class="hours-row">
                            <span class="day-label">Minggu</span>
                            <input type="time" class="hours-input" value="07:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="21:00">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-modal-save">
                    <span class="material-symbols-outlined">save</span> Simpan Lapang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL: EDIT LAPANG ===== -->
<div class="modal fade" id="editLapangModal" tabindex="-1" aria-labelledby="editLapangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLapangLabel">
                    <span class="material-symbols-outlined">edit</span>
                    Edit Lapang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditLapang">
                    <!-- Section: Informasi Lapang -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">info</span>
                        Informasi Lapang
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">stadium</span> Nama Lapang
                            </label>
                            <input type="text" class="form-control-custom" value="Lapang Futsal A" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">payments</span> Harga Per Jam
                            </label>
                            <div class="price-input-wrap">
                                <span class="prefix">Rp</span>
                                <input type="number" class="form-control-custom" value="150000" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">flag</span> Status
                            </label>
                            <select class="form-control-custom">
                                <option value="dapat_digunakan" selected>Dapat Digunakan</option>
                                <option value="perbaikan">Perbaikan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section: Jam Operasional -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">schedule</span>
                        Jam Operasional
                    </div>
                    <div class="mb-3">
                        <div class="hours-row">
                            <span class="day-label">Sen-Jum</span>
                            <input type="time" class="hours-input" value="08:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="22:00">
                        </div>
                        <div class="hours-row">
                            <span class="day-label">Sabtu</span>
                            <input type="time" class="hours-input" value="07:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="23:00">
                        </div>
                        <div class="hours-row">
                            <span class="day-label">Minggu</span>
                            <input type="time" class="hours-input" value="07:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="21:00">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-modal-save">
                    <span class="material-symbols-outlined">save</span> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>