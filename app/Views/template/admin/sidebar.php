<!-- ================= SIDEBAR ================= -->
<aside class="admin-sidebar d-none d-md-flex flex-column">
    <div class="sidebar-brand">
        <h1>Atrium Admin</h1>
        <p>Management Suite</p>
    </div>

    <nav class="sidebar-nav">
        <a href="<?= base_url('/admin') ?>" class="sidebar-link <?= uri_string() === 'admin' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="<?= base_url('/admin/booking') ?>" class="sidebar-link <?= uri_string() === 'admin/booking' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">event_note</span>
            <span>Kelola Booking</span>
        </a>
        <a href="<?= base_url('/admin/lapang') ?>" class="sidebar-link <?= uri_string() === 'admin/lapang' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">stadium</span>
            <span>Kelola Lapang</span>
        </a>
        <a href="<?= base_url('/admin/users') ?>" class="sidebar-link <?= uri_string() === 'admin/users' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">group</span>
            <span>Users</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="material-symbols-outlined">analytics</span>
            <span>Reports</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="material-symbols-outlined">settings</span>
            <span>Settings</span>
        </a>
    </nav>
</aside>
