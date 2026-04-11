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

    .btn-add-booking:active {
        transform: scale(0.97);
    }

    .btn-add-booking .material-symbols-outlined {
        font-size: 1.1rem;
    }

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

    .stat-chip__icon .material-symbols-outlined {
        font-size: 1.15rem;
    }

    .stat-chip__icon.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-chip__icon.green {
        background: #ecfdf5;
        color: #059669;
    }

    .stat-chip__icon.amber {
        background: #fffbeb;
        color: #d97706;
    }

    .stat-chip__icon.red {
        background: #fef2f2;
        color: #dc2626;
    }

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

    .table-search input::placeholder {
        color: var(--admin-outline);
    }

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

    .table-filter-btn .material-symbols-outlined {
        font-size: 1rem;
    }

    /* Table */
    .booking-table {
        width: 100%;
        min-width: 1400px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .booking-table thead th {
        background: var(--admin-surface-low);
        font-family: 'Inter', sans-serif;
        font-size: 0.62rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--admin-secondary);
        padding: 0.75rem 0.75rem;
        border-bottom: 1px solid var(--admin-surface-container);
        white-space: nowrap;
    }

    .booking-table tbody td {
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem;
        padding: 0.75rem;
        border-bottom: 1px solid var(--admin-surface-container);
        vertical-align: middle;
        color: var(--admin-on-surface);
        white-space: nowrap;
    }

    .booking-table tbody tr {
        transition: background 0.15s;
    }

    .booking-table tbody tr:hover {
        background: rgba(0, 87, 205, 0.02);
    }

    .booking-table tbody tr:last-child td {
        border-bottom: none;
    }

    .td-code {
        font-weight: 700;
        font-size: 0.74rem;
        letter-spacing: 0.03em;
        color: var(--admin-primary);
        white-space: nowrap;
    }

    .td-name {
        font-weight: 600;
    }

    .td-secondary {
        color: var(--admin-secondary);
        font-size: 0.72rem;
    }

    .td-currency {
        font-weight: 700;
        font-size: 0.78rem;
        white-space: nowrap;
    }

    .td-currency.green {
        color: #059669;
    }

    /* Method badge */
    .badge-method {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.62rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 0.22rem 0.6rem;
        border-radius: 9999px;
    }

    .badge-method.transfer {
        background: #eff6ff;
        color: #2563eb;
    }

    .badge-method.cash {
        background: #ecfdf5;
        color: #059669;
    }

    .badge-method.ewallet {
        background: #faf5ff;
        color: #7c3aed;
    }

    .badge-method.qris {
        background: #fff7ed;
        color: #ea580c;
    }

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

    .action-btn .material-symbols-outlined {
        font-size: 0.95rem;
    }

    .action-btn.bukti {
        color: #7c3aed;
        border-color: #e9d5ff;
        background: #faf5ff;
    }

    .action-btn.bukti:hover {
        background: #ede9fe;
        border-color: #c4b5fd;
    }

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

    .page-btn .material-symbols-outlined {
        font-size: 1rem;
    }

    /* ===== MODAL STYLES ===== */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        border-bottom: 1px solid var(--admin-surface-container);
        padding: 1.25rem 1.5rem 1rem;
    }

    .modal-title {
        font-family: 'Inter', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--admin-on-surface);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modal-title .material-symbols-outlined {
        font-size: 1.25rem;
        color: var(--admin-primary);
    }

    .modal-body {
        padding: 0;
    }

    .modal-footer {
        border-top: 1px solid var(--admin-surface-container);
        padding: 1rem 1.5rem 1.15rem;
    }

    /* Form styles */
    .form-label-custom {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--admin-on-surface-variant);
        margin-bottom: 0.35rem;
    }

    .form-label-custom .material-symbols-outlined {
        font-size: 0.9rem;
        color: var(--admin-primary);
    }

    .form-control-custom {
        width: 100%;
        padding: 0.55rem 0.8rem;
        border: 1.5px solid var(--admin-outline-variant);
        border-radius: 0.5rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        color: var(--admin-on-surface);
        background: var(--admin-surface-lowest);
        outline: none;
        transition: all 0.2s;
    }

    .form-control-custom:focus {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(0, 87, 205, 0.08);
    }

    .form-control-custom::placeholder {
        color: var(--admin-outline);
    }

    select.form-control-custom {
        cursor: pointer;
    }

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

    .btn-modal-save:hover {
        transform: translateY(-1px);
        color: #fff;
    }

    .btn-modal-save .material-symbols-outlined {
        font-size: 1rem;
    }

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

    .btn-modal-cancel:hover {
        background: var(--admin-surface-low);
    }

    .form-section-title {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--admin-primary);
        margin-bottom: 0.85rem;
        padding-bottom: 0.45rem;
        border-bottom: 2px solid var(--admin-primary-fixed);
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .form-section-title .material-symbols-outlined {
        font-size: 0.95rem;
    }

    /* Price input wrapper */
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

    .price-input-wrap input {
        padding-left: 2.5rem;
    }

    /* Upload zone */
    .upload-zone {
        border: 2px dashed var(--admin-outline-variant);
        border-radius: 0.75rem;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        cursor: pointer;
        transition: all 0.2s;
        min-height: 7rem;
        background: var(--admin-surface-low);
        position: relative;
    }

    .upload-zone:hover {
        border-color: var(--admin-primary-fixed-dim);
        background: rgba(0, 87, 205, 0.03);
    }

    .upload-zone .material-symbols-outlined {
        font-size: 1.75rem;
        color: var(--admin-primary-fixed-dim);
    }

    .upload-zone p {
        font-size: 0.7rem;
        color: var(--admin-secondary);
        margin-bottom: 0;
    }

    .upload-zone span.hint {
        font-size: 0.58rem;
        color: var(--admin-outline);
    }

    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .upload-zone.has-file {
        border-color: #059669;
        background: #ecfdf5;
    }

    .upload-zone.has-file .material-symbols-outlined {
        color: #059669;
    }

    /* Lightbox modal for bukti bayar */
    .bukti-lightbox {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .bukti-lightbox img {
        max-width: 100%;
        max-height: 70vh;
        border-radius: 0.75rem;
        box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.2);
    }

    .bukti-lightbox .no-bukti {
        text-align: center;
        color: var(--admin-secondary);
    }

    .bukti-lightbox .no-bukti .material-symbols-outlined {
        font-size: 3rem;
        color: var(--admin-outline);
        display: block;
        margin-bottom: 0.75rem;
    }

    /* ===== TWO-PANEL MODAL LAYOUT ===== */
    .add-booking-layout {
        display: flex;
        min-height: 70vh;
    }

    .add-booking-left {
        flex: 0 0 45%;
        max-width: 45%;
        background: var(--admin-surface-low);
        border-right: 1px solid var(--admin-surface-container);
        padding: 1.5rem;
        overflow-y: auto;
        max-height: 75vh;
    }

    .add-booking-right {
        flex: 1;
        padding: 1.5rem;
        overflow-y: auto;
        max-height: 75vh;
    }

    @media (max-width: 991.98px) {
        .add-booking-layout {
            flex-direction: column;
        }

        .add-booking-left {
            flex: none;
            max-width: 100%;
            border-right: none;
            border-bottom: 1px solid var(--admin-surface-container);
            max-height: 45vh;
        }

        .add-booking-right {
            max-height: 45vh;
        }
    }

    /* ===== ADMIN CALENDAR (in modal) ===== */
    .adm-cal {
        background: var(--admin-surface-lowest);
        border-radius: 0.75rem;
        padding: 1rem;
        border: 1px solid rgba(194, 198, 216, 0.12);
        margin-bottom: 1.25rem;
    }

    .adm-cal__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.85rem;
    }

    .adm-cal__title {
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--admin-on-surface);
    }

    .adm-cal__nav {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.85rem;
        height: 1.85rem;
        border-radius: 0.4rem;
        border: 1.5px solid var(--admin-outline-variant);
        background: transparent;
        cursor: pointer;
        color: var(--admin-on-surface-variant);
        transition: all 0.15s;
    }

    .adm-cal__nav:hover {
        background: var(--admin-surface-low);
        border-color: var(--admin-primary);
        color: var(--admin-primary);
    }

    .adm-cal__nav .material-symbols-outlined {
        font-size: 1rem;
    }

    .adm-cal__grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.1rem;
        text-align: center;
    }

    .adm-cal__dow {
        font-size: 0.58rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--admin-secondary);
        padding: 0.3rem 0;
    }

    .adm-cal__day {
        position: relative;
        width: 100%;
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 500;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--admin-on-surface);
        cursor: pointer;
        transition: all 0.15s;
    }

    .adm-cal__day:hover:not(.empty):not(.selected) {
        background: var(--admin-surface-container);
    }

    .adm-cal__day.today {
        font-weight: 700;
        border: 2px solid var(--admin-primary);
        color: var(--admin-primary);
    }

    .adm-cal__day.selected {
        background: var(--admin-primary);
        color: #fff;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(0, 87, 205, 0.25);
    }

    .adm-cal__day.empty {
        cursor: default;
    }

    .adm-cal__selected-info {
        margin-top: 0.75rem;
        padding: 0.55rem 0.7rem;
        background: var(--admin-surface-low);
        border-radius: 0.5rem;
        border: 1px solid rgba(194, 198, 216, 0.12);
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--admin-on-surface);
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .adm-cal__selected-info .material-symbols-outlined {
        font-size: 1rem;
        color: var(--admin-primary);
    }

    /* ===== ADMIN LAPANG CARDS (in modal) ===== */
    .adm-lapang-card {
        background: var(--admin-surface-lowest);
        border: 1.5px solid var(--admin-outline-variant);
        border-radius: 0.75rem;
        overflow: hidden;
        margin-bottom: 0.85rem;
        transition: all 0.2s;
    }

    .adm-lapang-card:hover {
        border-color: var(--admin-primary-fixed-dim);
    }

    .adm-lapang-card.active {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(0, 87, 205, 0.08);
    }

    .adm-lapang-card__header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 0.85rem;
        background: linear-gradient(135deg, #0057cd 0%, #0d6efd 100%);
        color: #fff;
        cursor: pointer;
    }

    .adm-lapang-card__header .material-symbols-outlined {
        font-size: 1.1rem;
        opacity: 0.85;
    }

    .adm-lapang-card__header span:last-child {
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .adm-lapang-card__body {
        padding: 0.75rem;
    }

    /* Timeslot grid in admin modal */
    .adm-slot-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.35rem;
    }

    .adm-slot {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        padding: 0.45rem 0.25rem;
        border: 1.5px solid var(--admin-outline-variant);
        border-radius: 0.4rem;
        background: transparent;
        font-family: 'Inter', sans-serif;
        font-size: 0.68rem;
        font-weight: 600;
        color: var(--admin-on-surface-variant);
        cursor: pointer;
        transition: all 0.15s;
        user-select: none;
    }

    .adm-slot:hover:not(.disabled) {
        border-color: var(--admin-primary-fixed-dim);
        background: var(--admin-surface-low);
    }

    .adm-slot.selected {
        background: var(--admin-primary);
        color: #fff;
        border-color: var(--admin-primary);
        font-weight: 700;
    }

    .adm-slot.disabled {
        opacity: 0.3;
        cursor: not-allowed;
        text-decoration: line-through;
    }

    .adm-slot .material-symbols-outlined {
        font-size: 0.75rem;
    }

    @media (max-width: 575.98px) {
        .adm-slot-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Summary chip in right panel */
    .booking-summary-chip {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 0.85rem;
        background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
        border: 1.5px solid #bfdbfe;
        border-radius: 0.625rem;
        margin-bottom: 1.25rem;
    }

    .booking-summary-chip .material-symbols-outlined {
        font-size: 1.1rem;
        color: var(--admin-primary);
    }

    .booking-summary-chip__text {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--admin-on-surface);
        line-height: 1.4;
    }

    .booking-summary-chip__text small {
        font-weight: 400;
        color: var(--admin-secondary);
        display: block;
        font-size: 0.65rem;
    }

    /* No-selection placeholder */
    .no-selection-placeholder {
        text-align: center;
        padding: 2rem 1rem;
        color: var(--admin-secondary);
    }

    .no-selection-placeholder .material-symbols-outlined {
        font-size: 2.5rem;
        opacity: 0.3;
        display: block;
        margin-bottom: 0.5rem;
    }

    .no-selection-placeholder p {
        font-size: 0.78rem;
        margin-bottom: 0;
    }
</style>

<main class="flex-grow-1 p-3 p-md-5" style="background:var(--admin-surface);">

    <!-- Page Header -->
    <div class="page-header animate-in">
        <div>
            <h2 class="page-header__title">Kelola Booking</h2>
            <p class="page-header__subtitle">Manajemen data booking lapangan dan penjadwalan</p>
        </div>
        <button class="btn-add-booking" data-bs-toggle="modal" data-bs-target="#addBookingModal">
            <span class="material-symbols-outlined">add_circle</span>
            Tambah Booking
        </button>
    </div>

    <!-- Stats Row -->
    <div class="stats-row animate-in" style="animation-delay:.06s;">
        <div class="stat-chip">
            <div class="stat-chip__icon blue"><span class="material-symbols-outlined">event_note</span></div>
            <div>
                <p class="stat-chip__label">Total Booking</p>
                <p class="stat-chip__value">156</p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon green"><span class="material-symbols-outlined">check_circle</span></div>
            <div>
                <p class="stat-chip__label">Lunas</p>
                <p class="stat-chip__value">120</p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon amber"><span class="material-symbols-outlined">pending</span></div>
            <div>
                <p class="stat-chip__label">Pending</p>
                <p class="stat-chip__value">29</p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon red"><span class="material-symbols-outlined">cancel</span></div>
            <div>
                <p class="stat-chip__label">Batal</p>
                <p class="stat-chip__value">7</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card animate-in" style="animation-delay:.12s;">
        <div class="table-toolbar">
            <div class="table-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" placeholder="Cari kode booking, nama penyewa..." />
            </div>
            <div class="d-flex gap-2">
                <button class="table-filter-btn"><span class="material-symbols-outlined">filter_list</span>
                    Filter</button>
                <button class="table-filter-btn"><span class="material-symbols-outlined">download</span> Export</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Nama Lapang</th>
                        <th>Nama Penyewa</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Tanggal</th>
                        <th>Jam Bermain</th>
                        <th>Durasi</th>
                        <th>Total Harga</th>
                        <th>Uang Masuk</th>
                        <th>Metode</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="td-code">BK-20260411-001</td>
                        <td><span class="td-name">Lapang Futsal A</span></td>
                        <td>Ahmad Fauzi</td>
                        <td class="td-secondary">ahmad@email.com</td>
                        <td>081234567890</td>
                        <td>11 Apr 2026</td>
                        <td>09:00</td>
                        <td>2 Jam</td>
                        <td class="td-currency">Rp 300.000</td>
                        <td class="td-currency green">Rp 300.000</td>
                        <td><span class="badge-method transfer">Transfer</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="action-btn bukti" title="Lihat Bukti Bayar" data-bs-toggle="modal"
                                    data-bs-target="#buktiBayarModal" data-bukti="bukti_ahmad.jpg"><span
                                        class="material-symbols-outlined">receipt_long</span> Bukti</button>
                                <button class="action-btn edit" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editBookingModal"><span
                                        class="material-symbols-outlined">edit</span> Edit</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-code">BK-20260411-002</td>
                        <td><span class="td-name">Lapang Badminton B</span></td>
                        <td>Siti Rahmawati</td>
                        <td class="td-secondary">siti.r@email.com</td>
                        <td>085678901234</td>
                        <td>11 Apr 2026</td>
                        <td>10:00</td>
                        <td>1 Jam</td>
                        <td class="td-currency">Rp 100.000</td>
                        <td class="td-currency green">Rp 100.000</td>
                        <td><span class="badge-method cash">Cash</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="action-btn bukti" title="Lihat Bukti Bayar" data-bs-toggle="modal"
                                    data-bs-target="#buktiBayarModal" data-bukti=""><span
                                        class="material-symbols-outlined">receipt_long</span> Bukti</button>
                                <button class="action-btn edit" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editBookingModal"><span
                                        class="material-symbols-outlined">edit</span> Edit</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-code">BK-20260410-003</td>
                        <td><span class="td-name">Lapang Futsal A</span></td>
                        <td>Budi Santoso</td>
                        <td class="td-secondary">budi.s@email.com</td>
                        <td>087812345678</td>
                        <td>10 Apr 2026</td>
                        <td>13:00</td>
                        <td>3 Jam</td>
                        <td class="td-currency">Rp 450.000</td>
                        <td class="td-currency green">Rp 450.000</td>
                        <td><span class="badge-method ewallet">E-Wallet</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="action-btn bukti" title="Lihat Bukti Bayar" data-bs-toggle="modal"
                                    data-bs-target="#buktiBayarModal" data-bukti="bukti_budi.jpg"><span
                                        class="material-symbols-outlined">receipt_long</span> Bukti</button>
                                <button class="action-btn edit" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editBookingModal"><span
                                        class="material-symbols-outlined">edit</span> Edit</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-code">BK-20260410-004</td>
                        <td><span class="td-name">Lapang Basket C</span></td>
                        <td>Dewi Lestari</td>
                        <td class="td-secondary">dewi.l@email.com</td>
                        <td>081298765432</td>
                        <td>10 Apr 2026</td>
                        <td>15:00</td>
                        <td>2 Jam</td>
                        <td class="td-currency">Rp 400.000</td>
                        <td class="td-currency green">Rp 200.000</td>
                        <td><span class="badge-method qris">QRIS</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="action-btn bukti" title="Lihat Bukti Bayar" data-bs-toggle="modal"
                                    data-bs-target="#buktiBayarModal" data-bukti="bukti_dewi.jpg"><span
                                        class="material-symbols-outlined">receipt_long</span> Bukti</button>
                                <button class="action-btn edit" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editBookingModal"><span
                                        class="material-symbols-outlined">edit</span> Edit</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-code">BK-20260409-005</td>
                        <td><span class="td-name">Lapang Badminton B</span></td>
                        <td>Rizky Pratama</td>
                        <td class="td-secondary">rizky.p@email.com</td>
                        <td>082345678901</td>
                        <td>09 Apr 2026</td>
                        <td>08:00</td>
                        <td>1 Jam</td>
                        <td class="td-currency">Rp 100.000</td>
                        <td class="td-currency green">Rp 100.000</td>
                        <td><span class="badge-method transfer">Transfer</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="action-btn bukti" title="Lihat Bukti Bayar" data-bs-toggle="modal"
                                    data-bs-target="#buktiBayarModal" data-bukti="bukti_rizky.jpg"><span
                                        class="material-symbols-outlined">receipt_long</span> Bukti</button>
                                <button class="action-btn edit" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editBookingModal"><span
                                        class="material-symbols-outlined">edit</span> Edit</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-code">BK-20260409-006</td>
                        <td><span class="td-name">Lapang Futsal A</span></td>
                        <td>Maya Anggraini</td>
                        <td class="td-secondary">maya.a@email.com</td>
                        <td>089876543210</td>
                        <td>09 Apr 2026</td>
                        <td>16:00</td>
                        <td>2 Jam</td>
                        <td class="td-currency">Rp 300.000</td>
                        <td class="td-currency green">Rp 300.000</td>
                        <td><span class="badge-method cash">Cash</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="action-btn bukti" title="Lihat Bukti Bayar" data-bs-toggle="modal"
                                    data-bs-target="#buktiBayarModal" data-bukti=""><span
                                        class="material-symbols-outlined">receipt_long</span> Bukti</button>
                                <button class="action-btn edit" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editBookingModal"><span
                                        class="material-symbols-outlined">edit</span> Edit</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

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

<!-- ===== MODAL: TAMBAH BOOKING (Two-Panel) ===== -->
<div class="modal fade" id="addBookingModal" tabindex="-1" aria-labelledby="addBookingLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookingLabel">
                    <span class="material-symbols-outlined">add_circle</span>
                    Tambah Booking Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="add-booking-layout">
                    <!-- ===== LEFT PANEL: Calendar + Lapang Schedule ===== -->
                    <div class="add-booking-left">
                        <div class="form-section-title" style="margin-top:0;">
                            <span class="material-symbols-outlined">calendar_month</span>
                            Pilih Tanggal
                        </div>

                        <!-- Calendar -->
                        <div class="adm-cal" id="addCal">
                            <div class="adm-cal__header">
                                <button type="button" class="adm-cal__nav" data-dir="prev">
                                    <span class="material-symbols-outlined">chevron_left</span>
                                </button>
                                <span class="adm-cal__title"></span>
                                <button type="button" class="adm-cal__nav" data-dir="next">
                                    <span class="material-symbols-outlined">chevron_right</span>
                                </button>
                            </div>
                            <div class="adm-cal__grid"></div>
                            <div class="adm-cal__selected-info" style="display:none;">
                                <span class="material-symbols-outlined">event_available</span>
                                <span class="adm-cal__selected-text"></span>
                            </div>
                        </div>

                        <!-- Lapang Cards with Timeslots -->
                        <div class="form-section-title">
                            <span class="material-symbols-outlined">stadium</span>
                            Pilih Lapang & Jam
                        </div>
                        <div id="addLapangCards">
                            <!-- Rendered by JS after date selection -->
                            <div class="no-selection-placeholder">
                                <span class="material-symbols-outlined">touch_app</span>
                                <p>Pilih tanggal di kalender untuk melihat jadwal tersedia</p>
                            </div>
                        </div>
                    </div>

                    <!-- ===== RIGHT PANEL: Form Inputs ===== -->
                    <div class="add-booking-right">
                        <!-- Dynamic summary -->
                        <div class="booking-summary-chip" id="addBookingSummary" style="display:none;">
                            <span class="material-symbols-outlined">event_available</span>
                            <div class="booking-summary-chip__text">
                                <span id="summaryLapang">-</span> — <span id="summaryTanggal">-</span> — <span
                                    id="summaryJam">-</span>
                                <small>Pilihan jadwal Anda</small>
                            </div>
                        </div>

                        <form id="formAddBooking">
                            <!-- Informasi Penyewa -->
                            <div class="form-section-title">
                                <span class="material-symbols-outlined">person</span>
                                Informasi Penyewa
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">badge</span> Nama Penyewa
                                    </label>
                                    <input type="text" class="form-control-custom" placeholder="Masukkan nama penyewa"
                                        required />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">mail</span> Email
                                    </label>
                                    <input type="email" class="form-control-custom" placeholder="email@contoh.com"
                                        required />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">call</span> No. HP
                                    </label>
                                    <input type="tel" class="form-control-custom" placeholder="08xxxxxxxxxx" required />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">timer</span> Durasi Bermain
                                    </label>
                                    <select class="form-control-custom" id="addDurasi" required>
                                        <option value="1" selected>1 Jam</option>
                                        <option value="2">2 Jam</option>
                                        <option value="3">3 Jam</option>
                                        <option value="4">4 Jam</option>
                                        <option value="5">5 Jam</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Pembayaran -->
                            <div class="form-section-title">
                                <span class="material-symbols-outlined">payments</span>
                                Pembayaran
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">sell</span> Total Harga
                                    </label>
                                    <div class="price-input-wrap">
                                        <span class="prefix">Rp</span>
                                        <input type="number" class="form-control-custom" placeholder="0" required />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">account_balance_wallet</span> Uang Masuk
                                    </label>
                                    <div class="price-input-wrap">
                                        <span class="prefix">Rp</span>
                                        <input type="number" class="form-control-custom" placeholder="0" required />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">credit_card</span> Metode Bayar
                                    </label>
                                    <select class="form-control-custom" required>
                                        <option value="" disabled selected>Pilih metode...</option>
                                        <option value="transfer">Transfer Bank</option>
                                        <option value="cash">Cash</option>
                                        <option value="ewallet">E-Wallet</option>
                                        <option value="qris">QRIS</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Upload Bukti Bayar -->
                            <div class="form-section-title">
                                <span class="material-symbols-outlined">cloud_upload</span>
                                Upload Bukti Bayar
                            </div>
                            <div class="upload-zone" id="addUploadZone">
                                <input type="file" accept="image/*" id="addBuktiBayarInput" />
                                <span class="material-symbols-outlined">cloud_upload</span>
                                <p>Klik atau seret file ke sini</p>
                                <span class="hint">Format: JPG, PNG, JPEG — Maks 2MB</span>
                            </div>
                            <div id="addUploadPreview" style="display:none; margin-top:0.65rem; text-align:center;">
                                <img id="addPreviewImg" src="" alt="Preview"
                                    style="max-height:140px; border-radius:0.5rem; border:2px solid var(--admin-primary-fixed); box-shadow:0 4px 12px -2px rgba(0,0,0,0.1);" />
                                <div style="margin-top:0.4rem;">
                                    <button type="button" class="action-btn edit" id="addRemoveFile"
                                        style="font-size:0.68rem; border-color:#fecaca; color:#dc2626; background:#fef2f2;">
                                        <span class="material-symbols-outlined">delete</span> Hapus
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookingLabel">
                    <span class="material-symbols-outlined">edit</span>
                    Edit Booking — <span style="color:var(--admin-primary)">BK-20260411-001</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:1.5rem 1.75rem;">
                <form id="formEditBooking">
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">confirmation_number</span>
                        Informasi Booking
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom"><span class="material-symbols-outlined">tag</span> Kode
                                Booking</label>
                            <input type="text" class="form-control-custom" value="BK-20260411-001" readonly
                                style="background:var(--admin-surface-low);cursor:not-allowed;" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom"><span class="material-symbols-outlined">stadium</span> Nama
                                Lapang</label>
                            <select class="form-control-custom" required>
                                <option value="Lapang Futsal A" selected>Lapang Futsal A</option>
                                <option value="Lapang Badminton B">Lapang Badminton B</option>
                                <option value="Lapang Basket C">Lapang Basket C</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-section-title">
                        <span class="material-symbols-outlined">person</span>
                        Informasi Penyewa
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom"><span class="material-symbols-outlined">badge</span> Nama
                                Penyewa</label>
                            <input type="text" class="form-control-custom" value="Ahmad Fauzi" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom"><span class="material-symbols-outlined">mail</span>
                                Email</label>
                            <input type="email" class="form-control-custom" value="ahmad@email.com" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom"><span class="material-symbols-outlined">call</span> No.
                                HP</label>
                            <input type="tel" class="form-control-custom" value="081234567890" />
                        </div>
                    </div>

                    <div class="form-section-title">
                        <span class="material-symbols-outlined">calendar_month</span>
                        Jadwal & Durasi
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom"><span class="material-symbols-outlined">event</span>
                                Tanggal</label>
                            <input type="date" class="form-control-custom" value="2026-04-11" />
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom"><span class="material-symbols-outlined">schedule</span> Jam
                                Bermain</label>
                            <input type="time" class="form-control-custom" value="09:00" />
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom"><span class="material-symbols-outlined">timer</span>
                                Durasi</label>
                            <select class="form-control-custom">
                                <option value="1">1 Jam</option>
                                <option value="2" selected>2 Jam</option>
                                <option value="3">3 Jam</option>
                                <option value="4">4 Jam</option>
                                <option value="5">5 Jam</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-section-title">
                        <span class="material-symbols-outlined">payments</span>
                        Pembayaran
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom"><span class="material-symbols-outlined">sell</span> Total
                                Harga</label>
                            <div class="price-input-wrap">
                                <span class="prefix">Rp</span>
                                <input type="number" class="form-control-custom" value="300000" />
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom"><span
                                    class="material-symbols-outlined">account_balance_wallet</span> Uang Masuk</label>
                            <div class="price-input-wrap">
                                <span class="prefix">Rp</span>
                                <input type="number" class="form-control-custom" value="300000" />
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom"><span class="material-symbols-outlined">credit_card</span>
                                Metode Bayar</label>
                            <select class="form-control-custom">
                                <option value="transfer" selected>Transfer Bank</option>
                                <option value="cash">Cash</option>
                                <option value="ewallet">E-Wallet</option>
                                <option value="qris">QRIS</option>
                            </select>
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

<!-- ===== MODAL: LIHAT BUKTI BAYAR ===== -->
<div class="modal fade" id="buktiBayarModal" tabindex="-1" aria-labelledby="buktiBayarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buktiBayarLabel">
                    <span class="material-symbols-outlined">receipt_long</span>
                    Bukti Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bukti-lightbox" id="buktiContainer">
                    <div class="no-bukti">
                        <span class="material-symbols-outlined">image_not_supported</span>
                        <p style="font-size:0.85rem;">Belum ada bukti pembayaran</p>
                        <p style="font-size:0.72rem; color:var(--admin-outline);">Pembayaran cash atau belum upload</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        /* ===== CONSTANTS ===== */
        const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const DAYS = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        const DAY_NAMES = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        const TIME_SLOTS = [];
        for (let h = 8; h < 24; h++) {
            const start = String(h).padStart(2, '0') + ':00';
            const end = String(h + 1).padStart(2, '0') + ':00';
            TIME_SLOTS.push({ start, end, label: `${start} - ${end}` });
        }

        const LAPANGS = [
            { id: 1, name: 'Lapang Futsal A', price: 150000 },
            { id: 2, name: 'Lapang Badminton B', price: 100000 },
            { id: 3, name: 'Lapang Basket C', price: 200000 }
        ];

        // Simulated booked slots (key: "YYYY-M-D-lapangId")
        const BOOKED = {
            '2026-4-11-1': ['09:00 - 10:00', '10:00 - 11:00'],
            '2026-4-11-2': ['08:00 - 09:00', '13:00 - 14:00', '14:00 - 15:00'],
            '2026-4-12-1': ['09:00 - 10:00', '09:00 - 10:00'],
        };

        /* ===== STATE ===== */
        let calYear, calMonth, calSelectedDay;
        let selectedLapangId = null;
        let selectedTimeSlot = null;

        /* ===== CALENDAR ===== */
        const calRoot = document.getElementById('addCal');
        const calTitle = calRoot.querySelector('.adm-cal__title');
        const calGrid = calRoot.querySelector('.adm-cal__grid');
        const calInfo = calRoot.querySelector('.adm-cal__selected-info');
        const calInfoText = calRoot.querySelector('.adm-cal__selected-text');
        const lapangCards = document.getElementById('addLapangCards');

        function initCalendar() {
            const now = new Date();
            calYear = now.getFullYear();
            calMonth = now.getMonth();
            calSelectedDay = null;
            selectedLapangId = null;
            selectedTimeSlot = null;
            renderCalendar();
            renderLapangPlaceholder();
        }

        function renderCalendar() {
            calTitle.textContent = `${MONTHS[calMonth]} ${calYear}`;
            const firstDow = new Date(calYear, calMonth, 1).getDay();
            const totalDays = new Date(calYear, calMonth + 1, 0).getDate();
            const today = new Date();

            let html = DAYS.map(d => `<span class="adm-cal__dow">${d}</span>`).join('');
            for (let i = 0; i < firstDow; i++) html += '<span class="adm-cal__day empty"></span>';

            for (let d = 1; d <= totalDays; d++) {
                const isToday = d === today.getDate() && calMonth === today.getMonth() && calYear === today.getFullYear();
                const isSel = d === calSelectedDay;
                const dow = new Date(calYear, calMonth, d).getDay();
                let cls = 'adm-cal__day';
                if (isToday) cls += ' today';
                if (isSel) cls += ' selected';
                if (dow === 0) cls += ' empty'; // Sunday disabled
                html += `<button type="button" class="${cls}" data-day="${d}" ${dow === 0 ? 'disabled' : ''}>${d}</button>`;
            }

            calGrid.innerHTML = html;

            calGrid.querySelectorAll('.adm-cal__day:not(.empty)').forEach(btn => {
                btn.addEventListener('click', () => {
                    calSelectedDay = parseInt(btn.dataset.day);
                    selectedLapangId = null;
                    selectedTimeSlot = null;
                    renderCalendar();
                    renderLapangCards();
                    updateSummary();
                });
            });

            if (calSelectedDay) {
                const d = new Date(calYear, calMonth, calSelectedDay);
                calInfoText.textContent = `${DAY_NAMES[d.getDay()]}, ${calSelectedDay} ${MONTHS[calMonth]} ${calYear}`;
                calInfo.style.display = 'flex';
            } else {
                calInfo.style.display = 'none';
            }
        }

        function renderLapangPlaceholder() {
            lapangCards.innerHTML = `
            <div class="no-selection-placeholder">
                <span class="material-symbols-outlined">touch_app</span>
                <p>Pilih tanggal di kalender untuk melihat jadwal tersedia</p>
            </div>
        `;
        }

        function renderLapangCards() {
            if (!calSelectedDay) { renderLapangPlaceholder(); return; }

            let html = '';
            LAPANGS.forEach(lap => {
                const isActive = selectedLapangId === lap.id;
                html += `
                <div class="adm-lapang-card ${isActive ? 'active' : ''}" data-lapang-id="${lap.id}">
                    <div class="adm-lapang-card__header">
                        <span class="material-symbols-outlined">stadium</span>
                        <span>${lap.name}</span>
                    </div>
                    <div class="adm-lapang-card__body">
                        <div class="adm-slot-grid" id="addSlots-${lap.id}"></div>
                    </div>
                </div>
            `;
            });
            lapangCards.innerHTML = html;

            // Render timeslots for each lapang
            LAPANGS.forEach(lap => {
                const grid = document.getElementById(`addSlots-${lap.id}`);
                const key = `${calYear}-${calMonth + 1}-${calSelectedDay}-${lap.id}`;
                const bookedSlots = BOOKED[key] || [];

                let shtml = '';
                TIME_SLOTS.forEach(slot => {
                    const isBooked = bookedSlots.includes(slot.label);
                    const isSel = selectedLapangId === lap.id && selectedTimeSlot === slot.label;
                    let cls = 'adm-slot';
                    if (isBooked) cls += ' disabled';
                    if (isSel) cls += ' selected';
                    shtml += `<button type="button" class="${cls}" data-slot="${slot.label}" data-lapang="${lap.id}" ${isBooked ? 'disabled' : ''}>${slot.start}</button>`;
                });
                grid.innerHTML = shtml;

                // Click handlers
                grid.querySelectorAll('.adm-slot:not(.disabled)').forEach(btn => {
                    btn.addEventListener('click', () => {
                        selectedLapangId = parseInt(btn.dataset.lapang);
                        selectedTimeSlot = btn.dataset.slot;
                        renderLapangCards(); // Re-render all cards to show active state
                        updateSummary();
                    });
                });
            });
        }

        function updateSummary() {
            const summary = document.getElementById('addBookingSummary');
            const sLapang = document.getElementById('summaryLapang');
            const sTanggal = document.getElementById('summaryTanggal');
            const sJam = document.getElementById('summaryJam');

            if (selectedLapangId && selectedTimeSlot && calSelectedDay) {
                const lap = LAPANGS.find(l => l.id === selectedLapangId);
                sLapang.textContent = lap ? lap.name : '-';
                sTanggal.textContent = `${calSelectedDay} ${MONTHS[calMonth]} ${calYear}`;
                sJam.textContent = selectedTimeSlot;
                summary.style.display = 'flex';
            } else {
                summary.style.display = 'none';
            }
        }

        // Calendar navigation
        calRoot.querySelectorAll('.adm-cal__nav').forEach(btn => {
            btn.addEventListener('click', () => {
                if (btn.dataset.dir === 'prev') {
                    calMonth--;
                    if (calMonth < 0) { calMonth = 11; calYear--; }
                } else {
                    calMonth++;
                    if (calMonth > 11) { calMonth = 0; calYear++; }
                }
                calSelectedDay = null;
                selectedLapangId = null;
                selectedTimeSlot = null;
                renderCalendar();
                renderLapangPlaceholder();
                updateSummary();
            });
        });

        // Init calendar when modal opens
        const addModal = document.getElementById('addBookingModal');
        addModal.addEventListener('shown.bs.modal', () => {
            initCalendar();
        });

        /* ===== UPLOAD BUKTI BAYAR ===== */
        const addFileInput = document.getElementById('addBuktiBayarInput');
        const addUploadZone = document.getElementById('addUploadZone');
        const addUploadPrev = document.getElementById('addUploadPreview');
        const addPreviewImg = document.getElementById('addPreviewImg');
        const addRemoveFile = document.getElementById('addRemoveFile');

        if (addFileInput) {
            addFileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        addPreviewImg.src = e.target.result;
                        addUploadPrev.style.display = 'block';
                        addUploadZone.classList.add('has-file');
                        addUploadZone.querySelector('p').textContent = file.name;
                        addUploadZone.querySelector('.hint').textContent = (file.size / 1024).toFixed(1) + ' KB';
                    };
                    reader.readAsDataURL(file);
                }
            });

            addRemoveFile.addEventListener('click', function () {
                addFileInput.value = '';
                addUploadPrev.style.display = 'none';
                addPreviewImg.src = '';
                addUploadZone.classList.remove('has-file');
                addUploadZone.querySelector('p').textContent = 'Klik atau seret file ke sini';
                addUploadZone.querySelector('.hint').textContent = 'Format: JPG, PNG, JPEG — Maks 2MB';
            });
        }

        /* ===== BUKTI BAYAR LIGHTBOX ===== */
        const buktiBayarModal = document.getElementById('buktiBayarModal');
        if (buktiBayarModal) {
            buktiBayarModal.addEventListener('show.bs.modal', function (event) {
                const trigger = event.relatedTarget;
                const buktiFile = trigger ? trigger.getAttribute('data-bukti') : '';
                const container = document.getElementById('buktiContainer');

                if (buktiFile && buktiFile.trim() !== '') {
                    container.innerHTML = `
                    <div style="text-align:center;">
                        <div style="background:var(--admin-surface-low); border-radius:0.75rem; padding:2rem; display:inline-block;">
                            <span class="material-symbols-outlined" style="font-size:4rem; color:#059669; display:block; margin-bottom:0.75rem;">verified</span>
                            <p style="font-size:0.9rem; font-weight:700; color:var(--admin-on-surface); margin-bottom:0.25rem;">Bukti Pembayaran Tersedia</p>
                            <p style="font-size:0.75rem; color:var(--admin-secondary); margin-bottom:0;">${buktiFile}</p>
                        </div>
                    </div>
                `;
                } else {
                    container.innerHTML = `
                    <div class="no-bukti">
                        <span class="material-symbols-outlined">image_not_supported</span>
                        <p style="font-size:0.85rem;">Belum ada bukti pembayaran</p>
                        <p style="font-size:0.72rem; color:var(--admin-outline);">Pembayaran cash atau belum upload</p>
                    </div>
                `;
                }
            });
        }

        /* ===== RESET ADD MODAL ON CLOSE ===== */
        addModal.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('formAddBooking');
            if (form) form.reset();
            if (addRemoveFile) addRemoveFile.click();
            document.getElementById('addBookingSummary').style.display = 'none';
        });
    })();
</script>

<?= $this->endSection() ?>