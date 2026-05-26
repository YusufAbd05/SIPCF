<?= $this->extend('template/admin/base') ?>
<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?php
$role = session()->get('role');
$nama = session()->get('nama') ?? 'User';
?>

<main class="flex-grow-1 p-3 p-md-5" style="background:var(--admin-surface);">

    <!-- ═══════════════════════════════════════════ -->
    <!--  WELCOME BANNER (Semua Role)               -->
    <!-- ═══════════════════════════════════════════ -->
    <section class="mb-4 animate-in">
        <div class="welcome-banner">
            <div class="position-relative" style="z-index:1;max-width:36rem;">
                <h2>Selamat Datang, <?= esc($nama) ?>!</h2>
                <p>Anda login sebagai <b><?= esc($role) ?></b>. Sistem Informasi Pelayanan beroperasi dengan optimal hari ini.</p>
                <div class="d-flex gap-3 mt-4">
                    <a href="<?= base_url('/admin/laporan') ?>"
                        class="btn-welcome-primary text-decoration-none d-inline-flex align-items-center gap-2">
                        <span class="material-symbols-outlined" style="font-size:1.1rem;">analytics</span>
                        Lihat Laporan
                    </a>
                    <?php if (in_array($role, ['Admin', 'Manajer'])): ?>
                        <a href="<?= base_url('/admin/booking') ?>" class="btn-welcome-ghost text-decoration-none">Kelola Booking</a>
                    <?php elseif ($role === 'Owner'): ?>
                        <a href="<?= base_url('/admin/tarif') ?>" class="btn-welcome-ghost text-decoration-none">Kelola Tarif</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="glow"></div>
        </div>
    </section>


    <?php if ($role === 'Admin'): ?>
    <!-- ═══════════════════════════════════════════════════ -->
    <!--  DASHBOARD ADMIN: Operasional Harian               -->
    <!-- ═══════════════════════════════════════════════════ -->

    <!-- Metric Cards -->
    <section class="row g-3 mb-4">
        <!-- Sewa Hari Ini -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.08s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon blue">
                        <span class="material-symbols-outlined">event_available</span>
                    </div>
                    <span class="metric-badge up">Hari Ini</span>
                </div>
                <p class="metric-label">Sewa Hari Ini</p>
                <h3 class="metric-value"><?= $sewaHariIni ?> <span style="font-size:0.9rem; font-weight:600; color:var(--admin-secondary);">Sesi</span></h3>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.14s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon amber">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                    <span class="metric-badge down" style="color:#d97706; background:#fffbeb;">Perlu Cek</span>
                </div>
                <p class="metric-label">Menunggu Verifikasi</p>
                <h3 class="metric-value"><?= $menungguVerifikasi ?> <span style="font-size:0.9rem; font-weight:600; color:var(--admin-secondary);">Pesanan</span></h3>
            </div>
        </div>

        <!-- Dikonfirmasi -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.2s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon green">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                    <span class="metric-badge up">Aktif</span>
                </div>
                <p class="metric-label">Dikonfirmasi</p>
                <h3 class="metric-value"><?= $dikonfirmasi ?> <span style="font-size:0.9rem; font-weight:600; color:var(--admin-secondary);">Pesanan</span></h3>
            </div>
        </div>

        <!-- Pendapatan Hari Ini -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.26s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon indigo">
                        <span class="material-symbols-outlined">account_balance</span>
                    </div>
                    <span class="metric-badge up">Hari Ini</span>
                </div>
                <p class="metric-label">Pendapatan Hari Ini</p>
                <h3 class="metric-value" style="font-size:1.45rem;">Rp <?= number_format($pendapatanHariIni, 0, ',', '.') ?></h3>
            </div>
        </div>
    </section>

    <!-- Dual Section: Booking Terbaru + Jadwal Hari Ini -->
    <section class="row g-4 animate-in" style="animation-delay:.32s;">
        <!-- Booking Terbaru -->
        <div class="col-12 col-lg-8">
            <div class="content-card h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="content-card__title">Booking Terbaru</h4>
                        <p class="content-card__subtitle mb-0">5 pesanan terakhir yang masuk ke sistem</p>
                    </div>
                    <a href="<?= base_url('/admin/booking') ?>" class="btn-view-all" style="width:auto;padding:0.4rem 1rem;">
                        Lihat Semua
                    </a>
                </div>
                <div class="table-responsive">
                    <table style="width:100%;border-collapse:separate;border-spacing:0;">
                        <thead>
                            <tr>
                                <th style="background:var(--admin-surface-low);font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--admin-secondary);padding:0.65rem 0.75rem;border-bottom:1px solid var(--admin-surface-container);">Kode</th>
                                <th style="background:var(--admin-surface-low);font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--admin-secondary);padding:0.65rem 0.75rem;border-bottom:1px solid var(--admin-surface-container);">Penyewa</th>
                                <th style="background:var(--admin-surface-low);font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--admin-secondary);padding:0.65rem 0.75rem;border-bottom:1px solid var(--admin-surface-container);">Lapangan</th>
                                <th style="background:var(--admin-surface-low);font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--admin-secondary);padding:0.65rem 0.75rem;border-bottom:1px solid var(--admin-surface-container);">Total</th>
                                <th style="background:var(--admin-surface-low);font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--admin-secondary);padding:0.65rem 0.75rem;border-bottom:1px solid var(--admin-surface-container);">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bookingTerbaru)): ?>
                                <?php foreach ($bookingTerbaru as $bk): ?>
                                    <?php
                                    $statusColors = [
                                        'Menunggu Pembayaran' => 'background:#fffbeb;color:#92400e;',
                                        'Menunggu Verifikasi' => 'background:#fef3c7;color:#92400e;',
                                        'Dikonfirmasi'        => 'background:#d1fae5;color:#065f46;',
                                        'Selesai'             => 'background:#eff6ff;color:#1e40af;',
                                        'Ditolak'             => 'background:#fef2f2;color:#991b1b;',
                                        'Dibatalkan'          => 'background:#f1f5f9;color:#475569;',
                                    ];
                                    $sColor = $statusColors[$bk['status_pesanan']] ?? 'background:#f1f5f9;color:#475569;';
                                    ?>
                                    <tr>
                                        <td style="padding:0.65rem 0.75rem;font-size:0.78rem;font-weight:700;color:var(--admin-primary);border-bottom:1px solid var(--admin-surface-container);"><?= esc($bk['kode_sewa']) ?></td>
                                        <td style="padding:0.65rem 0.75rem;font-size:0.78rem;border-bottom:1px solid var(--admin-surface-container);"><?= esc($bk['nama_penyewa']) ?></td>
                                        <td style="padding:0.65rem 0.75rem;font-size:0.78rem;border-bottom:1px solid var(--admin-surface-container);"><?= esc($bk['nama_lapangan'] ?? '-') ?></td>
                                        <td style="padding:0.65rem 0.75rem;font-size:0.78rem;font-weight:600;border-bottom:1px solid var(--admin-surface-container);">Rp <?= number_format($bk['total_bayar'], 0, ',', '.') ?></td>
                                        <td style="padding:0.65rem 0.75rem;border-bottom:1px solid var(--admin-surface-container);">
                                            <span style="display:inline-block;padding:0.2rem 0.6rem;border-radius:999px;font-size:0.65rem;font-weight:700;<?= $sColor ?>"><?= esc($bk['status_pesanan']) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--admin-secondary);font-size:0.85rem;">
                                        <span class="material-symbols-outlined d-block mb-2" style="font-size:2rem;color:var(--admin-outline);">inbox</span>
                                        Belum ada booking
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Jadwal Hari Ini -->
        <div class="col-12 col-lg-4">
            <div class="content-card h-100 d-flex flex-column">
                <h4 class="content-card__title">Jadwal Hari Ini</h4>
                <p class="content-card__subtitle mb-4"><?= date('l, d F Y') ?></p>

                <div class="d-flex flex-column gap-3 flex-grow-1" style="max-height:22rem;overflow-y:auto;">
                    <?php if (!empty($jadwalHariIni)): ?>
                        <?php foreach ($jadwalHariIni as $jdw): ?>
                            <div style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:0.5rem;background:var(--admin-surface-low);transition:background 0.15s;">
                                <div style="min-width:3.5rem;text-align:center;">
                                    <p style="font-size:0.82rem;font-weight:800;color:var(--admin-primary);margin:0;line-height:1.2;"><?= substr($jdw['jam_mulai'], 0, 5) ?></p>
                                    <p style="font-size:0.6rem;color:var(--admin-secondary);margin:0;"><?= substr($jdw['jam_selesai'], 0, 5) ?></p>
                                </div>
                                <div style="width:3px;height:2rem;border-radius:999px;background:linear-gradient(180deg,var(--admin-primary),var(--admin-primary-container));flex-shrink:0;"></div>
                                <div style="flex:1;min-width:0;">
                                    <p style="font-size:0.8rem;font-weight:700;color:var(--admin-on-surface);margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= esc($jdw['nama_penyewa']) ?></p>
                                    <p style="font-size:0.68rem;color:var(--admin-secondary);margin:0;"><?= esc($jdw['nama_lapangan'] ?? '') ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align:center;padding:2rem 0;flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                            <span class="material-symbols-outlined mb-2" style="font-size:2.5rem;color:var(--admin-outline);">event_busy</span>
                            <p style="color:var(--admin-secondary);font-size:0.82rem;margin:0;">Tidak ada jadwal hari ini</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php elseif ($role === 'Manajer'): ?>
    <!-- ═══════════════════════════════════════════════════ -->
    <!--  DASHBOARD MANAJER: Overview Bisnis                -->
    <!-- ═══════════════════════════════════════════════════ -->

    <!-- Metric Cards -->
    <section class="row g-3 mb-4">
        <!-- Total Booking Bulan Ini -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.08s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon blue">
                        <span class="material-symbols-outlined">calendar_month</span>
                    </div>
                    <span class="metric-badge up">Bulan Ini</span>
                </div>
                <p class="metric-label">Total Booking</p>
                <h3 class="metric-value"><?= $totalBookingBulan ?> <span style="font-size:0.9rem; font-weight:600; color:var(--admin-secondary);">Pesanan</span></h3>
            </div>
        </div>

        <!-- Omset Bulan Ini -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.14s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon green">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <span class="metric-badge up">Lunas</span>
                </div>
                <p class="metric-label">Omset Bulan Ini</p>
                <h3 class="metric-value" style="font-size:1.45rem;">Rp <?= number_format($omsetBulan, 0, ',', '.') ?></h3>
            </div>
        </div>

        <!-- Lapangan Aktif -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.2s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon amber">
                        <span class="material-symbols-outlined">stadium</span>
                    </div>
                    <span class="metric-badge up">Tersedia</span>
                </div>
                <p class="metric-label">Lapangan Aktif</p>
                <h3 class="metric-value"><?= $lapanganAktif ?> <span style="font-size:0.9rem; font-weight:600; color:var(--admin-secondary);">Lapang</span></h3>
            </div>
        </div>

        <!-- Total User -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.26s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon indigo">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <span class="metric-badge up">Terdaftar</span>
                </div>
                <p class="metric-label">Total User Sistem</p>
                <h3 class="metric-value"><?= $totalUser ?> <span style="font-size:0.9rem; font-weight:600; color:var(--admin-secondary);">Orang</span></h3>
            </div>
        </div>
    </section>

    <!-- Dual Section: Grafik Pendapatan + Distribusi Status -->
    <section class="row g-4 animate-in" style="animation-delay:.32s;">
        <!-- Grafik Pendapatan Harian -->
        <div class="col-12 col-lg-8">
            <div class="content-card h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="content-card__title">Tren Pendapatan</h4>
                        <p class="content-card__subtitle mb-0">Pendapatan harian 30 hari terakhir</p>
                    </div>
                </div>
                <?php if (!empty($chartLabels)): ?>
                <div class="chart-container">
                    <canvas id="chartPendapatan"></canvas>
                </div>
                <?php else: ?>
                <div class="chart-container" style="display:flex;flex-direction:column;align-items:center;justify-content:center;background:#f8fafc;border-radius:0.75rem;">
                    <span class="material-symbols-outlined mb-2" style="font-size:3rem;color:var(--admin-outline);">monitoring</span>
                    <p style="color:var(--admin-secondary);font-size:0.85rem;font-weight:500;margin:0;">Belum ada data pendapatan</p>
                    <p style="color:var(--admin-outline);font-size:0.72rem;margin:0.25rem 0 0;">Data akan muncul saat ada transaksi</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Distribusi Status Booking -->
        <div class="col-12 col-lg-4">
            <div class="content-card h-100 d-flex flex-column">
                <h4 class="content-card__title">Status Booking</h4>
                <p class="content-card__subtitle mb-4">Distribusi bulan ini</p>

                <div class="d-flex flex-column gap-3 flex-grow-1">
                    <?php
                    $statusIcons = [
                        'Menunggu Pembayaran' => ['icon' => 'hourglass_top', 'color' => '#d97706', 'bg' => '#fffbeb'],
                        'Menunggu Verifikasi' => ['icon' => 'pending_actions', 'color' => '#ea580c', 'bg' => '#fff7ed'],
                        'Dikonfirmasi'        => ['icon' => 'verified', 'color' => '#059669', 'bg' => '#ecfdf5'],
                        'Selesai'             => ['icon' => 'check_circle', 'color' => '#2563eb', 'bg' => '#eff6ff'],
                        'Ditolak'             => ['icon' => 'cancel', 'color' => '#dc2626', 'bg' => '#fef2f2'],
                        'Dibatalkan'          => ['icon' => 'block', 'color' => '#64748b', 'bg' => '#f1f5f9'],
                    ];
                    $totalStatus = array_sum(array_column($statusDistribusi, 'jumlah'));
                    ?>
                    <?php if (!empty($statusDistribusi)): ?>
                        <?php foreach ($statusDistribusi as $sd): ?>
                            <?php
                            $si = $statusIcons[$sd['status_pesanan']] ?? ['icon' => 'info', 'color' => '#64748b', 'bg' => '#f1f5f9'];
                            $persen = $totalStatus > 0 ? round(($sd['jumlah'] / $totalStatus) * 100) : 0;
                            ?>
                            <div style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:0.5rem;background:var(--admin-surface-low);">
                                <div style="width:2.25rem;height:2.25rem;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;background:<?= $si['bg'] ?>;flex-shrink:0;">
                                    <span class="material-symbols-outlined" style="font-size:1.1rem;color:<?= $si['color'] ?>;"><?= $si['icon'] ?></span>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:0.25rem;">
                                        <p style="font-size:0.75rem;font-weight:600;margin:0;color:var(--admin-on-surface);"><?= esc($sd['status_pesanan']) ?></p>
                                        <span style="font-size:0.7rem;font-weight:800;color:<?= $si['color'] ?>;"><?= $sd['jumlah'] ?></span>
                                    </div>
                                    <div style="width:100%;height:4px;background:var(--admin-surface-container);border-radius:999px;overflow:hidden;">
                                        <div style="width:<?= $persen ?>%;height:100%;background:<?= $si['color'] ?>;border-radius:999px;transition:width 0.6s ease;"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align:center;padding:2rem 0;flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                            <span class="material-symbols-outlined mb-2" style="font-size:2.5rem;color:var(--admin-outline);">bar_chart</span>
                            <p style="color:var(--admin-secondary);font-size:0.82rem;margin:0;">Belum ada data bulan ini</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php elseif ($role === 'Owner'): ?>
    <!-- ═══════════════════════════════════════════════════ -->
    <!--  DASHBOARD OWNER: Keuangan & Performa              -->
    <!-- ═══════════════════════════════════════════════════ -->

    <!-- Metric Cards -->
    <section class="row g-3 mb-4">
        <!-- Omset Bulan Ini -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.08s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon green">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <span class="metric-badge up">Bulan Ini</span>
                </div>
                <p class="metric-label">Omset Bulan Ini</p>
                <h3 class="metric-value" style="font-size:1.45rem;">Rp <?= number_format($omsetBulan, 0, ',', '.') ?></h3>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.14s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon blue">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                    <span class="metric-badge up">Lunas</span>
                </div>
                <p class="metric-label">Total Transaksi</p>
                <h3 class="metric-value"><?= $totalTransaksi ?> <span style="font-size:0.9rem; font-weight:600; color:var(--admin-secondary);">Transaksi</span></h3>
            </div>
        </div>

        <!-- Lapangan Terlaris -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.2s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon amber">
                        <span class="material-symbols-outlined">emoji_events</span>
                    </div>
                    <span class="metric-badge up">Terlaris</span>
                </div>
                <p class="metric-label">Lapangan Terlaris</p>
                <h3 class="metric-value" style="font-size:1.15rem;"><?= esc($lapangTerlaris) ?></h3>
            </div>
        </div>

        <!-- Rata-rata per Transaksi -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.26s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon indigo">
                        <span class="material-symbols-outlined">avg_pace</span>
                    </div>
                    <span class="metric-badge up">Per Trx</span>
                </div>
                <p class="metric-label">Rata-rata / Transaksi</p>
                <h3 class="metric-value" style="font-size:1.35rem;">Rp <?= number_format($rataRata, 0, ',', '.') ?></h3>
            </div>
        </div>
    </section>

    <!-- Dual Section: Grafik Pendapatan + Metode Pembayaran -->
    <section class="row g-4 animate-in" style="animation-delay:.32s;">
        <!-- Grafik Pendapatan Harian -->
        <div class="col-12 col-lg-8">
            <div class="content-card h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="content-card__title">Tren Pendapatan</h4>
                        <p class="content-card__subtitle mb-0">Pendapatan harian 30 hari terakhir</p>
                    </div>
                </div>
                <?php if (!empty($chartLabels)): ?>
                <div class="chart-container">
                    <canvas id="chartPendapatan"></canvas>
                </div>
                <?php else: ?>
                <div class="chart-container" style="display:flex;flex-direction:column;align-items:center;justify-content:center;background:#f8fafc;border-radius:0.75rem;">
                    <span class="material-symbols-outlined mb-2" style="font-size:3rem;color:var(--admin-outline);">monitoring</span>
                    <p style="color:var(--admin-secondary);font-size:0.85rem;font-weight:500;margin:0;">Belum ada data pendapatan</p>
                    <p style="color:var(--admin-outline);font-size:0.72rem;margin:0.25rem 0 0;">Data akan muncul saat ada transaksi</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Distribusi Metode Pembayaran -->
        <div class="col-12 col-lg-4">
            <div class="content-card h-100 d-flex flex-column">
                <h4 class="content-card__title">Metode Pembayaran</h4>
                <p class="content-card__subtitle mb-4">Distribusi bulan ini</p>

                <div class="d-flex flex-column gap-3 flex-grow-1">
                    <?php
                    $metodeIcons = [
                        'Cash'          => ['icon' => 'payments', 'color' => '#059669', 'bg' => '#ecfdf5'],
                        'Transfer Bank' => ['icon' => 'account_balance', 'color' => '#2563eb', 'bg' => '#eff6ff'],
                        'QRIS'          => ['icon' => 'qr_code_2', 'color' => '#7c3aed', 'bg' => '#f5f3ff'],
                        'E-Wallet'      => ['icon' => 'smartphone', 'color' => '#ea580c', 'bg' => '#fff7ed'],
                    ];
                    $totalMetode = array_sum(array_column($metodeDistribusi, 'jumlah'));
                    ?>
                    <?php if (!empty($metodeDistribusi)): ?>
                        <?php foreach ($metodeDistribusi as $md): ?>
                            <?php
                            $mi = $metodeIcons[$md['metode']] ?? ['icon' => 'credit_card', 'color' => '#64748b', 'bg' => '#f1f5f9'];
                            $persen = $totalMetode > 0 ? round(($md['jumlah'] / $totalMetode) * 100) : 0;
                            ?>
                            <div style="display:flex;align-items:center;gap:0.75rem;padding:0.85rem;border-radius:0.625rem;background:var(--admin-surface-low);">
                                <div style="width:2.5rem;height:2.5rem;border-radius:0.625rem;display:flex;align-items:center;justify-content:center;background:<?= $mi['bg'] ?>;flex-shrink:0;">
                                    <span class="material-symbols-outlined" style="font-size:1.2rem;color:<?= $mi['color'] ?>;"><?= $mi['icon'] ?></span>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:0.3rem;">
                                        <p style="font-size:0.8rem;font-weight:700;margin:0;color:var(--admin-on-surface);"><?= esc($md['metode']) ?></p>
                                        <span style="font-size:0.68rem;font-weight:800;color:<?= $mi['color'] ?>;"><?= $persen ?>%</span>
                                    </div>
                                    <div style="display:flex;justify-content:space-between;align-items:center;gap:0.75rem;">
                                        <div style="flex:1;height:5px;background:var(--admin-surface-container);border-radius:999px;overflow:hidden;">
                                            <div style="width:<?= $persen ?>%;height:100%;background:<?= $mi['color'] ?>;border-radius:999px;transition:width 0.6s ease;"></div>
                                        </div>
                                        <span style="font-size:0.65rem;font-weight:600;color:var(--admin-secondary);white-space:nowrap;"><?= $md['jumlah'] ?> trx</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align:center;padding:2rem 0;flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                            <span class="material-symbols-outlined mb-2" style="font-size:2.5rem;color:var(--admin-outline);">pie_chart</span>
                            <p style="color:var(--admin-secondary);font-size:0.82rem;margin:0;">Belum ada data bulan ini</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php endif; ?>

</main>

<!-- Chart.js (hanya dimuat untuk Manajer & Owner yang punya data chart) -->
<?php if (in_array($role, ['Manajer', 'Owner']) && !empty($chartLabels)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('chartPendapatan');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const labels = <?= json_encode($chartLabels) ?>;
    const values = <?= json_encode($chartValues) ?>;

    // Gradient fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(0, 87, 205, 0.18)');
    gradient.addColorStop(1, 'rgba(0, 87, 205, 0.01)');

    const hoverGradient = ctx.createLinearGradient(0, 0, 0, 280);
    hoverGradient.addColorStop(0, 'rgba(0, 87, 205, 0.35)');
    hoverGradient.addColorStop(1, 'rgba(0, 87, 205, 0.05)');

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: values,
                backgroundColor: gradient,
                hoverBackgroundColor: hoverGradient,
                borderColor: '#0d6efd',
                borderWidth: 1.5,
                borderRadius: 6,
                borderSkipped: false,
                maxBarThickness: 32,
                minBarLength: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 800,
                easing: 'easeOutQuart',
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: { family: 'Inter', size: 11, weight: '700' },
                    bodyFont: { family: 'Inter', size: 12, weight: '600' },
                    padding: { top: 10, bottom: 10, left: 14, right: 14 },
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function(items) {
                            return items[0].label;
                        },
                        label: function(item) {
                            return 'Rp ' + item.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Inter', size: 10, weight: '600' },
                        color: '#94a3b8',
                        maxRotation: 45,
                        autoSkip: true,
                        maxTicksLimit: 15,
                    },
                    border: { display: false },
                },
                y: {
                    grid: {
                        color: 'rgba(0,0,0,0.04)',
                        lineWidth: 1,
                    },
                    ticks: {
                        font: { family: 'Inter', size: 10, weight: '600' },
                        color: '#94a3b8',
                        padding: 8,
                        callback: function(val) {
                            if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + 'jt';
                            if (val >= 1000) return 'Rp ' + (val / 1000).toFixed(0) + 'k';
                            return 'Rp ' + val;
                        }
                    },
                    border: { display: false },
                    beginAtZero: true,
                }
            }
        }
    });
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>