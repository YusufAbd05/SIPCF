<?= $this->extend('template/admin/base') ?>
<?= $this->section('title') ?>Kelola User<?= $this->endSection() ?>
<?= $this->section('content') ?>

<main class="flex-grow-1 p-3 p-md-5" style="background:var(--admin-surface);">

    <!-- Flash Message Toast -->
    <?php if (session()->getFlashdata('success')): ?>
        <div id="alertToast" class="alert-toast">
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

    <!-- Table Card -->
    <div class="table-card animate-in" style="animation-delay:.12s;">
        <div class="table-toolbar">
            <div class="table-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" id="searchInput" placeholder="Cari nama, email, no hp..." oninput="searchTable()" />
            </div>
            <div class="d-flex gap-2">
                <button class="table-filter-btn" id="filterAll" onclick="filterRole('all')">
                    <span class="material-symbols-outlined">groups</span> Semua
                </button>
                <button class="table-filter-btn" id="filterAdmin" onclick="filterRole('Admin')">
                    <span class="material-symbols-outlined">admin_panel_settings</span> Admin
                </button>
                <button class="table-filter-btn" id="filterMembership" onclick="filterRole('Membership')">
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
                            // Generate initials from name
                            $nameParts = explode(' ', $user['nama']);
                            $initials = strtoupper(substr($nameParts[0], 0, 1));
                            if (count($nameParts) > 1) {
                                $initials .= strtoupper(substr(end($nameParts), 0, 1));
                            }
                            $roleClass = strtolower($user['role']);
                            ?>
                            <tr data-role="<?= esc($user['role']) ?>">
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar <?= $roleClass ?>"><?= $initials ?></div>
                                        <div class="user-info__details">
                                            <span class="user-info__name"><?= esc($user['nama']) ?></span>
                                            <span class="user-info__email"><?= esc($user['email']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="td-phone"><?= esc($user['no_hp']) ?></td>
                                <td class="td-password">••••••••</td>
                                <td>
                                    <span class="badge-role <?= $roleClass ?>">
                                        <span class="dot"></span><?= esc($user['role']) ?>
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button class="action-btn edit" title="Edit"
                                            onclick="openEditModal('<?= $user['id_user'] ?>', '<?= esc($user['nama']) ?>', '<?= esc($user['email']) ?>', '<?= esc($user['no_hp']) ?>', '<?= esc($user['role']) ?>')">
                                            <span class="material-symbols-outlined">edit</span> Edit
                                        </button>
                                        <button class="action-btn delete" title="Hapus"
                                            onclick="openDeleteModal('<?= $user['id_user'] ?>', '<?= esc($user['nama']) ?>')">
                                            <span class="material-symbols-outlined">delete</span> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center; padding:3rem 1rem;">
                                <span class="material-symbols-outlined"
                                    style="font-size:2.5rem; color:var(--admin-outline); display:block; margin-bottom:0.5rem;">person_off</span>
                                <p style="color:var(--admin-secondary); font-size:0.85rem; margin:0;">Belum ada data user
                                </p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($users)): ?>
            <div class="table-footer">
                <span class="table-footer__info">Menampilkan <?= count($users) ?> data</span>
            </div>
        <?php endif; ?>
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
            <form action="<?= base_url('/admin/users/save') ?>" method="post" id="formAddUser">
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
                            <input type="text" name="nama" class="form-control-custom"
                                placeholder="Masukkan nama lengkap" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">mail</span> Email
                            </label>
                            <input type="email" name="email" class="form-control-custom" placeholder="email@contoh.com"
                                required />
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">call</span> No. HP
                            </label>
                            <input type="tel" name="no_hp" class="form-control-custom" placeholder="08xxxxxxxxxx"
                                required />
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">lock</span> Password
                            </label>
                            <div class="password-wrap">
                                <input type="password" name="password" class="form-control-custom"
                                    placeholder="Minimal 8 karakter" required />
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
                        <span class="material-symbols-outlined">save</span> Simpan
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
            <form action="<?= base_url('/admin/users/update') ?>" method="post" id="formEditUser">
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
                                <input type="password" name="password" class="form-control-custom"
                                    placeholder="Kosongkan jika tidak diubah" />
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
                        <span class="material-symbols-outlined">save</span> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== MODAL: HAPUS USER ===== -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color:#fecaca;">
                <h5 class="modal-title" id="deleteUserLabel">
                    <span class="material-symbols-outlined" style="color:#dc2626;">warning</span>
                    Hapus User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/admin/users/delete') ?>" method="post" id="formDeleteUser">
                <?= csrf_field() ?>
                <input type="hidden" name="id_user" id="deleteIdUser" />
                <div class="modal-body" style="text-align:center; padding:1.5rem;">
                    <div
                        style="width:3.5rem;height:3.5rem;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <span class="material-symbols-outlined"
                            style="font-size:1.75rem;color:#dc2626;">person_remove</span>
                    </div>
                    <p style="font-size:0.88rem;font-weight:600;color:var(--admin-on-surface);margin-bottom:0.35rem;">
                        Yakin ingin menghapus?
                    </p>
                    <p id="deleteUserName" style="font-size:0.78rem;color:var(--admin-secondary);margin-bottom:0;">
                    </p>
                    <p style="font-size:0.72rem;color:var(--admin-outline);margin-top:0.5rem;margin-bottom:0;">
                        Data yang dihapus tidak dapat dikembalikan.
                    </p>
                </div>
                <div class="modal-footer" style="justify-content:center;border-top-color:#fecaca;">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn-modal-save"
                        style="background:linear-gradient(135deg,#dc2626,#ef4444);box-shadow:0 4px 12px -2px rgba(220,38,38,0.3);">
                        <span class="material-symbols-outlined">delete</span> Ya
                    </button>
                </div>
            </form>
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
    function openDeleteModal(id, nama) {
        document.getElementById('deleteIdUser').value = id;
        document.getElementById('deleteUserName').textContent = '"' + nama + '"';
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
            btn.classList.remove('filter-active');
        });
        const activeBtn = role === 'all' ? document.getElementById('filterAll') :
            role === 'Admin' ? document.getElementById('filterAdmin') :
                document.getElementById('filterMembership');
        if (activeBtn) {
            activeBtn.classList.add('filter-active');
        }
    }

    // Auto-dismiss flash message
    document.addEventListener('DOMContentLoaded', function () {
        const toast = document.getElementById('alertToast');
        if (toast) {
            setTimeout(() => {
                toast.style.transition = 'opacity 0.5s, transform 0.5s';
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        // Set "Semua" filter as active by default
        document.getElementById('filterAll').classList.add('filter-active');
    });
</script>

<?= $this->endSection() ?>