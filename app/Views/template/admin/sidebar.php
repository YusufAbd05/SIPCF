<?php $role = session()->get('role'); ?>
<aside class="admin-sidebar d-none d-md-flex flex-column">
    <div class="sidebar-brand">
        <h1>Sistem Informasi Pelayanan</h1>
    </div>

    <nav class="sidebar-nav">
        <!-- Dashboard: Semua role -->
        <a href="<?= base_url('/admin') ?>" class="sidebar-link
            <?= uri_string() === 'admin' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>

        <!-- Kelola Booking: Admin & Manajer -->
        <?php if (in_array($role, ['Admin', 'Manajer'])): ?>
            <a href="<?= base_url('/admin/booking') ?>"
                class="sidebar-link <?= uri_string() === 'admin/booking' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">event_note</span>
                <span>Kelola Booking</span>
            </a>
        <?php endif; ?>

        <!-- Kelola Lapang: Manajer only -->
        <?php if ($role === 'Manajer'): ?>
            <a href="<?= base_url('/admin/lapang') ?>"
                class="sidebar-link <?= uri_string() === 'admin/lapang' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">stadium</span>
                <span>Kelola Lapang</span>
            </a>
        <?php endif; ?>

        <!-- Kelola Tarif: Manajer & Owner -->
        <?php if (in_array($role, ['Manajer', 'Owner'])): ?>
            <a href="<?= base_url('/admin/tarif') ?>"
                class="sidebar-link <?= uri_string() === 'admin/tarif' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">payments</span>
                <span>Kelola Tarif</span>
            </a>
        <?php endif; ?>

        <!-- Kelola User: Manajer only -->
        <?php if ($role === 'Manajer'): ?>
            <a href="<?= base_url('/admin/users') ?>"
                class="sidebar-link <?= uri_string() === 'admin/users' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">group</span>
                <span>Kelola User</span>
            </a>
        <?php endif; ?>

        <!-- Laporan: Semua role -->
        <a href="<?= base_url('/admin/laporan') ?>"
            class="sidebar-link <?= uri_string() === 'admin/laporan' ? 'active' : '' ?>">
            <span class="material-symbols-outlined">analytics</span>
            <span>Kelola Laporan</span>
        </a>
    </nav>
</aside>