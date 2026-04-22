<aside class="admin-sidebar d-none d-md-flex flex-column">
    <div class="sidebar-brand">
        <h1>Atrium Admin</h1>
        <p>Management Suite</p>
    </div>

    <nav class="sidebar-nav">
        <a href="<?= base_url('/admin') ?>" class="sidebar-link
            <?= uri_string() === 'admin' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="<?= base_url('/admin/booking') ?>"
            class="sidebar-link <?= uri_string() === 'admin/booking' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">event_note</span>
            <span>Kelola Booking</span>
        </a>
        <a href="<?= base_url('/admin/lapang') ?>"
            class="sidebar-link <?= uri_string() === 'admin/lapang' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">stadium</span>
            <span>Kelola Lapang</span>
        </a>
        <a href="<?= base_url('/admin/users') ?>"
            class="sidebar-link <?= uri_string() === 'admin/users' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">group</span>
            <span>Users</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="material-symbols-outlined">analytics</span>
            <span>Kelola Laporan</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="material-symbols-outlined">settings</span>
            <span>Pengaturan</span>
        </a>
    </nav>

    <!-- Sidebar Footer: User & Logout -->
    <div class="sidebar-footer" style="margin-top:auto; padding:1rem;">
        <div style="display:flex; align-items:center; gap:0.6rem; padding:0.65rem 0.75rem; background:#fff; border-radius:0.625rem; box-shadow:0 1px 3px rgba(0,0,0,0.06); margin-bottom:0.5rem;">
            <div style="width:2rem;height:2rem;border-radius:50%;background:linear-gradient(135deg,#0057cd,#0d6efd);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.7rem;font-weight:700;flex-shrink:0;">
                <?= strtoupper(substr(session()->get('nama') ?? 'A', 0, 1)) ?>
            </div>
            <div style="min-width:0; flex:1;">
                <p style="font-size:0.78rem;font-weight:700;margin:0;color:#0f172a;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= esc(session()->get('nama') ?? 'Admin') ?></p>
                <p style="font-size:0.6rem;color:#94a3b8;margin:0;text-transform:uppercase;letter-spacing:0.06em;font-weight:600;"><?= esc(session()->get('role') ?? 'Admin') ?></p>
            </div>
        </div>
        <a href="#" class="sidebar-link" style="color:#dc2626;" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <span class="material-symbols-outlined" style="font-size:1.2rem;">logout</span>
            <span>Logout</span>
        </a>
    </div>
</aside>