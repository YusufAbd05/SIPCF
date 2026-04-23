<?= $this->extend('template/admin/base') ?>
<?= $this->section('title') ?>Kelola Booking<?= $this->endSection() ?>
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
            <h2 class="page-header__title">Kelola Booking</h2>
            <p class="page-header__subtitle">Manajemen data booking lapangan dan penjadwalan</p>
        </div>
        <button class="btn-add-booking" data-bs-toggle="modal" data-bs-target="#addBookingModal">
            <span class="material-symbols-outlined">add_circle</span>
            Tambah Pesanan Walk-in
        </button>
    </div>

    <!-- Stats Row -->
    <div class="stats-row animate-in" style="animation-delay:.06s;">
        <div class="stat-chip">
            <div class="stat-chip__icon blue"><span class="material-symbols-outlined">event_note</span>
            </div>
            <div>
                <p class="stat-chip__label">Total Booking</p>
                <p class="stat-chip__value"><?= $totalBooking ?? 0 ?></p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon green"><span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="stat-chip__label">Lunas</p>
                <p class="stat-chip__value"><?= $lunas ?? 0 ?></p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon amber"><span class="material-symbols-outlined">pending</span></div>
            <div>
                <p class="stat-chip__label">Pending</p>
                <p class="stat-chip__value"><?= $pending ?? 0 ?></p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon red"><span class="material-symbols-outlined">cancel</span></div>
            <div>
                <p class="stat-chip__label">Batal</p>
                <p class="stat-chip__value"><?= $batal ?? 0 ?></p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card animate-in" style="animation-delay:.12s;">
        <div class="px-3 pt-2 pb-2 border-bottom d-flex gap-2"
            style="background:var(--admin-surface-low); overflow-x:auto;">
            <button class="tab-pill active" onclick="filterStatus('all', this)">Semua </button>
            <button class="tab-pill" onclick="filterStatus('Menunggu Verifikasi', this)">Butuh Verifikasi</button>
            <button class="tab-pill" onclick="filterStatus('Selesai', this)">Selesai</button>
            <button class="tab-pill" onclick="filterStatus('Ditolak', this)">Ditolak</button>
        </div>
        <div class="table-toolbar">
            <div class="table-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" id="searchBooking" placeholder="Cari kode booking, nama penyewa..."
                    oninput="searchBookingTable()" />
            </div>
            <div class="d-flex gap-2">
                <button class="table-filter-btn"><span class="material-symbols-outlined">download</span>
                    Export</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Nama Lapang</th>
                        <th>Penyewa</th>
                        <th>Tipe & Tanggal</th>
                        <th>Status</th>
                        <th>Total Tagihan</th>
                        <th>Metode</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="bookingTableBody">
                    <?php if (!empty($bookings)): ?>
                        <?php foreach ($bookings as $booking): ?>
                            <?php
                            // Tentukan warna badge status
                            $statusBadgeClass = match ($booking['status_pesanan']) {
                                'Dikonfirmasi', 'Selesai' => 'text-bg-success',
                                'Menunggu Pembayaran' => 'text-bg-secondary',
                                'Menunggu Verifikasi' => 'text-bg-warning',
                                'Ditolak', 'Dibatalkan' => 'text-bg-danger',
                                default => 'text-bg-light'
                            };

                            // Tentukan warna badge metode
                            $metodeClass = strtolower(str_replace(' ', '', $booking['metode_pembayaran'] ?? 'cash'));
                            if ($metodeClass === 'transferbank')
                                $metodeClass = 'transfer';

                            $isOnline = $booking['tipe_pesanan'] === 'Online';
                            ?>
                            <tr data-status="<?= esc($booking['status_pesanan']) ?>">
                                <td class="td-code"><?= esc($booking['kode_sewa']) ?></td>
                                <td><span class="td-name"><?= esc($booking['nama_lapangan']) ?></span></td>
                                <td>
                                    <div class="fw-bold"><?= esc($booking['nama_penyewa']) ?></div>
                                    <div class="td-secondary">
                                        <?= $booking['user_role'] ?? 'Guest' ?>         <?= !$isOnline ? ' (Walk-in)' : '' ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <span class="badge <?= $isOnline ? 'text-bg-primary' : 'text-bg-secondary' ?>"
                                            style="font-size:0.6rem;">
                                            <?= $isOnline ? 'Online Booking' : 'Walk-in Offline' ?>
                                        </span>
                                    </div>
                                    <div class="td-secondary">
                                        <span class="material-symbols-outlined align-bottom"
                                            style="font-size:0.85rem;">calendar_month</span>
                                        <?= date('d M Y', strtotime($booking['tanggal_main'])) ?>,
                                        <?= substr($booking['jam_mulai'], 0, 5) ?> -
                                        <?= substr($booking['jam_selesai'], 0, 5) ?>
                                    </div>
                                </td>
                                <td><span class="badge <?= $statusBadgeClass ?>"><?= esc($booking['status_pesanan']) ?></span>
                                </td>
                                <td class="td-currency">Rp <?= number_format($booking['total_bayar'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($booking['metode_pembayaran']): ?>
                                        <span
                                            class="badge-method <?= $metodeClass ?>"><?= esc($booking['metode_pembayaran']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align:center;">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <?php if ($booking['status_pesanan'] === 'Selesai'): ?>
                                            <button class="action-btn"
                                                style="background:#e0f2fe; color:#0284c7; border:1px solid #bae6fd;"
                                                title="Detail Keuangan"
                                                onclick="openKeuanganModal(<?= $booking['id_sewa'] ?>, '<?= esc($booking['kode_sewa']) ?>', <?= $booking['total_bayar'] ?>)">
                                                <span class="material-symbols-outlined">receipt_long</span> Rincian
                                            </button>
                                        <?php else: ?>
                                            <?php if ($booking['status_pesanan'] === 'Dikonfirmasi'): ?>
                                                <button class="action-btn"
                                                    style="background:#ecfdf5; color:#059669; border:1px solid #a7f3d0;"
                                                    title="Pelunasan Tagihan"
                                                    onclick="openPelunasanModal(<?= $booking['id_sewa'] ?>, '<?= esc($booking['kode_sewa']) ?>', <?= $booking['total_bayar'] ?>, <?= $booking['jumlah_bayar'] ?? ($booking['total_bayar'] / 2) ?>)">
                                                    <span class="material-symbols-outlined">price_check</span> Selesai
                                                </button>
                                            <?php endif; ?>
                                            <?php if (strtolower($booking['metode_pembayaran']) !== 'cash'): ?>
                                                <button class="action-btn bukti" title="Cek Detail"
                                                    onclick="openBuktiModal('<?= esc($booking['kode_sewa']) ?>', <?= $booking['total_bayar'] ?>, '<?= esc($booking['url_bukti_bayar'] ?? '') ?>', <?= $booking['id_sewa'] ?>, '<?= esc($booking['status_pesanan']) ?>')">
                                                    <span
                                                        class="material-symbols-outlined"><?= $booking['status_pesanan'] === 'Menunggu Verifikasi' ? 'search_check' : 'search' ?></span>
                                                    Cek
                                                </button>
                                            <?php endif; ?>
                                            <button class="action-btn edit" title="Edit Booking"
                                                onclick="openEditBookingModal(<?= $booking['id_sewa'] ?>, '<?= esc($booking['kode_sewa']) ?>', <?= $booking['id_lapang'] ?>, '<?= esc($booking['nama_penyewa']) ?>', '<?= esc($booking['no_hp_penyewa']) ?>', '<?= $booking['tanggal_main'] ?>', '<?= substr($booking['jam_mulai'], 0, 5) ?>', '<?= substr($booking['jam_selesai'], 0, 5) ?>', <?= $booking['durasi_jam'] ?>, <?= $booking['total_bayar'] ?>)">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align:center; padding:2rem;">Belum ada data booking.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span class="table-footer__info">Menampilkan <?= $totalBooking ?> data</span>
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
                    Tambah Booking Lapangan
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
                                <span id="summaryLapang">-</span> — <span id="summaryTanggal">-</span> —
                                <span id="summaryJam">-</span>
                                <small>Pilihan jadwal Anda</small>
                            </div>
                        </div>

                        <form id="formAddBooking" action="<?= base_url('/admin/booking/saveWalkIn') ?>" method="post">
                            <?= csrf_field() ?>
                            <!-- Hidden inputs for data selected from calendar -->
                            <input type="hidden" name="id_lapang" id="inputAddLapangId">
                            <input type="hidden" name="tanggal_main" id="inputAddTanggal">
                            <input type="hidden" name="jam_mulai" id="inputAddJamMulai">
                            <input type="hidden" name="jam_selesai" id="inputAddJamSelesai">
                            <input type="hidden" name="durasi_jam" id="inputAddDurasi" value="1">
                            <input type="hidden" name="total_bayar" id="inputAddTotal">

                            <!-- Informasi Penyewa & Pesanan -->
                            <div class="form-section-title">
                                <span class="material-symbols-outlined">person</span>
                                Informasi Penyewa & Pesanan
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">badge</span> Nama Penyewa
                                    </label>
                                    <input type="text" name="nama_penyewa" class="form-control-custom"
                                        placeholder="Masukkan nama penyewa" required />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">mail</span> Email
                                    </label>
                                    <input type="email" name="email" class="form-control-custom"
                                        placeholder="email@contoh.com" required />
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">call</span> No. HP
                                    </label>
                                    <input type="tel" name="no_hp" class="form-control-custom"
                                        placeholder="08xxxxxxxxxx" required />
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">confirmation_number</span> Tipe Pesanan
                                    </label>
                                    <select class="form-control-custom" name="tipe_pesanan" required>
                                        <option value="Walk-in" selected>Walk-in (Langsung)</option>
                                        <option value="Online">Online Booking</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
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

                            <!-- Pembayaran Dinamis -->
                            <div class="form-section-title">
                                <span class="material-symbols-outlined">payments</span>
                                Detail Pembayaran
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">sell</span> Total Harga Tagihan
                                    </label>
                                    <div class="price-input-wrap">
                                        <span class="prefix">Rp</span>
                                        <input type="number" class="form-control-custom" id="addTotalDisplay"
                                            placeholder="Terhitung otomatis" readonly
                                            style="background:var(--admin-surface-low);" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">account_balance_wallet</span> Uang Masuk
                                        / DP
                                    </label>
                                    <div class="price-input-wrap">
                                        <span class="prefix">Rp</span>
                                        <input type="number" name="jumlah_bayar" id="addUangMasuk"
                                            class="form-control-custom" placeholder="Nominal dibayar" required />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">credit_card</span> Metode
                                    </label>
                                    <select name="metode" class="form-control-custom" required>
                                        <option value="Cash" selected>Cash</option>
                                        <option value="Transfer Bank">Transfer Bank</option>
                                        <option value="QRIS">QRIS</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formAddBooking" class="btn-modal-save">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Pesanan Walk-in
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ===== MODAL: EDIT BOOKING (Two-Panel) ===== -->
<div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookingLabel">
                    <span class="material-symbols-outlined">edit</span>
                    Edit Booking — <span style="color:var(--admin-primary)">BK-20260411-001</span>
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
                        <div class="adm-cal" id="editCal">
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
                        <div id="editLapangCards">
                            <div class="no-selection-placeholder">
                                <span class="material-symbols-outlined">touch_app</span>
                                <p>Pilih tanggal di kalender untuk melihat jadwal tersedia</p>
                            </div>
                        </div>
                    </div>

                    <!-- ===== RIGHT PANEL: Form Inputs ===== -->
                    <div class="add-booking-right">
                        <form id="formEditBooking" action="<?= base_url('/admin/booking/update') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_sewa" id="editIdSewa">
                            <!-- Hidden inputs for data selected from calendar -->
                            <input type="hidden" name="id_lapang" id="editInputLapangId">
                            <input type="hidden" name="tanggal_main" id="editInputTanggal">
                            <input type="hidden" name="jam_mulai" id="editInputJamMulai">
                            <input type="hidden" name="jam_selesai" id="editInputJamSelesai">
                            <input type="hidden" name="durasi_jam" id="editInputDurasi" value="1">
                            <input type="hidden" name="total_bayar" id="editInputTotal">

                            <!-- Jadwal Saat Ini (Readonly) -->
                            <div class="form-section-title" style="margin-top:0;">
                                <span class="material-symbols-outlined">history</span>
                                Jadwal Saat Ini
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">stadium</span> Lapang
                                    </label>
                                    <input type="text" class="form-control-custom" id="editCurrentLapang" readonly
                                        style="background:var(--admin-surface-low);cursor:not-allowed;" />
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">event</span> Tanggal
                                    </label>
                                    <input type="text" class="form-control-custom" id="editCurrentTanggal" readonly
                                        style="background:var(--admin-surface-low);cursor:not-allowed;" />
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">schedule</span> Jam
                                    </label>
                                    <input type="text" class="form-control-custom" id="editCurrentJam" readonly
                                        style="background:var(--admin-surface-low);cursor:not-allowed;" />
                                </div>
                            </div>

                            <!-- Jadwal Baru (dari Kalender) -->
                            <div class="booking-summary-chip" id="editBookingSummary"
                                style="display:none; margin-bottom:1rem;">
                                <span class="material-symbols-outlined">swap_horiz</span>
                                <div class="booking-summary-chip__text">
                                    <span id="editSummaryLapang">-</span> — <span id="editSummaryTanggal">-</span> —
                                    <span id="editSummaryJam">-</span>
                                    <small>Jadwal baru yang dipilih</small>
                                </div>
                            </div>

                            <!-- Informasi Penyewa & Pesanan -->
                            <div class="form-section-title">
                                <span class="material-symbols-outlined">person</span>
                                Informasi Penyewa
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">tag</span> Kode Booking
                                    </label>
                                    <input type="text" class="form-control-custom" id="editKodeSewa" readonly
                                        style="background:var(--admin-surface-low);cursor:not-allowed;" />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">badge</span> Nama Penyewa
                                    </label>
                                    <input type="text" name="nama_penyewa" id="editNamaPenyewa"
                                        class="form-control-custom" placeholder="Masukkan nama penyewa" required />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">call</span> No. HP
                                    </label>
                                    <input type="tel" name="no_hp" id="editNoHp" class="form-control-custom"
                                        placeholder="08xxxxxxxxxx" required />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">timer</span> Durasi Bermain
                                    </label>
                                    <select class="form-control-custom" id="editDurasi" required>
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
                                Detail Pembayaran
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">sell</span> Total Harga Tagihan
                                    </label>
                                    <div class="price-input-wrap">
                                        <span class="prefix">Rp</span>
                                        <input type="number" class="form-control-custom" id="editTotalDisplay"
                                            placeholder="Terhitung otomatis" readonly
                                            style="background:var(--admin-surface-low);" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">account_balance_wallet</span> Uang Masuk
                                        / DP
                                    </label>
                                    <div class="price-input-wrap">
                                        <span class="prefix">Rp</span>
                                        <input type="number" id="editUangMasuk" class="form-control-custom"
                                            placeholder="Nominal dibayar" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">credit_card</span> Metode
                                    </label>
                                    <select class="form-control-custom">
                                        <option value="Cash" selected>Cash</option>
                                        <option value="Transfer Bank">Transfer Bank</option>
                                        <option value="QRIS">QRIS</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditBooking" class="btn-modal-save">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL: VERIFIKASI BUKTI BAYAR ===== -->
<div class="modal fade" id="buktiBayarModal" tabindex="-1" aria-labelledby="buktiBayarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buktiBayarLabel">
                    <span class="material-symbols-outlined">receipt_long</span>
                    Verifikasi Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center" style="background:#f8fafc;">
                <div class="p-3 border-bottom text-start">
                    <h6 class="mb-1" style="color:var(--admin-primary); font-weight:700;">Kode:
                        <span id="verifikasiKode"></span>
                    </h6>
                    <p class="mb-0 text-muted" style="font-size:0.8rem;">Cek kesesuaian nominal tagihan
                        (<b id="verifikasiNominal"></b>) sebelum klik Terima.</p>
                </div>
                <div class="bukti-lightbox" id="buktiContainer" style="padding:1.5rem;">
                    <!-- Dummy Image for Transfer -->
                    <div
                        style="background:#fff; padding:0.5rem; border-radius:0.75rem; border:1px solid #e2e8f0; display:inline-block; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);">
                        <img src="https://via.placeholder.com/300x500/eff6ff/0057cd?text=Struk+Transfer+Valid"
                            alt="Bukti Transfer" style="border-radius:0.5rem; max-height:400px; display:block;">
                    </div>
                </div>
            </div>
            <div class="modal-footer"
                style="justify-content: space-between; background:#fff; border-radius:0 0 1rem 1rem;">
                <form action="<?= base_url('/admin/booking/verifikasi') ?>" method="post" class="w-100">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_sewa" id="verifikasiIdSewa">
                    <div class="d-flex w-100 flex-column text-start">
                        <div class="collapse w-100 mb-3" id="collapseTolakPesanan">
                            <div class="card card-body p-3"
                                style="background:var(--admin-surface-low); border:1px solid #fca5a5;">
                                <label class="form-label mb-2 text-danger"
                                    style="font-size:0.75rem; font-weight:700;">Alasan Penolakan (Akan dikirim
                                    ke pengguna via Notifikasi/Email):</label>
                                <textarea name="alasan_penolakan" class="form-control" rows="2"
                                    placeholder="Contoh: Lampiran bukti transfer tidak terbaca / Nominal transfer kurang valid..."
                                    style="font-size:0.8rem; border-color:#fca5a5; resize:none;"></textarea>
                                <div class="mt-2 text-end">
                                    <button type="submit" name="action" value="tolak"
                                        class="btn btn-danger px-3 py-1 fw-bold"
                                        style="font-size:0.75rem; border-radius:0.4rem;">Kirim & Batalkan
                                        Pesanan</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between w-100 align-items-center">
                            <button type="button" class="btn btn-outline-danger d-flex align-items-center gap-1"
                                data-bs-toggle="collapse" data-bs-target="#collapseTolakPesanan"
                                style="font-size:0.85rem; font-weight:600;">
                                <span class="material-symbols-outlined" style="font-size:1.1rem;">cancel</span>
                                Tolak
                                Pesanan
                            </button>
                            <button type="submit" name="action" value="terima"
                                class="btn btn-success d-flex align-items-center gap-1"
                                style="font-size:0.85rem; font-weight:600; background:#059669; border:none; padding:0.5rem 1rem;">
                                <span class="material-symbols-outlined" style="font-size:1.1rem;">check_circle</span>
                                Terima & Konfirmasi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL: PELUNASAN ===== -->
<div class="modal fade" id="pelunasanModal" tabindex="-1" aria-labelledby="pelunasanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <h5 class="modal-title" id="pelunasanLabel">
                    <span class="material-symbols-outlined" style="color:#059669;">price_check</span>
                    Pelunasan Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h6
                        style="color:var(--admin-secondary); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">
                        Kode Booking</h6>
                    <h4 id="pelunasanKodeSewa" style="color:var(--admin-primary); font-weight:800; margin:0;">-</h4>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span style="color:var(--admin-secondary);">Total Tagihan</span>
                    <span id="pelunasanTotalTagihan" style="font-weight:600;">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                    <span style="color:var(--admin-secondary);">Telah Dibayar (DP)</span>
                    <span id="pelunasanDP" style="font-weight:600; color:#059669;">- Rp 0</span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span style="font-weight:700; font-size:1.1rem;">Sisa Tagihan</span>
                    <span id="pelunasanSisa" style="font-weight:800; font-size:1.1rem; color:#dc2626;">Rp 0</span>
                </div>

                <form id="formPelunasan" action="<?= base_url('/admin/booking/savePelunasan') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_sewa" id="pelunasanIdSewa">
                    <div class="mb-3">
                        <label class="form-label-custom">Nominal Pelunasan</label>
                        <div class="price-input-wrap">
                            <span class="prefix">Rp</span>
                            <input type="number" name="jumlah_bayar" id="pelunasanNominal" class="form-control-custom"
                                required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Metode Pembayaran</label>
                        <select name="metode" class="form-control-custom" required>
                            <option value="Cash">Cash</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0;">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formPelunasan" class="btn-modal-save" style="background:#059669;">
                    <span class="material-symbols-outlined">done_all</span>
                    Selesaikan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL: KEUANGAN ===== -->
<div class="modal fade" id="keuanganModal" tabindex="-1" aria-labelledby="keuanganLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <h5 class="modal-title" id="keuanganLabel">
                    <span class="material-symbols-outlined" style="color:#0284c7;">receipt_long</span>
                    Rincian Keuangan Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h6
                        style="color:var(--admin-secondary); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">
                        Kode Booking</h6>
                    <h4 id="keuanganKodeSewa" style="color:var(--admin-primary); font-weight:800; margin:0;">-</h4>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span style="color:var(--admin-secondary);">Total Harga Sewa</span>
                    <span id="keuanganTotalHarga" style="font-weight:600;">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color:var(--admin-secondary);">Pembayaran Awal (DP / Lunas)</span>
                    <span id="keuanganDP" style="font-weight:600; color:#059669;">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                    <span style="color:var(--admin-secondary);">Pelunasan Akhir</span>
                    <span id="keuanganPelunasan" style="font-weight:600; color:#059669;">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="font-weight:700; font-size:1.1rem;">Total Dibayar</span>
                    <span id="keuanganTotalDibayar" style="font-weight:800; font-size:1.1rem; color:#059669;">Rp
                        0</span>
                </div>

                <!-- Loading Spinner for AJAX -->
                <div id="keuanganLoading" class="text-center mt-3" style="display:none;">
                    <div class="spinner-border text-primary" role="status" style="width: 1.5rem; height: 1.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0;">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal"
                    style="width:100%;">Tutup</button>
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
            <?php foreach ($lapangs as $lapang): ?>
                                                                { id: <?= $lapang['id_lapang'] ?>, name: '<?= esc($lapang['nama_lapangan']) ?>' },
            <?php endforeach; ?>
        ];

        const API_BOOKED = '<?= base_url("/admin/booking/getBookedSlots") ?>';
        const API_TARIF = '<?= base_url("/admin/booking/getTarif") ?>';

        /* ===== STATE ===== */
        let calYear, calMonth, calSelectedDay;
        let selectedLapangId = null;
        let selectedTimeSlot = null;  // now stores just the start hour, e.g. "08:00"
        let bookedSlotsData = {};     // fetched from API: { lapangId: ["08:00","09:00",...] }
        let tarifCache = {};          // cached tarif: { lapangId: { tarifs: [...], kategori_hari: "..." } }

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
            bookedSlotsData = {};
            tarifCache = {};
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
                btn.addEventListener('click', async () => {
                    calSelectedDay = parseInt(btn.dataset.day);
                    selectedLapangId = null;
                    selectedTimeSlot = null;
                    renderCalendar();

                    // Fetch booked slots from API
                    const m = String(calMonth + 1).padStart(2, '0');
                    const d = String(calSelectedDay).padStart(2, '0');
                    const tanggal = `${calYear}-${m}-${d}`;

                    try {
                        lapangCards.innerHTML = `<div class="no-selection-placeholder"><span class="material-symbols-outlined">hourglass_empty</span><p>Memuat jadwal...</p></div>`;
                        const res = await fetch(`${API_BOOKED}?tanggal=${tanggal}`);
                        bookedSlotsData = await res.json();
                    } catch (e) {
                        bookedSlotsData = {};
                    }

                    // Fetch tarif for each lapang
                    tarifCache = {};
                    for (const lap of LAPANGS) {
                        try {
                            const res = await fetch(`${API_TARIF}?id_lapang=${lap.id}&tanggal=${tanggal}`);
                            tarifCache[lap.id] = await res.json();
                        } catch (e) {
                            tarifCache[lap.id] = { tarifs: [], kategori_hari: 'Weekday' };
                        }
                    }

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

        /**
         * Cek apakah sebuah slot awal bisa menampung durasi yang dipilih.
         * Slot dianggap tidak bisa jika salah satu jam di range-nya sudah terbooking
         * atau melewati batas waktu operasional (24:00).
         */
        function canStartAt(startHour, durasi, bookedHours) {
            for (let i = 0; i < durasi; i++) {
                const h = startHour + i;
                if (h >= 24) return false; // melewati batas operasional
                const hourStr = String(h).padStart(2, '0') + ':00';
                if (bookedHours.includes(hourStr)) return false;
            }
            return true;
        }

        function renderLapangCards() {
            if (!calSelectedDay) { renderLapangPlaceholder(); return; }
            const durasi = parseInt(document.getElementById('addDurasi').value);

            let html = '';
            LAPANGS.forEach(lap => {
                const isActive = selectedLapangId === lap.id;
                const bookedHours = bookedSlotsData[lap.id] || [];
                const tarifInfo = tarifCache[lap.id];

                // Cari harga per jam untuk lapang ini
                let hargaPerJam = 0;
                if (tarifInfo && tarifInfo.tarifs && tarifInfo.tarifs.length > 0) {
                    hargaPerJam = parseInt(tarifInfo.tarifs[0].harga_umum);
                }
                const hargaLabel = hargaPerJam > 0 ? `Rp ${hargaPerJam.toLocaleString('id-ID')}/jam` : '';

                html += `
                <div class="adm-lapang-card ${isActive ? 'active' : ''}" data-lapang-id="${lap.id}">
                    <div class="adm-lapang-card__header">
                        <span class="material-symbols-outlined">stadium</span>
                        <span>${lap.name}</span>
                        ${hargaLabel ? `<span style="margin-left:auto; font-size:0.72rem; color:#059669; font-weight:700;">${hargaLabel}</span>` : ''}
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
                const bookedHours = bookedSlotsData[lap.id] || [];

                let shtml = '';
                TIME_SLOTS.forEach(slot => {
                    const isBooked = bookedHours.includes(slot.start);
                    const isSel = selectedLapangId === lap.id && selectedTimeSlot === slot.start;
                    let cls = 'adm-slot';
                    if (isBooked) cls += ' disabled booked';
                    if (isSel) cls += ' selected';

                    let title = '';
                    if (isBooked) title = 'Sudah dipesan';

                    shtml += `<button type="button" class="${cls}" data-slot="${slot.start}" data-lapang="${lap.id}" ${isBooked ? 'disabled' : ''} title="${title}">${slot.start}</button>`;
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

        /**
         * Cari harga per jam berdasarkan tarif yang berlaku untuk jam tertentu.
         * Tarif bisa berbeda per blok jam (misal pagi vs malam).
         */
        function getHargaForHour(lapangId, hourStr) {
            const tarifInfo = tarifCache[lapangId];
            if (!tarifInfo || !tarifInfo.tarifs || tarifInfo.tarifs.length === 0) return 0;

            const hour = parseInt(hourStr.split(':')[0]);

            // Cari tarif yang jam_mulai <= hour < jam_selesai
            for (const t of tarifInfo.tarifs) {
                const tStart = parseInt(t.jam_mulai.substring(0, 2));
                const tEnd = parseInt(t.jam_selesai.substring(0, 2));
                if (hour >= tStart && hour < tEnd) {
                    return parseInt(t.harga_umum);
                }
            }

            // Fallback: gunakan tarif pertama
            return parseInt(tarifInfo.tarifs[0].harga_umum);
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

                // Form hidden inputs
                document.getElementById('inputAddLapangId').value = selectedLapangId;

                // Format tanggal YYYY-MM-DD
                const m = String(calMonth + 1).padStart(2, '0');
                const d = String(calSelectedDay).padStart(2, '0');
                document.getElementById('inputAddTanggal').value = `${calYear}-${m}-${d}`;

                // Jam Mulai
                document.getElementById('inputAddJamMulai').value = selectedTimeSlot;

                // Durasi & Selesai
                const durasi = parseInt(document.getElementById('addDurasi').value);
                const startH = parseInt(selectedTimeSlot.split(':')[0]);
                const endH = startH + durasi;
                const endHour = String(endH).padStart(2, '0') + ':00';
                document.getElementById('inputAddJamSelesai').value = endHour;

                sJam.textContent = `${selectedTimeSlot} - ${endHour}`;

                // Hitung total bayar berdasarkan tarif per jam dari DB
                let total = 0;
                for (let i = 0; i < durasi; i++) {
                    const hStr = String(startH + i).padStart(2, '0') + ':00';
                    total += getHargaForHour(selectedLapangId, hStr);
                }

                document.getElementById('inputAddTotal').value = total;
                const totalDisplay = document.getElementById('addTotalDisplay');
                if (totalDisplay) totalDisplay.value = total;

                const uangMasukInput = document.getElementById('addUangMasuk');
                if (uangMasukInput && (!uangMasukInput.dataset.modified || uangMasukInput.value === '')) {
                    uangMasukInput.value = total;
                }

                summary.style.display = 'flex';
            } else {
                summary.style.display = 'none';
            }
        }

        document.getElementById('addDurasi').addEventListener('change', function () {
            document.getElementById('inputAddDurasi').value = this.value;
            // Re-render cards to update slot availability based on new duration
            renderLapangCards();
            updateSummary();
        });

        // Track manual input on Uang Masuk to prevent auto-overwrite
        const uangMasukInput = document.getElementById('addUangMasuk');
        if (uangMasukInput) {
            uangMasukInput.addEventListener('input', function () {
                this.dataset.modified = 'true';
            });
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

        /* ===== UPLOAD BUKTI BAYAR (placeholder — will be wired when backend ready) ===== */

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
            document.getElementById('addBookingSummary').style.display = 'none';
        });
    })();

    /* ===== TAB FILTER BY STATUS ===== */
    function filterStatus(status, btn) {
        const rows = document.querySelectorAll('#bookingTableBody tr');
        rows.forEach(row => {
            if (status === 'all') {
                row.style.display = '';
            } else {
                row.style.display = row.dataset.status === status ? '' : 'none';
            }
        });
        // Update active tab
        document.querySelectorAll('.tab-pill').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
    }

    /* ===== SEARCH TABLE ===== */
    function searchBookingTable() {
        const query = document.getElementById('searchBooking').value.toLowerCase();
        const rows = document.querySelectorAll('#bookingTableBody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }

    /* ===== AUTO-DISMISS TOAST ===== */
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
    });

    /* ===== EDIT BOOKING CALENDAR (mirrors Add logic) ===== */
    (function () {
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
            <?php foreach ($lapangs as $lapang): ?>
                                    { id: <?= $lapang['id_lapang'] ?>, name: '<?= esc($lapang['nama_lapangan']) ?>' },
            <?php endforeach; ?>
        ];

        const API_BOOKED = '<?= base_url("/admin/booking/getBookedSlots") ?>';
        const API_TARIF = '<?= base_url("/admin/booking/getTarif") ?>';

        let ecYear, ecMonth, ecSelectedDay;
        let ecSelectedLapangId = null;
        let ecSelectedTimeSlot = null;
        let ecBookedSlotsData = {};
        let ecTarifCache = {};
        let ecExcludeIdSewa = null; // to exclude current booking's own slots from "booked"

        const ecRoot = document.getElementById('editCal');
        const ecTitle = ecRoot.querySelector('.adm-cal__title');
        const ecGrid = ecRoot.querySelector('.adm-cal__grid');
        const ecInfo = ecRoot.querySelector('.adm-cal__selected-info');
        const ecInfoText = ecRoot.querySelector('.adm-cal__selected-text');
        const ecLapangCards = document.getElementById('editLapangCards');

        function ecInitCalendar(year, month, day) {
            ecYear = year;
            ecMonth = month;
            ecSelectedDay = day;
            ecBookedSlotsData = {};
            ecTarifCache = {};
            ecRenderCalendar();
            if (day) {
                // Auto-load slots for the pre-selected day
                ecLoadSlots();
            } else {
                ecRenderPlaceholder();
            }
        }

        function ecRenderCalendar() {
            ecTitle.textContent = `${MONTHS[ecMonth]} ${ecYear}`;
            const firstDow = new Date(ecYear, ecMonth, 1).getDay();
            const totalDays = new Date(ecYear, ecMonth + 1, 0).getDate();
            const today = new Date();

            let html = DAYS.map(d => `<span class="adm-cal__dow">${d}</span>`).join('');
            for (let i = 0; i < firstDow; i++) html += '<span class="adm-cal__day empty"></span>';

            for (let d = 1; d <= totalDays; d++) {
                const isToday = d === today.getDate() && ecMonth === today.getMonth() && ecYear === today.getFullYear();
                const isSel = d === ecSelectedDay;
                const dow = new Date(ecYear, ecMonth, d).getDay();
                let cls = 'adm-cal__day';
                if (isToday) cls += ' today';
                if (isSel) cls += ' selected';
                if (dow === 0) cls += ' empty';
                html += `<button type="button" class="${cls}" data-day="${d}" ${dow === 0 ? 'disabled' : ''}>${d}</button>`;
            }

            ecGrid.innerHTML = html;

            ecGrid.querySelectorAll('.adm-cal__day:not(.empty)').forEach(btn => {
                btn.addEventListener('click', async () => {
                    ecSelectedDay = parseInt(btn.dataset.day);
                    ecSelectedLapangId = null;
                    ecSelectedTimeSlot = null;
                    ecRenderCalendar();
                    await ecLoadSlots();
                    ecUpdateSummary();
                });
            });

            if (ecSelectedDay) {
                const d = new Date(ecYear, ecMonth, ecSelectedDay);
                ecInfoText.textContent = `${DAY_NAMES[d.getDay()]}, ${ecSelectedDay} ${MONTHS[ecMonth]} ${ecYear}`;
                ecInfo.style.display = 'flex';
            } else {
                ecInfo.style.display = 'none';
            }
        }

        async function ecLoadSlots() {
            const m = String(ecMonth + 1).padStart(2, '0');
            const d = String(ecSelectedDay).padStart(2, '0');
            const tanggal = `${ecYear}-${m}-${d}`;

            try {
                ecLapangCards.innerHTML = `<div class="no-selection-placeholder"><span class="material-symbols-outlined">hourglass_empty</span><p>Memuat jadwal...</p></div>`;
                const res = await fetch(`${API_BOOKED}?tanggal=${tanggal}`);
                ecBookedSlotsData = await res.json();
            } catch (e) {
                ecBookedSlotsData = {};
            }

            ecTarifCache = {};
            for (const lap of LAPANGS) {
                try {
                    const res = await fetch(`${API_TARIF}?id_lapang=${lap.id}&tanggal=${tanggal}`);
                    ecTarifCache[lap.id] = await res.json();
                } catch (e) {
                    ecTarifCache[lap.id] = { tarifs: [], kategori_hari: 'Weekday' };
                }
            }

            ecRenderLapangCards();
            ecUpdateSummary();
        }

        function ecRenderPlaceholder() {
            ecLapangCards.innerHTML = `
            <div class="no-selection-placeholder">
                <span class="material-symbols-outlined">touch_app</span>
                <p>Pilih tanggal di kalender untuk melihat jadwal tersedia</p>
            </div>`;
        }

        function ecCanStartAt(startHour, durasi, bookedHours) {
            for (let i = 0; i < durasi; i++) {
                const h = startHour + i;
                if (h >= 24) return false;
                const hourStr = String(h).padStart(2, '0') + ':00';
                if (bookedHours.includes(hourStr)) return false;
            }
            return true;
        }

        function ecRenderLapangCards() {
            if (!ecSelectedDay) { ecRenderPlaceholder(); return; }
            const durasi = parseInt(document.getElementById('editDurasi').value);

            let html = '';
            LAPANGS.forEach(lap => {
                const isActive = ecSelectedLapangId === lap.id;
                const bookedHours = ecBookedSlotsData[lap.id] || [];
                const tarifInfo = ecTarifCache[lap.id];

                let hargaPerJam = 0;
                if (tarifInfo && tarifInfo.tarifs && tarifInfo.tarifs.length > 0) {
                    hargaPerJam = parseInt(tarifInfo.tarifs[0].harga_umum);
                }
                const hargaLabel = hargaPerJam > 0 ? `Rp ${hargaPerJam.toLocaleString('id-ID')}/jam` : '';

                html += `
                <div class="adm-lapang-card ${isActive ? 'active' : ''}" data-lapang-id="${lap.id}">
                    <div class="adm-lapang-card__header">
                        <span class="material-symbols-outlined">stadium</span>
                        <span>${lap.name}</span>
                        ${hargaLabel ? `<span style="margin-left:auto; font-size:0.72rem; color:#059669; font-weight:700;">${hargaLabel}</span>` : ''}
                    </div>
                    <div class="adm-lapang-card__body">
                        <div class="adm-slot-grid" id="editSlots-${lap.id}"></div>
                    </div>
                </div>`;
            });
            ecLapangCards.innerHTML = html;

            LAPANGS.forEach(lap => {
                const grid = document.getElementById(`editSlots-${lap.id}`);
                const bookedHours = ecBookedSlotsData[lap.id] || [];

                let shtml = '';
                TIME_SLOTS.forEach(slot => {
                    const isBooked = bookedHours.includes(slot.start);
                    const isSel = ecSelectedLapangId === lap.id && ecSelectedTimeSlot === slot.start;
                    let cls = 'adm-slot';
                    if (isBooked) cls += ' disabled booked';
                    if (isSel) cls += ' selected';

                    let title = '';
                    if (isBooked) title = 'Sudah dipesan';

                    shtml += `<button type="button" class="${cls}" data-slot="${slot.start}" data-lapang="${lap.id}" ${isBooked ? 'disabled' : ''} title="${title}">${slot.start}</button>`;
                });
                grid.innerHTML = shtml;

                grid.querySelectorAll('.adm-slot:not(.disabled)').forEach(btn => {
                    btn.addEventListener('click', () => {
                        ecSelectedLapangId = parseInt(btn.dataset.lapang);
                        ecSelectedTimeSlot = btn.dataset.slot;
                        ecRenderLapangCards();
                        ecUpdateSummary();
                    });
                });
            });
        }

        function ecGetHargaForHour(lapangId, hourStr) {
            const tarifInfo = ecTarifCache[lapangId];
            if (!tarifInfo || !tarifInfo.tarifs || tarifInfo.tarifs.length === 0) return 0;
            const hour = parseInt(hourStr.split(':')[0]);
            for (const t of tarifInfo.tarifs) {
                const tStart = parseInt(t.jam_mulai.substring(0, 2));
                const tEnd = parseInt(t.jam_selesai.substring(0, 2));
                if (hour >= tStart && hour < tEnd) return parseInt(t.harga_umum);
            }
            return parseInt(tarifInfo.tarifs[0].harga_umum);
        }

        function ecUpdateSummary() {
            const summary = document.getElementById('editBookingSummary');
            const sLapang = document.getElementById('editSummaryLapang');
            const sTanggal = document.getElementById('editSummaryTanggal');
            const sJam = document.getElementById('editSummaryJam');

            if (ecSelectedLapangId && ecSelectedTimeSlot && ecSelectedDay) {
                const lap = LAPANGS.find(l => l.id === ecSelectedLapangId);
                sLapang.textContent = lap ? lap.name : '-';
                sTanggal.textContent = `${ecSelectedDay} ${MONTHS[ecMonth]} ${ecYear}`;

                document.getElementById('editInputLapangId').value = ecSelectedLapangId;
                const m = String(ecMonth + 1).padStart(2, '0');
                const d = String(ecSelectedDay).padStart(2, '0');
                document.getElementById('editInputTanggal').value = `${ecYear}-${m}-${d}`;
                document.getElementById('editInputJamMulai').value = ecSelectedTimeSlot;

                const durasi = parseInt(document.getElementById('editDurasi').value);
                const startH = parseInt(ecSelectedTimeSlot.split(':')[0]);
                const endH = startH + durasi;
                const endHour = String(endH).padStart(2, '0') + ':00';
                document.getElementById('editInputJamSelesai').value = endHour;

                sJam.textContent = `${ecSelectedTimeSlot} - ${endHour}`;

                let total = 0;
                for (let i = 0; i < durasi; i++) {
                    const hStr = String(startH + i).padStart(2, '0') + ':00';
                    total += ecGetHargaForHour(ecSelectedLapangId, hStr);
                }
                document.getElementById('editInputTotal').value = total;
                document.getElementById('editTotalDisplay').value = total;
                document.getElementById('editUangMasuk').value = total;

                summary.style.display = 'flex';
            } else {
                summary.style.display = 'none';
            }
        }

        document.getElementById('editDurasi').addEventListener('change', function () {
            document.getElementById('editInputDurasi').value = this.value;
            ecRenderLapangCards();
            ecUpdateSummary();
        });

        ecRoot.querySelectorAll('.adm-cal__nav').forEach(btn => {
            btn.addEventListener('click', () => {
                if (btn.dataset.dir === 'prev') {
                    ecMonth--;
                    if (ecMonth < 0) { ecMonth = 11; ecYear--; }
                } else {
                    ecMonth++;
                    if (ecMonth > 11) { ecMonth = 0; ecYear++; }
                }
                ecSelectedDay = null;
                ecSelectedLapangId = null;
                ecSelectedTimeSlot = null;
                ecRenderCalendar();
                ecRenderPlaceholder();
                ecUpdateSummary();
            });
        });

        // Expose the init function globally so openEditBookingModal can call it
        window._editCalInit = ecInitCalendar;
        window._editCalSetSelection = function (lapangId, timeSlot) {
            ecSelectedLapangId = lapangId;
            ecSelectedTimeSlot = timeSlot;
            ecRenderLapangCards();
            ecUpdateSummary();
        };
    })();

    /* ===== OPEN EDIT BOOKING MODAL ===== */
    function openEditBookingModal(idSewa, kodeSewa, idLapang, namaPenyewa, noHp, tanggal, jamMulai, jamSelesai, durasi, total) {
        document.getElementById('editIdSewa').value = idSewa;
        document.getElementById('editBookingLabel').innerHTML = '<span class="material-symbols-outlined">edit</span> Edit Booking — <span style="color:var(--admin-primary)">' + kodeSewa + '</span>';

        document.getElementById('editKodeSewa').value = kodeSewa;
        document.getElementById('editNamaPenyewa').value = namaPenyewa;
        document.getElementById('editNoHp').value = noHp;
        document.getElementById('editDurasi').value = durasi;
        document.getElementById('editInputDurasi').value = durasi;
        document.getElementById('editTotalDisplay').value = total;
        document.getElementById('editInputTotal').value = total;
        document.getElementById('editUangMasuk').value = total;

        // Set hidden fields
        document.getElementById('editInputLapangId').value = idLapang;
        document.getElementById('editInputTanggal').value = tanggal;
        document.getElementById('editInputJamMulai').value = jamMulai;
        document.getElementById('editInputJamSelesai').value = jamSelesai;

        // Populate "Jadwal Saat Ini" readonly fields
        const MONTHS_ID = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const lapangList = [
            <?php foreach ($lapangs as $lapang): ?>
                                    { id: <?= $lapang['id_lapang'] ?>, name: '<?= esc($lapang['nama_lapangan']) ?>' },
            <?php endforeach; ?>
        ];
        const lapObj = lapangList.find(l => l.id === idLapang);
        document.getElementById('editCurrentLapang').value = lapObj ? lapObj.name : 'Lapang #' + idLapang;

        const dp = tanggal.split('-');
        document.getElementById('editCurrentTanggal').value = parseInt(dp[2]) + ' ' + MONTHS_ID[parseInt(dp[1]) - 1] + ' ' + dp[0];
        document.getElementById('editCurrentJam').value = jamMulai + ' - ' + jamSelesai + ' (' + durasi + ' jam)';

        // Hide the "jadwal baru" summary initially
        document.getElementById('editBookingSummary').style.display = 'none';

        // Parse date to init calendar at the correct month/day
        const year = parseInt(dp[0]);
        const month = parseInt(dp[1]) - 1;
        const day = parseInt(dp[2]);

        // Show modal first, then init calendar (needs DOM visible)
        const modal = new bootstrap.Modal(document.getElementById('editBookingModal'));
        modal.show();

        // Init calendar after modal is visible
        document.getElementById('editBookingModal').addEventListener('shown.bs.modal', function handler() {
            window._editCalInit(year, month, day);
            // After slots load, pre-select the lapang & time
            setTimeout(() => {
                window._editCalSetSelection(idLapang, jamMulai);
            }, 800);
            document.getElementById('editBookingModal').removeEventListener('shown.bs.modal', handler);
        });
    }

    /* ===== OPEN BUKTI BAYAR MODAL ===== */
    function openBuktiModal(kodeSewa, nominal, urlBukti, idSewa, status) {
        document.getElementById('verifikasiIdSewa').value = idSewa;
        document.getElementById('verifikasiKode').textContent = kodeSewa;
        document.getElementById('verifikasiNominal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');

        const container = document.getElementById('buktiContainer');
        if (urlBukti && urlBukti.trim() !== '') {
            container.innerHTML = `
                <div style="text-align:center;">
                    <div style="background:var(--admin-surface-low); border-radius:0.75rem; padding:2rem; display:inline-block;">
                        <span class="material-symbols-outlined" style="font-size:4rem; color:#059669; display:block; margin-bottom:0.75rem;">verified</span>
                        <p style="font-size:0.9rem; font-weight:700; color:var(--admin-on-surface); margin-bottom:0.25rem;">Bukti Pembayaran Tersedia</p>
                        <p style="font-size:0.75rem; color:var(--admin-secondary); margin-bottom:1rem;">${urlBukti}</p>
                        <img src="<?= base_url() ?>/${urlBukti}" style="max-height:400px; border-radius:0.5rem;" onerror="this.src='https://via.placeholder.com/300x500/eff6ff/0057cd?text=Struk+Transfer+Valid'">
                    </div>
                </div>
            `;
        } else {
            container.innerHTML = `
                <div class="no-bukti" style="text-align:center; padding: 2rem;">
                    <span class="material-symbols-outlined" style="font-size:4rem; color:var(--admin-outline);">image_not_supported</span>
                    <p style="font-size:0.85rem; font-weight:bold;">Belum ada bukti pembayaran</p>
                    <p style="font-size:0.72rem; color:var(--admin-outline);">Pembayaran cash atau belum upload</p>
                </div>
            `;
        }

        // Disable buttons if not Menunggu Verifikasi
        const footerBtns = document.querySelectorAll('#buktiBayarModal .modal-footer button');
        if (status !== 'Menunggu Verifikasi') {
            footerBtns.forEach(btn => btn.style.display = 'none');
        } else {
            footerBtns.forEach(btn => btn.style.display = 'flex');
        }

        new bootstrap.Modal(document.getElementById('buktiBayarModal')).show();
    }

    /* ===== OPEN PELUNASAN MODAL ===== */
    function openPelunasanModal(idSewa, kodeSewa, totalTagihan, dpDibayar) {
        document.getElementById('pelunasanIdSewa').value = idSewa;
        document.getElementById('pelunasanKodeSewa').textContent = kodeSewa;

        const sisaTagihan = totalTagihan - dpDibayar;

        document.getElementById('pelunasanTotalTagihan').textContent = 'Rp ' + totalTagihan.toLocaleString('id-ID');
        document.getElementById('pelunasanDP').textContent = '- Rp ' + dpDibayar.toLocaleString('id-ID');
        document.getElementById('pelunasanSisa').textContent = 'Rp ' + sisaTagihan.toLocaleString('id-ID');

        document.getElementById('pelunasanNominal').value = sisaTagihan;

        new bootstrap.Modal(document.getElementById('pelunasanModal')).show();
    }

    /* ===== OPEN KEUANGAN MODAL ===== */
    function openKeuanganModal(idSewa, kodeSewa, totalTagihan) {
        document.getElementById('keuanganKodeSewa').textContent = kodeSewa;
        document.getElementById('keuanganTotalHarga').textContent = 'Rp ' + totalTagihan.toLocaleString('id-ID');

        // Reset Text
        document.getElementById('keuanganDP').textContent = 'Rp 0';
        document.getElementById('keuanganPelunasan').textContent = 'Rp 0';
        document.getElementById('keuanganTotalDibayar').textContent = 'Rp 0';

        // Show loading spinner
        document.getElementById('keuanganLoading').style.display = 'block';

        // Fetch financial details
        fetch(`<?= base_url('/admin/booking/getKeuangan') ?>?id_sewa=${idSewa}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('keuanganLoading').style.display = 'none';

                let dp = 0;
                let pelunasan = 0;

                data.forEach(bayar => {
                    const jumlah = parseInt(bayar.jumlah_bayar);
                    if (bayar.jenis_pembayaran === 'DP' || bayar.jenis_pembayaran === 'Full') {
                        dp += jumlah;
                    } else if (bayar.jenis_pembayaran === 'Pelunasan') {
                        pelunasan += jumlah;
                    }
                });

                document.getElementById('keuanganDP').textContent = 'Rp ' + dp.toLocaleString('id-ID');
                document.getElementById('keuanganPelunasan').textContent = 'Rp ' + pelunasan.toLocaleString('id-ID');
                document.getElementById('keuanganTotalDibayar').textContent = 'Rp ' + (dp + pelunasan).toLocaleString('id-ID');
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('keuanganLoading').style.display = 'none';
            });

        new bootstrap.Modal(document.getElementById('keuanganModal')).show();
    }
</script><?= $this->endSection() ?>