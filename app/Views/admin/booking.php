<?= $this->extend('template/admin/base') ?>
<?= $this->section('title') ?>Kelola Booking<?= $this->endSection() ?>
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
    .btn-add-booking {
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
    .btn-add-booking:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px -4px rgba(0, 87, 205, 0.4);
        color: #fff;
    }
    .btn-add-booking:active { transform: scale(0.97); }
    .btn-add-booking .material-symbols-outlined { font-size: 1.1rem; }

    /* ===== STATS ROW ===== */
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
        border: 1px solid rgba(194,198,216,0.1);
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
    .stat-chip__icon.blue   { background: #eff6ff; color: #2563eb; }
    .stat-chip__icon.green  { background: #ecfdf5; color: #059669; }
    .stat-chip__icon.amber  { background: #fffbeb; color: #d97706; }
    .stat-chip__icon.red    { background: #fef2f2; color: #dc2626; }
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
        border: 1px solid rgba(194,198,216,0.05);
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
        box-shadow: 0 0 0 3px rgba(0,87,205,0.08);
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
    .booking-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .booking-table thead th {
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
    .booking-table tbody td {
        font-family: 'Inter', sans-serif;
        font-size: 0.825rem;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--admin-surface-container);
        vertical-align: middle;
        color: var(--admin-on-surface);
    }
    .booking-table tbody tr {
        transition: background 0.15s;
    }
    .booking-table tbody tr:hover {
        background: rgba(0,87,205,0.02);
    }
    .booking-table tbody tr:last-child td {
        border-bottom: none;
    }

    .td-code {
        font-weight: 700;
        font-size: 0.78rem;
        letter-spacing: 0.04em;
        color: var(--admin-primary);
    }
    .td-name {
        font-weight: 600;
    }
    .td-secondary {
        color: var(--admin-secondary);
        font-size: 0.75rem;
    }

    /* Status badges */
    .badge-status {
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
    .badge-status .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .badge-status.aktif       { background: #ecfdf5; color: #059669; }
    .badge-status.aktif .dot  { background: #059669; }
    .badge-status.selesai     { background: #eff6ff; color: #2563eb; }
    .badge-status.selesai .dot{ background: #2563eb; }
    .badge-status.batal       { background: #fef2f2; color: #dc2626; }
    .badge-status.batal .dot  { background: #dc2626; }
    .badge-status.pending     { background: #fffbeb; color: #d97706; }
    .badge-status.pending .dot{ background: #d97706; }

    /* Action buttons */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 0.375rem;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: all 0.15s;
    }
    .action-btn .material-symbols-outlined { font-size: 1.1rem; }
    .action-btn.edit {
        color: var(--admin-primary);
    }
    .action-btn.edit:hover {
        background: #eff6ff;
    }
    .action-btn.delete {
        color: #dc2626;
    }
    .action-btn.delete:hover {
        background: #fef2f2;
    }
    .action-btn.view {
        color: var(--admin-secondary);
    }
    .action-btn.view:hover {
        background: var(--admin-surface-low);
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
    .table-footer__info {
        font-size: 0.75rem;
        color: var(--admin-secondary);
    }
    .pagination-custom {
        display: flex;
        gap: 0.25rem;
    }
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
    .page-btn:hover {
        background: var(--admin-surface-low);
        border-color: var(--admin-primary-fixed-dim);
    }
    .page-btn.active {
        background: var(--admin-primary);
        color: #fff;
        border-color: var(--admin-primary);
    }
    .page-btn .material-symbols-outlined { font-size: 1rem; }

    /* ===== MODAL STYLES ===== */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
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
    .modal-title .material-symbols-outlined {
        font-size: 1.35rem;
        color: var(--admin-primary);
    }
    .modal-body {
        padding: 1.5rem 1.75rem;
    }
    .modal-footer {
        border-top: 1px solid var(--admin-surface-container);
        padding: 1rem 1.75rem 1.25rem;
    }

    /* Form styles inside modal */
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
    .form-label-custom .material-symbols-outlined {
        font-size: 0.95rem;
        color: var(--admin-primary);
    }
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
        box-shadow: 0 0 0 3px rgba(0,87,205,0.08);
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
        box-shadow: 0 4px 12px -2px rgba(0,87,205,0.3);
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

    /* Section divider in form */
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

    /* ===== MODAL CALENDAR ===== */
    .mcal {
        background: var(--admin-surface-low);
        border-radius: 0.75rem;
        padding: 1rem;
        border: 1px solid rgba(194,198,216,0.15);
    }
    .mcal__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }
    .mcal__title {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--admin-on-surface);
    }
    .mcal__nav {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 0.375rem;
        border: 1px solid var(--admin-outline-variant);
        background: transparent;
        cursor: pointer;
        color: var(--admin-on-surface-variant);
        transition: all 0.15s;
    }
    .mcal__nav:hover {
        background: var(--admin-surface-lowest);
        border-color: var(--admin-primary-fixed-dim);
    }
    .mcal__nav .material-symbols-outlined { font-size: 1rem; }
    .mcal__grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.15rem;
        text-align: center;
    }
    .mcal__dow {
        font-size: 0.55rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--admin-secondary);
        padding: 0.3rem 0;
    }
    .mcal__day {
        position: relative;
        width: 100%;
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 500;
        border-radius: 0.375rem;
        border: none;
        background: transparent;
        color: var(--admin-on-surface);
        cursor: pointer;
        transition: all 0.15s;
    }
    .mcal__day:hover:not(.empty):not(.selected) {
        background: var(--admin-surface-highest);
    }
    .mcal__day.today {
        font-weight: 700;
        border: 1.5px solid var(--admin-primary);
    }
    .mcal__day.selected {
        background: var(--admin-primary);
        color: #fff;
        font-weight: 700;
    }
    .mcal__day.empty {
        cursor: default;
    }
    .mcal__day .avail-dot {
        position: absolute;
        bottom: 3px;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #059669;
    }
    .mcal__day.selected .avail-dot {
        background: rgba(255,255,255,0.7);
    }
    .mcal__selected-info {
        margin-top: 0.75rem;
        padding: 0.6rem 0.75rem;
        background: var(--admin-surface-lowest);
        border-radius: 0.5rem;
        border: 1px solid rgba(194,198,216,0.15);
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--admin-on-surface);
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }
    .mcal__selected-info .material-symbols-outlined {
        font-size: 1rem;
        color: var(--admin-primary);
    }

    /* ===== TIME SLOT GRID ===== */
    .tslot-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.4rem;
    }
    .tslot {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.55rem 0.25rem;
        border: 1.5px solid var(--admin-outline-variant);
        border-radius: 0.5rem;
        background: transparent;
        font-family: 'Inter', sans-serif;
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--admin-on-surface-variant);
        cursor: pointer;
        transition: all 0.15s;
    }
    .tslot:hover:not(.disabled) {
        border-color: var(--admin-primary-fixed-dim);
        background: var(--admin-surface-lowest);
    }
    .tslot.selected {
        background: var(--admin-primary);
        color: #fff;
        border-color: var(--admin-primary);
        font-weight: 700;
    }
    .tslot.disabled {
        opacity: 0.35;
        cursor: not-allowed;
        text-decoration: line-through;
    }
    .tslot-label {
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--admin-secondary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .tslot-label .material-symbols-outlined { font-size: 0.9rem; color: var(--admin-primary); }

    @media (max-width: 575.98px) {
        .tslot-grid { grid-template-columns: repeat(3, 1fr); }
    }
</style>

<main class="flex-grow-1 p-3 p-md-5" style="background:var(--admin-surface);">

    <!-- Page Header -->
    <div class="page-header animate-in">
        <div>
            <h2 class="page-header__title">Kelola Booking</h2>
            <p class="page-header__subtitle">Manajemen data booking dan penjadwalan konsultasi</p>
        </div>
        <button class="btn-add-booking" data-bs-toggle="modal" data-bs-target="#addBookingModal">
            <span class="material-symbols-outlined">add_circle</span>
            Tambah Booking
        </button>
    </div>

    <!-- Stats Row -->
    <div class="stats-row animate-in" style="animation-delay:.06s;">
        <div class="stat-chip">
            <div class="stat-chip__icon blue">
                <span class="material-symbols-outlined">event_note</span>
            </div>
            <div>
                <p class="stat-chip__label">Total Booking</p>
                <p class="stat-chip__value">156</p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon green">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="stat-chip__label">Aktif</p>
                <p class="stat-chip__value">42</p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon amber">
                <span class="material-symbols-outlined">pending</span>
            </div>
            <div>
                <p class="stat-chip__label">Pending</p>
                <p class="stat-chip__value">18</p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon red">
                <span class="material-symbols-outlined">cancel</span>
            </div>
            <div>
                <p class="stat-chip__label">Batal</p>
                <p class="stat-chip__value">7</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card animate-in" style="animation-delay:.12s;">
        <!-- Toolbar -->
        <div class="table-toolbar">
            <div class="table-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" placeholder="Cari kode booking, nama..." />
            </div>
            <div class="d-flex gap-2">
                <button class="table-filter-btn">
                    <span class="material-symbols-outlined">filter_list</span>
                    Filter Status
                </button>
                <button class="table-filter-btn">
                    <span class="material-symbols-outlined">download</span>
                    Export
                </button>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Nama Klien</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="td-code">BK-2024-0812</td>
                        <td>
                            <span class="td-name">Ahmad Fauzi</span><br>
                            <span class="td-secondary">ahmad@email.com</span>
                        </td>
                        <td>12 Okt 2024</td>
                        <td>09:00 WIB</td>
                        <td><span class="badge-status aktif"><span class="dot"></span>Aktif</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn view" title="Lihat Detail"><span class="material-symbols-outlined">visibility</span></button>
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editBookingModal"><span class="material-symbols-outlined">edit</span></button>
                            <button class="action-btn delete" title="Hapus"><span class="material-symbols-outlined">delete</span></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-code">BK-2024-0915</td>
                        <td>
                            <span class="td-name">Siti Rahmawati</span><br>
                            <span class="td-secondary">siti.r@email.com</span>
                        </td>
                        <td>15 Okt 2024</td>
                        <td>10:30 WIB</td>
                        <td><span class="badge-status selesai"><span class="dot"></span>Selesai</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn view" title="Lihat Detail"><span class="material-symbols-outlined">visibility</span></button>
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editBookingModal"><span class="material-symbols-outlined">edit</span></button>
                            <button class="action-btn delete" title="Hapus"><span class="material-symbols-outlined">delete</span></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-code">BK-2024-1001</td>
                        <td>
                            <span class="td-name">Budi Santoso</span><br>
                            <span class="td-secondary">budi.s@email.com</span>
                        </td>
                        <td>17 Okt 2024</td>
                        <td>13:00 WIB</td>
                        <td><span class="badge-status aktif"><span class="dot"></span>Aktif</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn view" title="Lihat Detail"><span class="material-symbols-outlined">visibility</span></button>
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editBookingModal"><span class="material-symbols-outlined">edit</span></button>
                            <button class="action-btn delete" title="Hapus"><span class="material-symbols-outlined">delete</span></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-code">BK-2024-1105</td>
                        <td>
                            <span class="td-name">Dewi Lestari</span><br>
                            <span class="td-secondary">dewi.l@email.com</span>
                        </td>
                        <td>18 Okt 2024</td>
                        <td>14:30 WIB</td>
                        <td><span class="badge-status pending"><span class="dot"></span>Pending</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn view" title="Lihat Detail"><span class="material-symbols-outlined">visibility</span></button>
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editBookingModal"><span class="material-symbols-outlined">edit</span></button>
                            <button class="action-btn delete" title="Hapus"><span class="material-symbols-outlined">delete</span></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-code">BK-2024-1210</td>
                        <td>
                            <span class="td-name">Rizky Pratama</span><br>
                            <span class="td-secondary">rizky.p@email.com</span>
                        </td>
                        <td>20 Okt 2024</td>
                        <td>09:00 WIB</td>
                        <td><span class="badge-status batal"><span class="dot"></span>Batal</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn view" title="Lihat Detail"><span class="material-symbols-outlined">visibility</span></button>
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editBookingModal"><span class="material-symbols-outlined">edit</span></button>
                            <button class="action-btn delete" title="Hapus"><span class="material-symbols-outlined">delete</span></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-code">BK-2024-1315</td>
                        <td>
                            <span class="td-name">Maya Anggraini</span><br>
                            <span class="td-secondary">maya.a@email.com</span>
                        </td>
                        <td>22 Okt 2024</td>
                        <td>11:00 WIB</td>
                        <td><span class="badge-status aktif"><span class="dot"></span>Aktif</span></td>
                        <td style="text-align:center;">
                            <button class="action-btn view" title="Lihat Detail"><span class="material-symbols-outlined">visibility</span></button>
                            <button class="action-btn edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editBookingModal"><span class="material-symbols-outlined">edit</span></button>
                            <button class="action-btn delete" title="Hapus"><span class="material-symbols-outlined">delete</span></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer / Pagination -->
        <div class="table-footer">
            <span class="table-footer__info">Menampilkan 1-6 dari 156 data</span>
            <div class="pagination-custom">
                <button class="page-btn"><span class="material-symbols-outlined">chevron_left</span></button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">...</button>
                <button class="page-btn">26</button>
                <button class="page-btn"><span class="material-symbols-outlined">chevron_right</span></button>
            </div>
        </div>
    </div>

</main>

<!-- ===== MODAL: TAMBAH BOOKING ===== -->
<div class="modal fade" id="addBookingModal" tabindex="-1" aria-labelledby="addBookingLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookingLabel">
                    <span class="material-symbols-outlined">add_circle</span>
                    Tambah Booking Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddBooking">
                    <!-- Section: Informasi Klien -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">person</span>
                        Informasi Klien
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">badge</span> Nama Lengkap
                            </label>
                            <input type="text" class="form-control-custom" placeholder="Masukkan nama klien" required />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">mail</span> Email
                            </label>
                            <input type="email" class="form-control-custom" placeholder="email@contoh.com" required />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">call</span> No. Telepon
                            </label>
                            <input type="tel" class="form-control-custom" placeholder="08xxxxxxxxxx" />
                        </div>
                    </div>


                    <!-- Section: Pilih Jadwal -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">calendar_month</span>
                        Pilih Jadwal
                    </div>
                    <div class="row g-3 mb-4">
                        <!-- Calendar -->
                        <div class="col-12 col-md-6">
                            <div class="mcal" id="addCal">
                                <div class="mcal__header">
                                    <button type="button" class="mcal__nav" data-dir="prev">
                                        <span class="material-symbols-outlined">chevron_left</span>
                                    </button>
                                    <span class="mcal__title"></span>
                                    <button type="button" class="mcal__nav" data-dir="next">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </div>
                                <div class="mcal__grid"></div>
                                <div class="mcal__selected-info" style="display:none;">
                                    <span class="material-symbols-outlined">event_available</span>
                                    <span class="mcal__selected-text"></span>
                                </div>
                            </div>
                        </div>
                        <!-- Time Slots -->
                        <div class="col-12 col-md-6">
                            <div class="tslot-label">
                                <span class="material-symbols-outlined">schedule</span>
                                Jam Tersedia
                            </div>
                            <div class="tslot-grid" id="addTimeSlots"></div>

                            <div class="mt-3">
                                <label class="form-label-custom">
                                    <span class="material-symbols-outlined">timer</span> Durasi
                                </label>
                                <select class="form-control-custom">
                                    <option value="1" selected>1 Jam</option>
                                    <option value="2">2 Jam</option>
                                    <option value="3">3 Jam</option>
                                    <option value="4">4 Jam</option>
                                    <option value="5">5 Jam</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <label class="form-label-custom">
                                    <span class="material-symbols-outlined">flag</span> Status
                                </label>
                                <select class="form-control-custom">
                                    <option value="aktif">Aktif</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">notes</span> Catatan
                            </label>
                            <textarea class="form-control-custom" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-modal-save">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Booking
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL: EDIT BOOKING ===== -->
<div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookingLabel">
                    <span class="material-symbols-outlined">edit</span>
                    Edit Booking — <span style="color:var(--admin-primary)">BK-2024-0812</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditBooking">
                    <!-- Section: Informasi Klien -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">person</span>
                        Informasi Klien
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">badge</span> Nama Lengkap
                            </label>
                            <input type="text" class="form-control-custom" value="Ahmad Fauzi" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">mail</span> Email
                            </label>
                            <input type="email" class="form-control-custom" value="ahmad@email.com" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">call</span> No. Telepon
                            </label>
                            <input type="tel" class="form-control-custom" value="081234567890" />
                        </div>
                    </div>


                    <!-- Section: Pilih Jadwal -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">calendar_month</span>
                        Pilih Jadwal
                    </div>
                    <div class="row g-3 mb-4">
                        <!-- Calendar -->
                        <div class="col-12 col-md-6">
                            <div class="mcal" id="editCal">
                                <div class="mcal__header">
                                    <button type="button" class="mcal__nav" data-dir="prev">
                                        <span class="material-symbols-outlined">chevron_left</span>
                                    </button>
                                    <span class="mcal__title"></span>
                                    <button type="button" class="mcal__nav" data-dir="next">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </button>
                                </div>
                                <div class="mcal__grid"></div>
                                <div class="mcal__selected-info" style="display:none;">
                                    <span class="material-symbols-outlined">event_available</span>
                                    <span class="mcal__selected-text"></span>
                                </div>
                            </div>
                        </div>
                        <!-- Time Slots -->
                        <div class="col-12 col-md-6">
                            <div class="tslot-label">
                                <span class="material-symbols-outlined">schedule</span>
                                Jam Tersedia
                            </div>
                            <div class="tslot-grid" id="editTimeSlots"></div>

                            <div class="mt-3">
                                <label class="form-label-custom">
                                    <span class="material-symbols-outlined">timer</span> Durasi
                                </label>
                                <select class="form-control-custom">
                                    <option value="1" selected>1 Jam</option>
                                    <option value="2">2 Jam</option>
                                    <option value="3">3 Jam</option>
                                    <option value="4">4 Jam</option>
                                    <option value="5">5 Jam</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <label class="form-label-custom">
                                    <span class="material-symbols-outlined">flag</span> Status
                                </label>
                                <select class="form-control-custom">
                                    <option value="aktif" selected>Aktif</option>
                                    <option value="pending">Pending</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="batal">Batal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">notes</span> Catatan
                            </label>
                            <textarea class="form-control-custom" rows="3">Klien meminta jadwal pagi, preferensi hari kerja.</textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-modal-save">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const MONTHS = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const DAYS  = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];

    const ALL_SLOTS = [
        '08:00','08:30','09:00','09:30','10:00','10:30',
        '11:00','11:30','13:00','13:30','14:00','14:30',
        '15:00','15:30','16:00'
    ];

    // Simulated availability per date key "YYYY-M-D"
    const BOOKED = {
        '2024-9-12': ['09:00','10:00'],
        '2024-9-15': ['08:00','13:00','14:00'],
        '2024-9-17': ['09:00','09:30','10:00','10:30'],
    };

    function daysWithAvailability(year, month) {
        // Simulate: most days in current/future months have availability
        const set = new Set();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        for (let d = 1; d <= daysInMonth; d++) {
            const dow = new Date(year, month, d).getDay();
            if (dow !== 0) set.add(d); // everything except Sunday
        }
        return set;
    }

    function getAvailableSlots(year, month, day) {
        const key = `${year}-${month}-${day}`;
        const booked = BOOKED[key] || [];
        return ALL_SLOTS.map(s => ({
            time: s,
            available: !booked.includes(s)
        }));
    }

    class ModalCalendar {
        constructor(calId, slotsId, opts = {}) {
            this.root = document.getElementById(calId);
            this.slotsRoot = document.getElementById(slotsId);
            if (!this.root || !this.slotsRoot) return;

            const now = new Date();
            this.year = opts.year ?? now.getFullYear();
            this.month = opts.month ?? now.getMonth();
            this.selectedDay = opts.day ?? null;
            this.selectedTime = opts.time ?? null;

            this.titleEl = this.root.querySelector('.mcal__title');
            this.gridEl = this.root.querySelector('.mcal__grid');
            this.infoEl = this.root.querySelector('.mcal__selected-info');
            this.infoText = this.root.querySelector('.mcal__selected-text');

            this.root.querySelectorAll('.mcal__nav').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (btn.dataset.dir === 'prev') {
                        this.month--;
                        if (this.month < 0) { this.month = 11; this.year--; }
                    } else {
                        this.month++;
                        if (this.month > 11) { this.month = 0; this.year++; }
                    }
                    this.selectedDay = null;
                    this.render();
                    this.renderSlots();
                });
            });

            this.render();
            this.renderSlots();
        }

        render() {
            this.titleEl.textContent = `${MONTHS[this.month]} ${this.year}`;
            const available = daysWithAvailability(this.year, this.month);
            const firstDow = new Date(this.year, this.month, 1).getDay();
            const totalDays = new Date(this.year, this.month + 1, 0).getDate();
            const today = new Date();

            let html = DAYS.map(d => `<span class="mcal__dow">${d}</span>`).join('');
            for (let i = 0; i < firstDow; i++) html += '<span class="mcal__day empty"></span>';

            for (let d = 1; d <= totalDays; d++) {
                const isToday = d === today.getDate() && this.month === today.getMonth() && this.year === today.getFullYear();
                const isSel = d === this.selectedDay;
                const hasAvail = available.has(d);
                let cls = 'mcal__day';
                if (isToday) cls += ' today';
                if (isSel) cls += ' selected';

                html += `<button type="button" class="${cls}" data-day="${d}">`;
                html += d;
                if (hasAvail) html += '<span class="avail-dot"></span>';
                html += '</button>';
            }

            this.gridEl.innerHTML = html;

            this.gridEl.querySelectorAll('.mcal__day:not(.empty)').forEach(btn => {
                btn.addEventListener('click', () => {
                    this.selectedDay = parseInt(btn.dataset.day);
                    this.render();
                    this.renderSlots();
                });
            });

            if (this.selectedDay) {
                const d = new Date(this.year, this.month, this.selectedDay);
                const dayName = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][d.getDay()];
                this.infoText.textContent = `${dayName}, ${this.selectedDay} ${MONTHS[this.month]} ${this.year}`;
                this.infoEl.style.display = 'flex';
            } else {
                this.infoEl.style.display = 'none';
            }
        }

        renderSlots() {
            if (!this.selectedDay) {
                this.slotsRoot.innerHTML = '<div style="padding:2rem 1rem;text-align:center;color:var(--admin-secondary);font-size:0.78rem;"><span class="material-symbols-outlined d-block mb-2" style="font-size:2rem;opacity:.4;">touch_app</span>Pilih tanggal terlebih dahulu</div>';
                return;
            }
            const slots = getAvailableSlots(this.year, this.month, this.selectedDay);
            let html = '';
            slots.forEach(s => {
                const isSel = s.time === this.selectedTime && s.available;
                let cls = 'tslot';
                if (!s.available) cls += ' disabled';
                if (isSel) cls += ' selected';
                html += `<button type="button" class="${cls}" data-time="${s.time}" ${!s.available ? 'disabled' : ''}>${s.time}</button>`;
            });
            this.slotsRoot.innerHTML = html;

            this.slotsRoot.querySelectorAll('.tslot:not(.disabled)').forEach(btn => {
                btn.addEventListener('click', () => {
                    this.selectedTime = btn.dataset.time;
                    this.renderSlots();
                });
            });
        }
    }

    // Initialize Add calendar when modal opens
    const addModal = document.getElementById('addBookingModal');
    let addCalInstance = null;
    addModal.addEventListener('shown.bs.modal', () => {
        if (!addCalInstance) {
            addCalInstance = new ModalCalendar('addCal', 'addTimeSlots');
        }
    });

    // Initialize Edit calendar when modal opens (pre-selected: Oct 12 2024, 09:00)
    const editModal = document.getElementById('editBookingModal');
    let editCalInstance = null;
    editModal.addEventListener('shown.bs.modal', () => {
        if (!editCalInstance) {
            editCalInstance = new ModalCalendar('editCal', 'editTimeSlots', {
                year: 2024, month: 9, day: 12, time: '09:00'
            });
        }
    });
})();
</script>

<?= $this->endSection() ?>
