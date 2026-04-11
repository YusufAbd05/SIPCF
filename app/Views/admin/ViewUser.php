<?= $this->extend('template/admin/base') ?>
<?= $this->section('title') ?>Kelola User<?= $this->endSection() ?>
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

    /* ===== ALERT ===== */
    .alert-toast {
        position: fixed;
        top: 1.5rem;
        right: 1.5rem;
        z-index: 9999;
        min-width: 320px;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.2);
        animation: slideInRight 0.4s cubic-bezier(0.22,1,0.36,1) both;
    }
    .alert-toast.success {
        background: linear-gradient(135deg, #059669, #10b981);
        color: #fff;
    }
    .alert-toast .material-symbols-outlined { font-size: 1.3rem; }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(100px); }
        to   { opacity: 1; transform: translateX(0); }
    }

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
    .stat-chip__icon.blue   { background: #eff6ff; color: #2563eb; }
    .stat-chip__icon.green  { background: #ecfdf5; color: #059669; }
    .stat-chip__icon.purple { background: #faf5ff; color: #7c3aed; }
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
    .user-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .user-table thead th {
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
    .user-table tbody td {
        font-family: 'Inter', sans-serif;
        font-size: 0.825rem;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--admin-surface-container);
        vertical-align: middle;
        color: var(--admin-on-surface);
    }
    .user-table tbody tr {
        transition: background 0.15s;
    }
    .user-table tbody tr:hover {
        background: rgba(0, 87, 205, 0.02);
    }
    .user-table tbody tr:last-child td {
        border-bottom: none;
    }

    .td-name {
        font-weight: 700;
        color: var(--admin-on-surface);
    }
    .td-email {
        color: var(--admin-secondary);
        font-size: 0.78rem;
    }
    .td-phone {
        font-size: 0.8rem;
        font-weight: 500;
    }
    .td-password {
        font-family: 'Inter', monospace;
        font-size: 0.78rem;
        color: var(--admin-outline);
        letter-spacing: 0.15em;
    }

    /* User avatar */
    .user-avatar {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }
    .user-avatar.admin { background: linear-gradient(135deg, #0057cd, #0d6efd); }
    .user-avatar.membership { background: linear-gradient(135deg, #7c3aed, #a78bfa); }
    .user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .user-info__details { display: flex; flex-direction: column; gap: 0.1rem; }
    .user-info__name {
        font-weight: 700;
        font-size: 0.84rem;
        color: var(--admin-on-surface);
    }
    .user-info__email {
        font-size: 0.7rem;
        color: var(--admin-secondary);
    }

    /* Role badge */
    .badge-role {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.62rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.25rem 0.7rem;
        border-radius: 9999px;
    }
    .badge-role .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .badge-role.admin           { background: #eff6ff; color: #2563eb; }
    .badge-role.admin .dot      { background: #2563eb; }
    .badge-role.membership      { background: #faf5ff; color: #7c3aed; }
    .badge-role.membership .dot { background: #7c3aed; }

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
    .action-btn.edit:hover { background: #dbeafe; border-color: #93c5fd; }
    .action-btn.delete {
        color: #dc2626;
        border-color: #fecaca;
        background: #fef2f2;
    }
    .action-btn.delete:hover { background: #fee2e2; border-color: #fca5a5; }

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

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
    }
    .empty-state .material-symbols-outlined {
        font-size: 3rem;
        color: var(--admin-outline-variant);
        margin-bottom: 0.75rem;
    }
    .empty-state__title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--admin-on-surface);
        margin-bottom: 0.25rem;
    }
    .empty-state__desc {
        font-size: 0.8rem;
        color: var(--admin-secondary);
    }

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

    /* Password toggle */
    .password-wrap {
        position: relative;
    }
    .password-wrap input { padding-right: 2.5rem; }
    .password-toggle {
        position: absolute;
        right: 0.6rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--admin-outline);
        padding: 0.15rem;
        display: flex;
        align-items: center;
        transition: color 0.15s;
    }
    .password-toggle:hover { color: var(--admin-primary); }
    .password-toggle .material-symbols-outlined { font-size: 1.1rem; }

    /* Delete confirm modal */
    .delete-confirm-icon {
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
        background: #fef2f2;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
    .delete-confirm-icon .material-symbols-outlined {
        font-size: 2rem;
        color: #dc2626;
    }
    .btn-modal-delete {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.6rem 1.5rem;
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px -2px rgba(220, 38, 38, 0.3);
    }
    .btn-modal-delete:hover { transform: translateY(-1px); color: #fff; }
    .btn-modal-delete .material-symbols-outlined { font-size: 1rem; }
</style>

<main class="flex-grow-1 p-3 p-md-5" style="background:var(--admin-surface);">

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-toast success" id="alertToast">
            <span class="material-symbols-outlined">check_circle</span>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header animate-in">
        <div>
            <h2 class="page-header__title">Kelola User</h2>
            <p class="page-header__subtitle">Manajemen data pengguna dan hak akses</p>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <span class="material-symbols-outlined">person_add</span>
            Tambah User
        </button>
    </div>

    <!-- Stats -->
    <div class="stats-row animate-in" style="animation-delay:.06s;">
        <div class="stat-chip">
            <div class="stat-chip__icon blue"><span class="material-symbols-outlined">group</span></div>
            <div>
                <p class="stat-chip__label">Total User</p>
                <p class="stat-chip__value"><?= $totalUser ?></p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon green"><span class="material-symbols-outlined">admin_panel_settings</span></div>
            <div>
                <p class="stat-chip__label">Admin</p>
                <p class="stat-chip__value"><?= $totalAdmin ?></p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon purple"><span class="material-symbols-outlined">card_membership</span></div>
            <div>
                <p class="stat-chip__label">Membership</p>
                <p class="stat-chip__value"><?= $totalMembership ?></p>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card animate-in" style="animation-delay:.12s;">
        <div class="table-toolbar">
            <div class="table-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" id="searchInput" placeholder="Cari nama, email, no hp..." onkeyup="searchTable()" />
            </div>
            <div class="d-flex gap-2">
                <button class="table-filter-btn" onclick="filterRole('all')" id="filterAll">
                    <span class="material-symbols-outlined">filter_list</span> Semua
                </button>
                <button class="table-filter-btn" onclick="filterRole('Admin')" id="filterAdmin">
                    <span class="material-symbols-outlined">admin_panel_settings</span> Admin
                </button>
                <button class="table-filter-btn" onclick="filterRole('Membership')" id="filterMembership">
                    <span class="material-symbols-outlined">card_membership</span> Membership
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="user-table" id="userTable">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>No HP</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <?php
                                $roleLower = strtolower($user['role']);
                                $nameParts = explode(' ', trim($user['nama']));
                                $initials = strtoupper(substr($nameParts[0], 0, 1));
                                if (count($nameParts) > 1) {
                                    $initials .= strtoupper(substr(end($nameParts), 0, 1));
                                }
                            ?>
                            <tr data-role="<?= esc($user['role']) ?>">
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar <?= $roleLower ?>"><?= $initials ?></div>
                                        <div class="user-info__details">
                                            <span class="user-info__name"><?= esc($user['nama']) ?></span>
                                            <span class="user-info__email"><?= esc($user['email']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="td-phone"><?= esc($user['no_hp']) ?></td>
                                <td class="td-password">••••••••</td>
                                <td>
                                    <span class="badge-role <?= $roleLower ?>">
                                        <span class="dot"></span><?= esc($user['role']) ?>
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button class="action-btn edit" title="Edit"
                                            onclick="openEditModal(<?= $user['id_user'] ?>, '<?= esc($user['nama'], 'js') ?>', '<?= esc($user['email'], 'js') ?>', '<?= esc($user['no_hp'], 'js') ?>', '<?= esc($user['role'], 'js') ?>')">
                                            <span class="material-symbols-outlined">edit</span> Edit
                                        </button>
                                        <button class="action-btn delete" title="Hapus"
                                            onclick="openDeleteModal(<?= $user['id_user'] ?>)">
                                            <span class="material-symbols-outlined">delete</span> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <span class="material-symbols-outlined">person_off</span>
                                    <p class="empty-state__title">Belum ada data user</p>
                                    <p class="empty-state__desc">Klik tombol "Tambah User" untuk menambahkan user baru.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span class="table-footer__info">Menampilkan <?= $totalUser ?> data</span>
        </div>
    </div>

</main>

<!-- ===== MODAL: TAMBAH USER ===== -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserLabel">
                    <span class="material-symbols-outlined">person_add</span>
                    Tambah User Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/admin/users/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">person</span>
                        Informasi User
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">badge</span> Nama
                            </label>
                            <input type="text" name="nama" class="form-control-custom" placeholder="Masukkan nama lengkap" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">mail</span> Email
                            </label>
                            <input type="email" name="email" class="form-control-custom" placeholder="email@contoh.com" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">call</span> No. HP
                            </label>
                            <input type="tel" name="no_hp" class="form-control-custom" placeholder="08xxxxxxxxxx" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">lock</span> Password
                            </label>
                            <div class="password-wrap">
                                <input type="password" name="password" class="form-control-custom" placeholder="Minimal 8 karakter" required />
                                <button type="button" class="password-toggle" onclick="togglePassword(this)">
                                    <span class="material-symbols-outlined">visibility_off</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">shield_person</span> Role
                            </label>
                            <select name="role" class="form-control-custom" required>
                                <option value="" disabled selected>Pilih role...</option>
                                <option value="Admin">Admin</option>
                                <option value="Membership">Membership</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">
                        <span class="material-symbols-outlined">save</span> Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== MODAL: EDIT USER ===== -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserLabel">
                    <span class="material-symbols-outlined">edit</span>
                    Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/admin/users/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_user" id="editIdUser" />
                <div class="modal-body">
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">person</span>
                        Informasi User
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">badge</span> Nama
                            </label>
                            <input type="text" name="nama" id="editNama" class="form-control-custom" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">mail</span> Email
                            </label>
                            <input type="email" name="email" id="editEmail" class="form-control-custom" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">call</span> No. HP
                            </label>
                            <input type="tel" name="no_hp" id="editNoHp" class="form-control-custom" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">lock</span> Password
                            </label>
                            <div class="password-wrap">
                                <input type="password" name="password" class="form-control-custom" placeholder="Kosongkan jika tidak diubah" />
                                <button type="button" class="password-toggle" onclick="togglePassword(this)">
                                    <span class="material-symbols-outlined">visibility_off</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">shield_person</span> Role
                            </label>
                            <select name="role" id="editRole" class="form-control-custom" required>
                                <option value="Admin">Admin</option>
                                <option value="Membership">Membership</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">
                        <span class="material-symbols-outlined">save</span> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== MODAL: KONFIRMASI HAPUS ===== -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserLabel">
                    <span class="material-symbols-outlined" style="color:#dc2626;">warning</span>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="delete-confirm-icon">
                    <span class="material-symbols-outlined">person_remove</span>
                </div>
                <p style="font-size:0.9rem;font-weight:600;color:var(--admin-on-surface);">
                    Apakah anda yakin ingin menghapus data ini?
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <form action="<?= base_url('/admin/users/delete') ?>" method="POST" style="display:inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_user" id="deleteIdUser" />
                    <button type="submit" class="btn-modal-delete">
                        <span class="material-symbols-outlined">delete</span> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
function togglePassword(btn) {
    const input = btn.parentElement.querySelector('input');
    const icon = btn.querySelector('.material-symbols-outlined');
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility_off';
    }
}

// Open Edit Modal with data
function openEditModal(id, nama, email, noHp, role) {
    document.getElementById('editIdUser').value = id;
    document.getElementById('editNama').value = nama;
    document.getElementById('editEmail').value = email;
    document.getElementById('editNoHp').value = noHp;
    document.getElementById('editRole').value = role;
    new bootstrap.Modal(document.getElementById('editUserModal')).show();
}

// Open Delete Modal with data
function openDeleteModal(id) {
    document.getElementById('deleteIdUser').value = id;
    new bootstrap.Modal(document.getElementById('deleteUserModal')).show();
}

// Search table
function searchTable() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#userTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
}

// Filter by role
function filterRole(role) {
    const rows = document.querySelectorAll('#userTable tbody tr');
    rows.forEach(row => {
        if (role === 'all') {
            row.style.display = '';
        } else {
            row.style.display = row.dataset.role === role ? '' : 'none';
        }
    });

    // Update active button styling
    document.querySelectorAll('.table-filter-btn').forEach(btn => {
        btn.style.background = 'transparent';
        btn.style.borderColor = '';
        btn.style.color = '';
    });
    const activeBtn = role === 'all' ? document.getElementById('filterAll') :
                      role === 'Admin' ? document.getElementById('filterAdmin') :
                      document.getElementById('filterMembership');
    if (activeBtn) {
        activeBtn.style.background = 'var(--admin-surface-low)';
        activeBtn.style.borderColor = 'var(--admin-primary-fixed-dim)';
        activeBtn.style.color = 'var(--admin-primary)';
    }
}

// Auto-dismiss flash message
document.addEventListener('DOMContentLoaded', function() {
    const toast = document.getElementById('alertToast');
    if (toast) {
        setTimeout(() => {
            toast.style.transition = 'opacity 0.5s, transform 0.5s';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100px)';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
});
</script>

<?= $this->endSection() ?>
