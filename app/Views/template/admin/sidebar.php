<aside class="admin-sidebar d-none d-md-flex flex-column">
    <div class="sidebar-brand">
        <h1>Sistem Informasi Pelayanan</h1>
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
        <a href="<?= base_url('/admin/tarif') ?>"
            class="sidebar-link <?= uri_string() === 'admin/tarif' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">payments</span>
            <span>Kelola Tarif</span>
        </a>
        <a href="<?= base_url('/admin/users') ?>"
            class="sidebar-link <?= uri_string() === 'admin/users' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">group</span>
            <span>Kelola User</span>
        </a>
        <a href="<?= base_url('/admin/laporan') ?>"
            class="sidebar-link <?= uri_string() === 'admin/laporan' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">analytics</span>
            <span>Kelola Laporan</span>
        </a>
        <!-- <a href="#" class="sidebar-link">
            <span class="material-symbols-outlined">settings</span>
            <span>Pengaturan</span>
        </a> -->
    </nav>
</aside>