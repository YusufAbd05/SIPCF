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
            Tambah Booking
        </button>
    </div>

    <!-- Stats Row -->
    <div class="stats-row animate-in" style="animation-delay:.06s;">
        <div class="stat-chip">
            <div class="stat-chip__icon blue"><span class="material-symbols-outlined">event_note</span>
            </div>
            <div>
                <p class="stat-chip__label">TOTAL BOOKING</p>
                <p class="stat-chip__value"><?= $totalBooking ?? 0 ?></p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon green"><span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="stat-chip__label">DIKONFIRMASI</p>
                <p class="stat-chip__value"><?= $lunas ?? 0 ?></p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon amber"><span class="material-symbols-outlined">pending_actions</span></div>
            <div>
                <p class="stat-chip__label">BUTUH VERIFIKASI</p>
                <p class="stat-chip__value"><?= $pending ?? 0 ?></p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon red"><span class="material-symbols-outlined">cancel</span></div>
            <div>
                <p class="stat-chip__label">DITOLAK / BATAL</p>
                <p class="stat-chip__value"><?= $batal ?? 0 ?></p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card animate-in" style="animation-delay:.12s;">
        <div class="px-3 pt-2 pb-2 border-bottom d-flex gap-2"
            style="background:var(--admin-surface-low); overflow-x:auto;">
            <button class="tab-pill active" onclick="filterStatus('all', this)">Semua</button>
            <button class="tab-pill" onclick="filterStatus('butuh_dikonfirmasi', this)">Butuh Dikonfirmasi</button>
            <button class="tab-pill" onclick="filterStatus('Dikonfirmasi', this)">Dikonfirmasi</button>
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
                                    <?php
                                        $tipeSewa = $booking['tipe_sewa'] ?? 'Per Jam';
                                        $sewaBadge = match ($tipeSewa) {
                                            'Membership' => ['text-bg-info', 'card_membership'],
                                            'Harian'     => ['text-bg-warning', 'today'],
                                            default      => ['text-bg-light', 'schedule'],
                                        };
                                    ?>
                                    <span class="badge <?= $sewaBadge[0] ?>"
                                        style="font-size:0.6rem; display:inline-flex; align-items:center; gap:0.2rem; margin-top:0.25rem;">
                                        <span class="material-symbols-outlined" style="font-size:0.75rem;"><?= $sewaBadge[1] ?></span>
                                        <?= esc($tipeSewa) ?>
                                    </span>
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
                                    <?php if (in_array($booking['status_pesanan'], ['Selesai', 'Ditolak', 'Dibatalkan'])): ?>
                                        <span class="text-muted" style="font-size:0.8rem;">—</span>
                                    <?php else: ?>
                                    <div class="d-flex gap-1 justify-content-center flex-wrap">
                                        <?php if (in_array($booking['tipe_sewa'] ?? '', ['Membership', 'Harian', 'Per Jam']) || $booking['status_pesanan'] === 'Menunggu Verifikasi'): ?>
                                            <button class="action-btn"
                                                style="background:#e0f2fe; color:#0284c7; border:1px solid #bae6fd;"
                                                title="Detail Jadwal <?= esc($booking['tipe_sewa']) ?>"
                                                onclick="openMembershipDetailModal(<?= $booking['id_sewa'] ?>, '<?= esc($booking['kode_sewa']) ?>', '<?= esc($booking['nama_penyewa']) ?>', '<?= esc($booking['tipe_sewa']) ?>')">
                                                <span class="material-symbols-outlined">event_repeat</span> Jadwal
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($booking['status_pesanan'] === 'Dikonfirmasi'): ?>
                                            <button class="action-btn"
                                                style="background:#ecfdf5; color:#059669; border:1px solid #a7f3d0;"
                                                title="Pelunasan Tagihan"
                                                onclick="openPelunasanModal(<?= $booking['id_sewa'] ?>, '<?= esc($booking['kode_sewa']) ?>', <?= $booking['total_bayar'] ?>, <?= $booking['jumlah_bayar'] ?? ($booking['total_bayar'] / 2) ?>)">
                                                <span class="material-symbols-outlined">price_check</span> Selesai
                                            </button>
                                        <?php endif; ?>
                                        <?php if (strtolower($booking['metode_pembayaran'] ?? 'cash') !== 'cash' && $booking['status_pesanan'] !== 'Dikonfirmasi'): ?>
                                            <button class="action-btn bukti" title="Cek Detail"
                                                onclick="openBuktiModal('<?= esc($booking['kode_sewa']) ?>', <?= $booking['total_bayar'] ?>, '<?= esc($booking['url_bukti_bayar'] ?? '') ?>', <?= $booking['id_sewa'] ?>, '<?= esc($booking['status_pesanan']) ?>', '<?= esc($booking['nama_penyewa']) ?>', '<?= esc($booking['nama_lapangan']) ?>', '<?= $booking['tanggal_main'] ?>', '<?= substr($booking['jam_mulai'], 0, 5) ?>', '<?= substr($booking['jam_selesai'], 0, 5) ?>', <?= $booking['jumlah_bayar'] ?? 0 ?>)">
                                                <span class="material-symbols-outlined"><?= $booking['status_pesanan'] === 'Menunggu Verifikasi' ? 'search_check' : 'search' ?></span>
                                                Cek
                                            </button>
                                        <?php endif; ?>
                                        <button class="action-btn edit" title="Edit Booking"
                                            onclick="openEditBookingModal(<?= $booking['id_sewa'] ?>, '<?= esc($booking['kode_sewa']) ?>', <?= $booking['id_lapang'] ?>, '<?= esc($booking['nama_penyewa']) ?>', '<?= esc($booking['no_hp_penyewa']) ?>', '<?= $booking['tanggal_main'] ?>', '<?= substr($booking['jam_mulai'], 0, 5) ?>', '<?= substr($booking['jam_selesai'], 0, 5) ?>', <?= $booking['durasi_jam'] ?>, <?= $booking['total_bayar'] ?>, '<?= esc($booking['tipe_sewa'] ?? 'Per Jam') ?>')">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                    </div>
                                    <?php endif; ?>
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
                        
                        <!-- Jenis Sewa (Moved above Daftar Jadwal) -->
                        <div class="mb-4">
                            <label class="form-label-custom" style="margin-bottom:.75rem;">
                                <span class="material-symbols-outlined">category</span> Jenis Sewa
                            </label>
                            <div class="sewa-pills">
                                <button type="button" class="sewa-pill sewa-pill--active" data-sewa="Per Jam" onclick="setAdminSewa('Per Jam', this)">
                                    <span class="material-symbols-outlined">schedule</span>
                                    <div>
                                        <span class="sewa-pill__title">Per Jam</span>
                                        <span class="sewa-pill__desc">Sewa per jam</span>
                                    </div>
                                </button>
                                <button type="button" class="sewa-pill" data-sewa="Harian" onclick="setAdminSewa('Harian', this)">
                                    <span class="material-symbols-outlined">today</span>
                                    <div>
                                        <span class="sewa-pill__title">Per Hari</span>
                                        <span class="sewa-pill__desc">Full 1 hari</span>
                                    </div>
                                </button>
                                <button type="button" class="sewa-pill" data-sewa="Membership" onclick="setAdminSewa('Membership', this)">
                                    <span class="material-symbols-outlined">card_membership</span>
                                    <div>
                                        <span class="sewa-pill__title">Membership</span>
                                        <span class="sewa-pill__desc">Diskon 10%</span>
                                    </div>
                                </button>
                            </div>
                            <input type="hidden" name="tipe_sewa" id="inputAddTipeSewa" value="Per Jam" form="formAddBooking">
                            <!-- Sistem otomatis menyimpan pesanan sebagai Walk-in -->
                            <input type="hidden" name="tipe_pesanan" value="Walk-in" form="formAddBooking">
                        </div>

                        <!-- Cart UI -->
                        <div class="form-section-title" style="margin-top:0;">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            Daftar Jadwal
                        </div>
                        <div id="addCartItemsList" style="margin-bottom:1rem; max-height:220px; overflow-y:auto; padding-right:5px;"></div>
                        <div id="addCartEmptyNotice" style="text-align:center; padding:1.5rem; background:var(--admin-surface-low); border:1px dashed #cbd5e1; border-radius:0.75rem; margin-bottom:1rem; color:var(--admin-secondary);">
                            <span class="material-symbols-outlined" style="font-size:2rem; opacity:0.5; margin-bottom:0.5rem; display:block;">event_busy</span>
                            <span style="font-size:0.85rem;">Belum ada jadwal dipilih</span>
                        </div>

                        <form id="formAddBooking" action="<?= base_url('/admin/booking/save') ?>" method="post">
                            <?= csrf_field() ?>
                            <!-- Hidden inputs for data selected from calendar -->
                            <input type="hidden" name="id_lapang" id="inputAddLapangId">
                            <input type="hidden" name="tanggal_main" id="inputAddTanggal">
                            <input type="hidden" name="jam_mulai" id="inputAddJamMulai">
                            <input type="hidden" name="jam_selesai" id="inputAddJamSelesai">
                            <input type="hidden" name="durasi_jam" id="inputAddDurasi" value="1">
                            <input type="hidden" name="total_bayar" id="inputAddTotal">
                            <input type="hidden" name="items_json" id="inputAddItemsJson">

                            <!-- Informasi Penyewa & Pesanan -->
                            <div class="form-section-title">
                                <span class="material-symbols-outlined">person</span>
                                Informasi Penyewa
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
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">call</span> No. HP
                                    </label>
                                    <input type="tel" name="no_hp" class="form-control-custom"
                                        placeholder="08xxxxxxxxxx" required />
                                </div>
                                <div class="col-12 col-md-12">
                                    <!-- Jenis sewa dan Tipe pesanan sudah dipindah ke atas -->
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
                    Simpan Booking
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
                            <input type="hidden" name="items_json" id="editInputItemsJson">

                            <!-- Jenis Sewa -->
                            <div class="mb-4">
                                <label class="form-label-custom" style="margin-bottom:.75rem;">
                                    <span class="material-symbols-outlined">category</span> Jenis Sewa
                                </label>
                                <div class="sewa-pills">
                                    <button type="button" class="sewa-pill" data-sewa="Per Jam" onclick="setAdminEditSewa('Per Jam', this)">
                                        <span class="material-symbols-outlined">schedule</span>
                                        <div>
                                            <span class="sewa-pill__title">Per Jam</span>
                                            <span class="sewa-pill__desc">Sewa per jam</span>
                                        </div>
                                    </button>
                                    <button type="button" class="sewa-pill" data-sewa="Harian" onclick="setAdminEditSewa('Harian', this)">
                                        <span class="material-symbols-outlined">today</span>
                                        <div>
                                            <span class="sewa-pill__title">Per Hari</span>
                                            <span class="sewa-pill__desc">Full 1 hari</span>
                                        </div>
                                    </button>
                                    <button type="button" class="sewa-pill" data-sewa="Membership" onclick="setAdminEditSewa('Membership', this)">
                                        <span class="material-symbols-outlined">card_membership</span>
                                        <div>
                                            <span class="sewa-pill__title">Membership</span>
                                            <span class="sewa-pill__desc">Diskon 10%</span>
                                        </div>
                                    </button>
                                </div>
                                <input type="hidden" name="tipe_sewa" id="editInputTipeSewa" value="Per Jam">
                            </div>

                            <!-- Cart UI (Edit) -->
                            <div class="form-section-title" style="margin-top:0;">
                                <span class="material-symbols-outlined">shopping_cart</span>
                                Daftar Jadwal
                            </div>
                            <div id="editCartItemsList" style="margin-bottom:1rem; max-height:220px; overflow-y:auto; padding-right:5px;"></div>
                            <div id="editCartEmptyNotice" style="text-align:center; padding:1.5rem; background:var(--admin-surface-low); border:1px dashed #cbd5e1; border-radius:0.75rem; margin-bottom:1rem; color:var(--admin-secondary);">
                                <span class="material-symbols-outlined" style="font-size:2rem; opacity:0.5; margin-bottom:0.5rem; display:block;">event_busy</span>
                                <span style="font-size:0.85rem;">Belum ada jadwal dipilih</span>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius:1rem; overflow:hidden;">
            <div class="modal-header"
                style="background:linear-gradient(135deg, #0057cd 0%, #0284c7 100%); border:none; padding:1rem 1.25rem;">
                <h5 class="modal-title" id="buktiBayarLabel"
                    style="color:#fff; font-weight:700; display:flex; align-items:center; gap:0.5rem;">
                    <span class="material-symbols-outlined">receipt_long</span>
                    Verifikasi Pembayaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="background:#f8fafc;">
                <!-- Identitas Booking -->
                <div style="padding:1.25rem; background:#fff; border-bottom:1px solid #e2e8f0;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="material-symbols-outlined"
                            style="color:var(--admin-primary); font-size:1.2rem;">confirmation_number</span>
                        <h6 style="margin:0; font-weight:700; color:var(--admin-primary); font-size:0.9rem;">Identitas
                            Booking</h6>
                    </div>
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <div style="background:#f0f7ff; border-radius:0.5rem; padding:0.6rem 0.75rem;">
                                <small
                                    style="color:var(--admin-secondary); font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.03em;">Kode
                                    Booking</small>
                                <div id="verifikasiKode"
                                    style="font-weight:800; color:var(--admin-primary); font-size:1rem; letter-spacing:0.02em;">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div style="background:#f0fdf4; border-radius:0.5rem; padding:0.6rem 0.75rem;">
                                <small
                                    style="color:var(--admin-secondary); font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.03em;">Nama
                                    Penyewa</small>
                                <div id="verifikasiNamaPenyewa"
                                    style="font-weight:700; color:#15803d; font-size:0.95rem;"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div style="background:#faf5ff; border-radius:0.5rem; padding:0.6rem 0.75rem;">
                                <small
                                    style="color:var(--admin-secondary); font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.03em;">Lapangan</small>
                                <div id="verifikasiLapang" style="font-weight:700; color:#7c3aed; font-size:0.9rem;">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div style="background:#fffbeb; border-radius:0.5rem; padding:0.6rem 0.75rem;">
                                <small
                                    style="color:var(--admin-secondary); font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.03em;">Tanggal
                                    Main</small>
                                <div id="verifikasiTanggal" style="font-weight:700; color:#b45309; font-size:0.9rem;">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div style="background:#fef2f2; border-radius:0.5rem; padding:0.6rem 0.75rem;">
                                <small
                                    style="color:var(--admin-secondary); font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.03em;">Jam
                                    Main</small>
                                <div id="verifikasiJam" style="font-weight:700; color:#dc2626; font-size:0.9rem;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Pembayaran -->
                <div style="padding:1.25rem; background:#fff; border-bottom:1px solid #e2e8f0;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="material-symbols-outlined" style="color:#059669; font-size:1.2rem;">payments</span>
                        <h6 style="margin:0; font-weight:700; color:var(--admin-on-surface); font-size:0.9rem;">
                            Ringkasan Pembayaran</h6>
                    </div>
                    <div style="background:#f8fafc; border-radius:0.75rem; border:1px solid #e2e8f0; overflow:hidden;">
                        <div class="d-flex justify-content-between align-items-center"
                            style="padding:0.65rem 1rem; border-bottom:1px solid #e2e8f0;">
                            <span style="color:var(--admin-secondary); font-size:0.85rem;">Total Harga</span>
                            <span id="verifikasiNominal"
                                style="font-weight:700; font-size:0.95rem; color:var(--admin-on-surface);"></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center"
                            style="padding:0.65rem 1rem; border-bottom:1px solid #e2e8f0;">
                            <span style="color:var(--admin-secondary); font-size:0.85rem;">Sudah Dibayar (Uang
                                Masuk)</span>
                            <span id="verifikasiDibayar"
                                style="font-weight:700; font-size:0.95rem; color:#059669;"></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center"
                            style="padding:0.75rem 1rem; background:#fff7ed;">
                            <span style="font-weight:700; font-size:0.9rem; color:#9a3412;">Sisa Pembayaran</span>
                            <span id="verifikasiSisa" style="font-weight:800; font-size:1.05rem; color:#dc2626;"></span>
                        </div>
                    </div>
                </div>

                <!-- Bukti Pembayaran -->
                <div style="padding:1.25rem;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="material-symbols-outlined" style="color:#0284c7; font-size:1.2rem;">image</span>
                        <h6 style="margin:0; font-weight:700; color:var(--admin-on-surface); font-size:0.9rem;">Bukti
                            Pembayaran</h6>
                    </div>
                    <div class="bukti-lightbox" id="buktiContainer">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>
            <div class="modal-footer"
                style="justify-content: space-between; background:#fff; border-radius:0 0 1rem 1rem; border-top:1px solid #e2e8f0;">
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

<!-- ===== MODAL: KEUANGAN =====
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
<!-- <div id="keuanganLoading" class="text-center mt-3" style="display:none;">
    <div class="spinner-border text-primary" role="status" style="width: 1.5rem; height: 1.5rem;">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
</div>
<!-- <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0;">
    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal" style="width:100%;">Tutup</button>
</div> -->
</div>
</div>
</div>

<!-- ===== MODAL: DETAIL JADWAL MEMBERSHIP ===== -->
<div class="modal fade" id="membershipDetailModal" tabindex="-1" aria-labelledby="membershipDetailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:1rem; overflow:hidden;">
            <div class="modal-header"
                style="background:linear-gradient(135deg, #0891b2 0%, #06b6d4 100%); border:none; padding:1rem 1.25rem;">
                <h5 class="modal-title" id="membershipDetailLabel"
                    style="color:#fff; font-weight:700; display:flex; align-items:center; gap:0.5rem;">
                    <span class="material-symbols-outlined">event_repeat</span>
                    <span id="mbDetailTitle">Detail Jadwal</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="background:#f8fafc;">
                <!-- Booking Info -->
                <div style="padding:1.25rem; background:#fff; border-bottom:1px solid #e2e8f0;">
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <div style="background:#f0f7ff; border-radius:0.5rem; padding:0.6rem 0.75rem;">
                                <small
                                    style="color:var(--admin-secondary); font-size:0.7rem; font-weight:600; text-transform:uppercase;">Kode
                                    Booking</small>
                                <div id="mbDetailKode"
                                    style="font-weight:800; color:var(--admin-primary); font-size:1rem;"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div style="background:#f0fdf4; border-radius:0.5rem; padding:0.6rem 0.75rem;">
                                <small
                                    style="color:var(--admin-secondary); font-size:0.7rem; font-weight:600; text-transform:uppercase;">Penyewa</small>
                                <div id="mbDetailNama" style="font-weight:700; color:#15803d; font-size:0.95rem;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sessions List -->
                <div style="padding:1.25rem;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="material-symbols-outlined"
                            style="color:#0891b2; font-size:1.2rem;">calendar_month</span>
                        <h6 id="mbDetailSubtitle" style="margin:0; font-weight:700; color:var(--admin-on-surface); font-size:0.9rem;">Detail Jadwal</h6>
                    </div>
                    <div id="mbDetailSessions">
                        <div class="text-center py-3">
                            <div class="spinner-border text-primary" role="status" style="width:1.5rem; height:1.5rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background:#fff; border-top:1px solid #e2e8f0;">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal"
                    style="width:100%;">Tutup</button>
            </div>
        </div>
    </div>
</div>

    <script>
        function setAdminSewa(mode, btn) {
            document.getElementById('inputAddTipeSewa').value = mode;
            document.querySelectorAll('.add-booking-right .sewa-pill').forEach(p => {
                p.classList.remove('sewa-pill--active');
            });
            btn.classList.add('sewa-pill--active');
        }

        function setAdminEditSewa(mode, btn) {
            document.getElementById('editInputTipeSewa').value = mode;
            document.querySelectorAll('#formEditBooking .sewa-pill').forEach(p => {
                p.classList.remove('sewa-pill--active');
            });
            btn.classList.add('sewa-pill--active');
        }

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
        let addCartItems = [];        // The cart array
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
            addCartItems = [];
            bookedSlotsData = {};
            tarifCache = {};
            renderCalendar();
            renderLapangPlaceholder();
            renderAddCart();
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
                // Sunday is no longer disabled
                html += `<button type="button" class="${cls}" data-day="${d}">${d}</button>`;
            }

            calGrid.innerHTML = html;

            calGrid.querySelectorAll('.adm-cal__day:not(.empty)').forEach(btn => {
                btn.addEventListener('click', async () => {
                    calSelectedDay = parseInt(btn.dataset.day);
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
                    renderAddCart();
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

            let html = '';
            LAPANGS.forEach(lap => {
                const tarifInfo = tarifCache[lap.id];

                // Cari harga per jam untuk lapang ini
                let hargaPerJam = 0;
                if (tarifInfo && tarifInfo.tarifs && tarifInfo.tarifs.length > 0) {
                    hargaPerJam = parseInt(tarifInfo.tarifs[0].harga_umum);
                }
                const hargaLabel = hargaPerJam > 0 ? `Rp ${hargaPerJam.toLocaleString('id-ID')}/jam` : '';

                html += `
                <div class="adm-lapang-card" data-lapang-id="${lap.id}">
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

            const m = String(calMonth + 1).padStart(2, '0');
            const d = String(calSelectedDay).padStart(2, '0');
            const tanggal = `${calYear}-${m}-${d}`;

            LAPANGS.forEach(lap => {
                const grid = document.getElementById(`addSlots-${lap.id}`);
                const bookedHours = bookedSlotsData[lap.id] || [];

                let shtml = '';
                TIME_SLOTS.forEach(slot => {
                    const isBooked = bookedHours.includes(slot.start);
                    
                    const inCartIndex = addCartItems.findIndex(i => String(i.id_lapang) === String(lap.id) && i.tanggal === tanggal && i.jam_mulai === slot.start);
                    const isSel = inCartIndex !== -1;
                    
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
                        const lapId = parseInt(btn.dataset.lapang);
                        const slotStart = btn.dataset.slot;
                        const lapName = LAPANGS.find(l => l.id === lapId)?.name || '';

                        const inCartIndex = addCartItems.findIndex(i => String(i.id_lapang) === String(lapId) && i.tanggal === tanggal && i.jam_mulai === slotStart);

                        if (inCartIndex !== -1) {
                            addCartItems.splice(inCartIndex, 1);
                        } else {
                            addCartItems.push({
                                id_lapang: lapId,
                                nama_lapang: lapName,
                                tanggal: tanggal,
                                jam_mulai: slotStart,
                                durasi: 1,
                                harga: getHargaForHour(lapId, slotStart)
                            });
                        }
                        
                        renderLapangCards(); 
                        renderAddCart();
                    });
                });
            });
        }

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

                window.removeFromAddCart = function(idx) {
            addCartItems.splice(idx, 1);
            renderLapangCards();
            renderAddCart();
        };

        window.updateAddCartItemDurasi = function(idx, delta) {
            const item = addCartItems[idx];
            const newDurasi = item.durasi + delta;
            if (newDurasi < 1) return;

            if (delta > 0) {
                const checkHour = parseInt(item.jam_mulai) + item.durasi;
                if (checkHour >= 24) return;
                const slotKey = String(checkHour).padStart(2, '0') + ':00';
                
                const booked = bookedSlotsData[item.id_lapang] || [];
                if (booked.includes(slotKey)) {
                    alert('Jam berikutnya sudah terisi. Tidak dapat menambah durasi.');
                    return;
                }
                
                const overlaps = addCartItems.some((other, oIdx) => {
                    if (oIdx === idx) return false;
                    if (String(other.id_lapang) !== String(item.id_lapang) || other.tanggal !== item.tanggal) return false;
                    const otherStart = parseInt(other.jam_mulai);
                    const otherEnd = otherStart + other.durasi;
                    return (checkHour >= otherStart && checkHour < otherEnd);
                });
                if (overlaps) {
                    alert('Jam berikutnya bertabrakan dengan item lain di keranjang Anda.');
                    return;
                }
            }

            item.durasi = newDurasi;
            
            let total = 0;
            const startH = parseInt(item.jam_mulai);
            for (let i = 0; i < item.durasi; i++) {
                const hStr = String(startH + i).padStart(2, '0') + ':00';
                total += getHargaForHour(item.id_lapang, hStr);
            }
            item.harga = total;

            renderLapangCards();
            renderAddCart();
        };

        function renderAddCart() {
            const listEl = document.getElementById('addCartItemsList');
            const emptyEl = document.getElementById('addCartEmptyNotice');
            const totalDisplay = document.getElementById('addTotalDisplay');
            const uangMasukInput = document.getElementById('addUangMasuk');
            const itemsJsonInput = document.getElementById('inputAddItemsJson');

            if (addCartItems.length === 0) {
                listEl.innerHTML = '';
                emptyEl.style.display = 'block';
                itemsJsonInput.value = '';
                document.getElementById('inputAddTotal').value = 0;
                totalDisplay.value = '';
                
                document.getElementById('inputAddLapangId').value = '';
                document.getElementById('inputAddTanggal').value = '';
                document.getElementById('inputAddJamMulai').value = '';
                document.getElementById('inputAddJamSelesai').value = '';
                document.getElementById('inputAddDurasi').value = 1;
                return;
            }

            emptyEl.style.display = 'none';

            let html = '';
            let totalHarga = 0;

            addCartItems.forEach((item, idx) => {
                totalHarga += item.harga;
                const jamEnd = String(parseInt(item.jam_mulai) + item.durasi).padStart(2, '0') + ':00';

                html += `<div style="display:flex;align-items:center;justify-content:space-between;padding:0.6rem 0.75rem;background:var(--admin-surface);border:1px solid #cbd5e1;border-radius:0.65rem;margin-bottom:0.4rem;">
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.82rem;font-weight:700;color:var(--admin-on-surface);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            <span class="material-symbols-outlined" style="font-size:0.85rem;vertical-align:-2px;color:var(--admin-primary);margin-right:2px;">stadium</span>
                            ${item.nama_lapang}
                        </div>
                        <div style="font-size:0.72rem;color:var(--admin-secondary);margin-top:1px;">
                            ${item.tanggal} · ${item.jam_mulai} - ${jamEnd}
                        </div>
                        <div style="font-size:0.75rem;font-weight:700;color:var(--admin-primary);margin-top:2px;">
                            Rp ${item.harga.toLocaleString('id-ID')}
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:0.5rem; margin-right:1rem; background:var(--admin-surface-low); padding:0.25rem 0.5rem; border-radius:0.5rem; border:1px solid #e2e8f0;">
                        <button type="button" onclick="updateAddCartItemDurasi(${idx}, -1)" style="border:none; background:none; cursor:pointer; padding:0; color:var(--admin-on-surface);" ${item.durasi <= 1 ? 'disabled style="opacity:0.3;cursor:not-allowed;"' : ''}>
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">remove</span>
                        </button>
                        <span style="font-size:0.8rem; font-weight:700; width:35px; text-align:center;">${item.durasi} Jam</span>
                        <button type="button" onclick="updateAddCartItemDurasi(${idx}, 1)" style="border:none; background:none; cursor:pointer; padding:0; color:var(--admin-on-surface);">
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">add</span>
                        </button>
                    </div>
                    <button type="button" onclick="removeFromAddCart(${idx})" style="background:none;border:none;cursor:pointer;padding:0.25rem;color:#dc2626;flex-shrink:0;" title="Hapus">
                        <span class="material-symbols-outlined" style="font-size:1.1rem;">delete</span>
                    </button>
                </div>`;
            });

            html += `<div style="display:flex;justify-content:space-between;align-items:center;padding:0.55rem 0.75rem;background:#f0f9ff;border:1px solid #bae6fd;border-radius:0.65rem;margin-top:0.4rem;">
                <span style="font-size:0.82rem;font-weight:700;color:var(--admin-on-surface);">
                    <span class="material-symbols-outlined" style="font-size:0.9rem;vertical-align:-2px;">shopping_cart</span>
                    ${addCartItems.length} item
                </span>
                <span style="font-size:0.9rem;font-weight:800;color:#0284c7;">
                    Rp ${totalHarga.toLocaleString('id-ID')}
                </span>
            </div>`;

            listEl.innerHTML = html;
            itemsJsonInput.value = JSON.stringify(addCartItems);
            document.getElementById('inputAddTotal').value = totalHarga;
            totalDisplay.value = totalHarga;

            if (uangMasukInput && (!uangMasukInput.dataset.modified || uangMasukInput.value === '')) {
                uangMasukInput.value = totalHarga;
            }

            document.getElementById('inputAddLapangId').value = addCartItems[0].id_lapang;
            document.getElementById('inputAddTanggal').value = addCartItems[0].tanggal;
            document.getElementById('inputAddJamMulai').value = addCartItems[0].jam_mulai;
            document.getElementById('inputAddJamSelesai').value = String(parseInt(addCartItems[0].jam_mulai) + addCartItems[0].durasi).padStart(2, '0') + ':00';
            document.getElementById('inputAddDurasi').value = addCartItems.reduce((acc, curr) => acc + curr.durasi, 0);
        }

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
                renderCalendar();
                renderLapangPlaceholder();
                renderAddCart();
            });
        });

        // Init calendar when modal opens
        const addModal = document.getElementById('addBookingModal');
        addModal.addEventListener('shown.bs.modal', () => {
            initCalendar();
        });

        /* ===== RESET ADD MODAL ON CLOSE ===== */
        addModal.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('formAddBooking');
            if (form) form.reset();
            const uangMasukInput = document.getElementById('addUangMasuk');
            if (uangMasukInput) uangMasukInput.dataset.modified = '';
            addCartItems = [];
            renderAddCart();
        });
    })();

    /* ===== TAB FILTER BY STATUS ===== */
    function filterStatus(status, btn) {
        const rows = document.querySelectorAll('#bookingTableBody tr');
        const butuhKonfirmasiStatuses = ['Menunggu', 'Menunggu Pembayaran', 'Menunggu Verifikasi'];
        rows.forEach(row => {
            if (status === 'all') {
                row.style.display = '';
            } else if (status === 'butuh_dikonfirmasi') {
                row.style.display = butuhKonfirmasiStatuses.includes(row.dataset.status) ? '' : 'none';
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
        let editCartItems = [];
        let ecBookedSlotsData = {};
        let ecTarifCache = {};
        let ecExcludeIdSewa = null; // to exclude current booking's own slots from "booked"

        const ecRoot = document.getElementById('editCal');
        const ecTitle = ecRoot.querySelector('.adm-cal__title');
        const ecGrid = ecRoot.querySelector('.adm-cal__grid');
        const ecInfo = ecRoot.querySelector('.adm-cal__selected-info');
        const ecInfoText = ecRoot.querySelector('.adm-cal__selected-text');
        const ecLapangCards = document.getElementById('editLapangCards');

        function ecInitCalendar(year, month, day, initialItems = [], excludeId = null) {
            ecYear = year;
            ecMonth = month;
            ecSelectedDay = day;
            editCartItems = initialItems;
            ecExcludeIdSewa = excludeId;
            ecBookedSlotsData = {};
            ecTarifCache = {};
            ecRenderCalendar();
            if (day) {
                // Auto-load slots for the pre-selected day
                ecLoadSlots();
            } else {
                ecRenderPlaceholder();
            }
            renderEditCart();
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
                // Sunday is no longer disabled
                html += `<button type="button" class="${cls}" data-day="${d}">${d}</button>`;
            }

            ecGrid.innerHTML = html;

            ecGrid.querySelectorAll('.adm-cal__day:not(.empty)').forEach(btn => {
                btn.addEventListener('click', async () => {
                    ecSelectedDay = parseInt(btn.dataset.day);
                    ecRenderCalendar();
                    await ecLoadSlots();
                    renderEditCart();
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
                let url = `${API_BOOKED}?tanggal=${tanggal}`;
                if (ecExcludeIdSewa) url += `&exclude_id=${ecExcludeIdSewa}`;
                const res = await fetch(url);
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
            renderEditCart();
        }

        function ecRenderPlaceholder() {
            ecLapangCards.innerHTML = `
            <div class="no-selection-placeholder">
                <span class="material-symbols-outlined">touch_app</span>
                <p>Pilih tanggal di kalender untuk melihat jadwal tersedia</p>
            </div>`;
        }

        function ecRenderLapangCards() {
            if (!ecSelectedDay) { ecRenderPlaceholder(); return; }

            let html = '';
            LAPANGS.forEach(lap => {
                const tarifInfo = ecTarifCache[lap.id];
                let hargaPerJam = 0;
                if (tarifInfo && tarifInfo.tarifs && tarifInfo.tarifs.length > 0) {
                    hargaPerJam = parseInt(tarifInfo.tarifs[0].harga_umum);
                }
                const hargaLabel = hargaPerJam > 0 ? `Rp ${hargaPerJam.toLocaleString('id-ID')}/jam` : '';

                html += `
                <div class="adm-lapang-card" data-lapang-id="${lap.id}">
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

            const m = String(ecMonth + 1).padStart(2, '0');
            const d = String(ecSelectedDay).padStart(2, '0');
            const tanggal = `${ecYear}-${m}-${d}`;

            LAPANGS.forEach(lap => {
                const grid = document.getElementById(`editSlots-${lap.id}`);
                const bookedHours = ecBookedSlotsData[lap.id] || [];

                let shtml = '';
                TIME_SLOTS.forEach(slot => {
                    const inCartIndex = editCartItems.findIndex(i => String(i.id_lapang) === String(lap.id) && i.tanggal === tanggal && i.jam_mulai === slot.start);
                    let isSel = inCartIndex !== -1;
                    let isBooked = bookedHours.includes(slot.start);
                    
                    if (isSel) isBooked = false;

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
                        const lapId = parseInt(btn.dataset.lapang);
                        const slotStart = btn.dataset.slot;
                        const lapName = LAPANGS.find(l => l.id === lapId)?.name || '';

                        const inCartIndex = editCartItems.findIndex(i => String(i.id_lapang) === String(lapId) && i.tanggal === tanggal && i.jam_mulai === slotStart);

                        if (inCartIndex !== -1) {
                            editCartItems.splice(inCartIndex, 1);
                        } else {
                            editCartItems.push({
                                id_lapang: lapId,
                                nama_lapang: lapName,
                                tanggal: tanggal,
                                jam_mulai: slotStart,
                                durasi: 1,
                                harga: ecGetHargaForHour(lapId, slotStart)
                            });
                        }
                        ecRenderLapangCards();
                        renderEditCart();
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

        window.removeFromEditCart = function(idx) {
            editCartItems.splice(idx, 1);
            ecRenderLapangCards();
            renderEditCart();
        };

        window.updateEditCartItemDurasi = function(idx, delta) {
            const item = editCartItems[idx];
            const newDurasi = item.durasi + delta;
            if (newDurasi < 1) return;

            if (delta > 0) {
                const checkHour = parseInt(item.jam_mulai) + item.durasi;
                if (checkHour >= 24) return;
                const slotKey = String(checkHour).padStart(2, '0') + ':00';
                
                const booked = ecBookedSlotsData[item.id_lapang] || [];
                if (booked.includes(slotKey)) {
                    alert('Jam berikutnya sudah terisi. Tidak dapat menambah durasi.');
                    return;
                }
                
                const overlaps = editCartItems.some((other, oIdx) => {
                    if (oIdx === idx) return false;
                    if (String(other.id_lapang) !== String(item.id_lapang) || other.tanggal !== item.tanggal) return false;
                    const otherStart = parseInt(other.jam_mulai);
                    const otherEnd = otherStart + other.durasi;
                    return (checkHour >= otherStart && checkHour < otherEnd);
                });
                if (overlaps) {
                    alert('Jam berikutnya bertabrakan dengan item lain di keranjang Anda.');
                    return;
                }
            }

            item.durasi = newDurasi;
            
            let total = 0;
            const startH = parseInt(item.jam_mulai);
            for (let i = 0; i < item.durasi; i++) {
                const hStr = String(startH + i).padStart(2, '0') + ':00';
                total += ecGetHargaForHour(item.id_lapang, hStr);
            }
            item.harga = total;

            ecRenderLapangCards();
            renderEditCart();
        };

        function renderEditCart() {
            const listEl = document.getElementById('editCartItemsList');
            const emptyEl = document.getElementById('editCartEmptyNotice');
            const totalDisplay = document.getElementById('editTotalDisplay');
            const uangMasukInput = document.getElementById('editUangMasuk');
            const itemsJsonInput = document.getElementById('editInputItemsJson');

            if (editCartItems.length === 0) {
                listEl.innerHTML = '';
                emptyEl.style.display = 'block';
                itemsJsonInput.value = '';
                document.getElementById('editInputTotal').value = 0;
                totalDisplay.value = '';
                
                document.getElementById('editInputLapangId').value = '';
                document.getElementById('editInputTanggal').value = '';
                document.getElementById('editInputJamMulai').value = '';
                document.getElementById('editInputJamSelesai').value = '';
                document.getElementById('editInputDurasi').value = 1;
                return;
            }

            emptyEl.style.display = 'none';

            let html = '';
            let totalHarga = 0;

            editCartItems.forEach((item, idx) => {
                totalHarga += item.harga;
                const jamEnd = String(parseInt(item.jam_mulai) + item.durasi).padStart(2, '0') + ':00';

                html += `<div style="display:flex;align-items:center;justify-content:space-between;padding:0.6rem 0.75rem;background:var(--admin-surface);border:1px solid #cbd5e1;border-radius:0.65rem;margin-bottom:0.4rem;">
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.82rem;font-weight:700;color:var(--admin-on-surface);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            <span class="material-symbols-outlined" style="font-size:0.85rem;vertical-align:-2px;color:var(--admin-primary);margin-right:2px;">stadium</span>
                            ${item.nama_lapang}
                        </div>
                        <div style="font-size:0.72rem;color:var(--admin-secondary);margin-top:1px;">
                            ${item.tanggal} · ${item.jam_mulai} - ${jamEnd}
                        </div>
                        <div style="font-size:0.75rem;font-weight:700;color:var(--admin-primary);margin-top:2px;">
                            Rp ${item.harga.toLocaleString('id-ID')}
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:0.5rem; margin-right:1rem; background:var(--admin-surface-low); padding:0.25rem 0.5rem; border-radius:0.5rem; border:1px solid #e2e8f0;">
                        <button type="button" onclick="updateEditCartItemDurasi(${idx}, -1)" style="border:none; background:none; cursor:pointer; padding:0; color:var(--admin-on-surface);" ${item.durasi <= 1 ? 'disabled style="opacity:0.3;cursor:not-allowed;"' : ''}>
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">remove</span>
                        </button>
                        <span style="font-size:0.8rem; font-weight:700; width:35px; text-align:center;">${item.durasi} Jam</span>
                        <button type="button" onclick="updateEditCartItemDurasi(${idx}, 1)" style="border:none; background:none; cursor:pointer; padding:0; color:var(--admin-on-surface);">
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">add</span>
                        </button>
                    </div>
                    <button type="button" onclick="removeFromEditCart(${idx})" style="background:none;border:none;cursor:pointer;padding:0.25rem;color:#dc2626;flex-shrink:0;" title="Hapus">
                        <span class="material-symbols-outlined" style="font-size:1.1rem;">delete</span>
                    </button>
                </div>`;
            });

            html += `<div style="display:flex;justify-content:space-between;align-items:center;padding:0.55rem 0.75rem;background:#f0f9ff;border:1px solid #bae6fd;border-radius:0.65rem;margin-top:0.4rem;">
                <span style="font-size:0.82rem;font-weight:700;color:var(--admin-on-surface);">
                    <span class="material-symbols-outlined" style="font-size:0.9rem;vertical-align:-2px;">shopping_cart</span>
                    ${editCartItems.length} item
                </span>
                <span style="font-size:0.9rem;font-weight:800;color:#0284c7;">
                    Rp ${totalHarga.toLocaleString('id-ID')}
                </span>
            </div>`;

            listEl.innerHTML = html;
            itemsJsonInput.value = JSON.stringify(editCartItems);
            document.getElementById('editInputTotal').value = totalHarga;
            totalDisplay.value = totalHarga;
            uangMasukInput.value = totalHarga;

            document.getElementById('editInputLapangId').value = editCartItems[0].id_lapang;
            document.getElementById('editInputTanggal').value = editCartItems[0].tanggal;
            document.getElementById('editInputJamMulai').value = editCartItems[0].jam_mulai;
            document.getElementById('editInputJamSelesai').value = String(parseInt(editCartItems[0].jam_mulai) + editCartItems[0].durasi).padStart(2, '0') + ':00';
            document.getElementById('editInputDurasi').value = editCartItems.reduce((acc, curr) => acc + curr.durasi, 0);
        }

        document.getElementById('editDurasi').addEventListener('change', function () {
            document.getElementById('editInputDurasi').value = this.value;
            ecRenderLapangCards();
            renderEditCart();
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
                ecRenderCalendar();
                ecRenderPlaceholder();
                renderEditCart();
            });
        });

        // Expose the init function globally so openEditBookingModal can call it
        window._editCalInit = ecInitCalendar;
    })();

    /* ===== OPEN EDIT BOOKING MODAL ===== */
    async function openEditBookingModal(idSewa, kodeSewa, idLapang, namaPenyewa, noHp, tanggal, jamMulai, jamSelesai, durasi, total, tipeSewa) {
        document.getElementById('editIdSewa').value = idSewa;
        
        // Select correct Jenis Sewa pill
        tipeSewa = tipeSewa || 'Per Jam';
        document.getElementById('editInputTipeSewa').value = tipeSewa;
        document.querySelectorAll('#formEditBooking .sewa-pill').forEach(p => {
            if(p.dataset.sewa === tipeSewa) {
                p.classList.add('sewa-pill--active');
            } else {
                p.classList.remove('sewa-pill--active');
            }
        });

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

        // Fetch jadwals for this booking
        let initialItems = [];
        try {
            const res = await fetch(`<?= base_url('/api/getJadwalMembership') ?>?id_sewa=${idSewa}`);
            const data = await res.json();
            if (data.success && data.jadwals) {
                const lapangList = [
                    <?php foreach ($lapangs as $lapang): ?>
                                                                                                        { id: <?= $lapang['id_lapang'] ?>, name: '<?= esc($lapang['nama_lapangan']) ?>' },
                    <?php endforeach; ?>
                ];
                initialItems = data.jadwals.map(j => {
                    const lName = lapangList.find(l => l.id == j.id_lapang)?.name || ('Lapang ' + j.id_lapang);
                    const dur = parseInt(j.jam_selesai) - parseInt(j.jam_mulai);
                    return {
                        id_lapang: j.id_lapang,
                        nama_lapang: lName,
                        tanggal: j.tanggal_main,
                        jam_mulai: j.jam_mulai.substring(0, 5),
                        durasi: dur > 0 ? dur : 1,
                        harga: 0 
                    };
                });
                
                // Recalculate prices
                for (let item of initialItems) {
                    try {
                        const resT = await fetch(`<?= base_url('/admin/booking/getTarif') ?>?id_lapang=${item.id_lapang}&tanggal=${item.tanggal}`);
                        const tData = await resT.json();
                        let itemHarga = 0;
                        const startH = parseInt(item.jam_mulai);
                        for (let i = 0; i < item.durasi; i++) {
                            const h = startH + i;
                            let hHarga = 0;
                            if (tData.tarifs) {
                                for (const t of tData.tarifs) {
                                    if (h >= parseInt(t.jam_mulai) && h < parseInt(t.jam_selesai)) {
                                        hHarga = parseInt(t.harga_umum); break;
                                    }
                                }
                                if (hHarga === 0 && tData.tarifs.length > 0) hHarga = parseInt(tData.tarifs[0].harga_umum);
                            }
                            itemHarga += hHarga;
                        }
                        item.harga = itemHarga;
                    } catch(e) {}
                }
            }
        } catch (e) {
            console.error('Error fetching jadwals', e);
        }

        // If for some reason empty, fallback
        if (initialItems.length === 0) {
            const lapangList = [
                <?php foreach ($lapangs as $lapang): ?>
                                                                                                    { id: <?= $lapang['id_lapang'] ?>, name: '<?= esc($lapang['nama_lapangan']) ?>' },
                <?php endforeach; ?>
            ];
            const lapObj = lapangList.find(l => l.id == idLapang);
            initialItems.push({
                id_lapang: idLapang,
                nama_lapang: lapObj ? lapObj.name : 'Lapang ' + idLapang,
                tanggal: tanggal,
                jam_mulai: jamMulai,
                durasi: parseInt(durasi),
                harga: parseInt(total)
            });
        }

        const dp = initialItems[0].tanggal.split('-');
        const year = parseInt(dp[0]);
        const month = parseInt(dp[1]) - 1;
        const day = parseInt(dp[2]);

        const modal = new bootstrap.Modal(document.getElementById('editBookingModal'));
        modal.show();

        document.getElementById('editBookingModal').addEventListener('shown.bs.modal', function handler() {
            window._editCalInit(year, month, day, initialItems, idSewa);
            document.getElementById('editBookingModal').removeEventListener('shown.bs.modal', handler);
        });
    }

    /* ===== OPEN BUKTI BAYAR MODAL ===== */
    function openBuktiModal(kodeSewa, nominal, urlBukti, idSewa, status, namaPenyewa, namaLapang, tanggalMain, jamMulai, jamSelesai, jumlahBayar) {
        document.getElementById('verifikasiIdSewa').value = idSewa;
        document.getElementById('verifikasiKode').textContent = kodeSewa;

        // Identitas Booking
        document.getElementById('verifikasiNamaPenyewa').textContent = namaPenyewa || '-';
        document.getElementById('verifikasiLapang').textContent = namaLapang || '-';

        // Format tanggal
        const BULAN = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        if (tanggalMain) {
            const dp = tanggalMain.split('-');
            document.getElementById('verifikasiTanggal').textContent = parseInt(dp[2]) + ' ' + BULAN[parseInt(dp[1]) - 1] + ' ' + dp[0];
        } else {
            document.getElementById('verifikasiTanggal').textContent = '-';
        }
        document.getElementById('verifikasiJam').textContent = (jamMulai || '-') + ' — ' + (jamSelesai || '-');

        // Ringkasan Pembayaran
        const totalHarga = nominal || 0;
        const sudahBayar = jumlahBayar || 0;
        const sisaBayar = totalHarga - sudahBayar;

        document.getElementById('verifikasiNominal').textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
        document.getElementById('verifikasiDibayar').textContent = 'Rp ' + sudahBayar.toLocaleString('id-ID');
        document.getElementById('verifikasiSisa').textContent = sisaBayar > 0 ? 'Rp ' + sisaBayar.toLocaleString('id-ID') : 'Lunas';

        // Style sisa pembayaran
        const sisaEl = document.getElementById('verifikasiSisa');
        if (sisaBayar <= 0) {
            sisaEl.style.color = '#059669';
        } else {
            sisaEl.style.color = '#dc2626';
        }

        // Bukti Pembayaran
        const container = document.getElementById('buktiContainer');
        if (urlBukti && urlBukti.trim() !== '') {
            container.innerHTML = `
                <div style="text-align:center;">
                    <div style="background:#fff; padding:0.5rem; border-radius:0.75rem; border:1px solid #e2e8f0; display:inline-block; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);">
                        <img src="<?= base_url() ?>/${urlBukti}" style="max-height:380px; border-radius:0.5rem; display:block;" onerror="this.src='https://via.placeholder.com/300x500/eff6ff/0057cd?text=Struk+Transfer+Valid'">
                    </div>
                    <p style="font-size:0.7rem; color:var(--admin-secondary); margin-top:0.5rem;">${urlBukti}</p>
                </div>
            `;
        } else {
            container.innerHTML = `
                <div style="text-align:center; padding:1.5rem; background:#fff; border-radius:0.75rem; border:1px dashed #cbd5e1;">
                    <span class="material-symbols-outlined" style="font-size:3rem; color:var(--admin-outline); display:block; margin-bottom:0.5rem;">image_not_supported</span>
                    <p style="font-size:0.85rem; font-weight:bold; margin-bottom:0.25rem;">Belum ada bukti pembayaran</p>
                    <p style="font-size:0.72rem; color:var(--admin-outline); margin:0;">Pembayaran cash atau belum upload</p>
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

    /* ===== JADWAL DETAIL MODAL (Membership & Harian) ===== */
    function openMembershipDetailModal(idSewa, kodeSewa, namaPenyewa, tipeSewa) {
        document.getElementById('mbDetailKode').textContent = kodeSewa;
        document.getElementById('mbDetailNama').textContent = namaPenyewa;

        // Dynamic titles based on tipe sewa
        const isMembership = tipeSewa === 'Membership';
        document.getElementById('mbDetailTitle').textContent = isMembership ? 'Jadwal Membership' : 'Jadwal Harian';

        const container = document.getElementById('mbDetailSessions');
        container.innerHTML = '<div class="text-center py-3"><div class="spinner-border text-primary" role="status" style="width:1.5rem;height:1.5rem;"><span class="visually-hidden">Loading...</span></div></div>';

        new bootstrap.Modal(document.getElementById('membershipDetailModal')).show();

        fetch(`<?= base_url('/api/getJadwalMembership') ?>?id_sewa=${idSewa}`)
            .then(r => r.json())
            .then(data => {
                if (!data.success || !data.jadwals || data.jadwals.length === 0) {
                    container.innerHTML = '<div class="text-center py-3 text-muted">Tidak ada data jadwal.</div>';
                    return;
                }

                // Set subtitle
                const count = data.jadwals.length;
                document.getElementById('mbDetailSubtitle').textContent = isMembership
                    ? `Jadwal ${count} Sesi Mingguan`
                    : `Jadwal ${count} Hari Berturut`;

                const DAY_NAMES = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const MONTH_NAMES = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                let html = '';
                data.jadwals.forEach(j => {
                    const dt = new Date(j.tanggal_main);
                    const dayName = DAY_NAMES[dt.getDay()];
                    const dateStr = dt.getDate() + ' ' + MONTH_NAMES[dt.getMonth()] + ' ' + dt.getFullYear();
                    const jamMulai = j.jam_mulai.substring(0, 5);
                    const jamSelesai = j.jam_selesai.substring(0, 5);

                    const statusColors = {
                        'Terjadwal': { bg: '#eff6ff', border: '#bfdbfe', color: '#1d4ed8', icon: 'event_available' },
                        'Selesai': { bg: '#f0fdf4', border: '#a7f3d0', color: '#059669', icon: 'check_circle' },
                        'Dibatalkan': { bg: '#fef2f2', border: '#fecaca', color: '#dc2626', icon: 'cancel' },
                    };
                    const sc = statusColors[j.status_sesi] || statusColors['Terjadwal'];

                    const label = isMembership ? `Sesi ${j.sesi_ke}` : `Hari ${j.sesi_ke}`;

                    html += `
                    <div style="background:${sc.bg}; border:1px solid ${sc.border}; border-radius:0.75rem; padding:0.85rem 1rem; margin-bottom:0.6rem; display:flex; align-items:center; gap:0.75rem;">
                        <div style="min-width:2.2rem; height:2.2rem; border-radius:0.5rem; background:${sc.border}; display:flex; align-items:center; justify-content:center;">
                            <span style="font-weight:800; font-size:0.85rem; color:${sc.color};">${j.sesi_ke}</span>
                        </div>
                        <div style="flex:1;">
                            <div style="font-weight:700; font-size:0.85rem; color:var(--admin-on-surface);">${dayName}, ${dateStr}</div>
                            <div style="font-size:0.78rem; color:var(--admin-secondary); display:flex; align-items:center; gap:0.3rem; margin-top:0.15rem;">
                                <span class="material-symbols-outlined" style="font-size:0.85rem;">schedule</span>
                                ${jamMulai} - ${jamSelesai}
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:0.25rem; font-size:0.72rem; font-weight:600; color:${sc.color};">
                            <span class="material-symbols-outlined" style="font-size:0.85rem;">${sc.icon}</span>
                            ${j.status_sesi}
                        </div>
                    </div>`;
                });

                container.innerHTML = html;
            })
            .catch(err => {
                console.error('Error fetching jadwal:', err);
                container.innerHTML = '<div class="text-center py-3 text-danger">Gagal memuat data jadwal.</div>';
            });
    }

    // ===== BOOKING PAGINATION & FILTER =====
    let bookingPaginator;
    let currentBookingStatus = 'all';

    function runBookingFilters() {
        if(!bookingPaginator) return;
        const q = document.getElementById('searchBooking').value.toLowerCase();
        bookingPaginator.applyFilter((row) => {
            const text = row.textContent.toLowerCase();
            const matchesSearch = text.includes(q);
            let matchesStatus = false;

            if (currentBookingStatus === 'all') {
                matchesStatus = true;
            } else if (currentBookingStatus === 'butuh_dikonfirmasi') {
                matchesStatus = (row.dataset.status === 'Menunggu Verifikasi');
            } else {
                matchesStatus = (row.dataset.status === currentBookingStatus);
            }

            return matchesSearch && matchesStatus;
        });
    }

    window.searchBookingTable = function() {
        runBookingFilters();
    };

    window.filterStatus = function(status, btn) {
        currentBookingStatus = status;
        document.querySelectorAll('.tab-pill').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');
        runBookingFilters();
    };

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof CustomPaginator !== 'undefined') {
            bookingPaginator = new CustomPaginator('#bookingTableBody', 10);
        }
    });
</script>

<style>
    /* ===== SEWA PILLS ===== */
    .sewa-pills {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }
    .sewa-pill {
        flex: 1;
        min-width: 110px;
        display: flex;
        align-items: center;
        gap: .4rem;
        padding: 0.65rem 0.85rem;
        background: var(--admin-surface-low, #fff);
        border: 1.5px solid var(--admin-outline, #cbd5e1);
        border-radius: 0.75rem;
        text-align: left;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .sewa-pill:hover {
        border-color: var(--admin-secondary, #94a3b8);
        background: #f8fafc;
    }
    .sewa-pill--active {
        border-color: var(--admin-primary, #0d6efd);
        background: color-mix(in srgb, var(--admin-primary, #0d6efd) 8%, transparent);
        box-shadow: 0 4px 12px -2px rgba(13,110,253,0.08);
    }
    .sewa-pill .material-symbols-outlined {
        font-size: 1.6rem;
        color: var(--admin-secondary, #64748b);
    }
    .sewa-pill--active .material-symbols-outlined {
        color: var(--admin-primary, #0d6efd);
    }
    .sewa-pill__title {
        display: block;
        font-family: 'Inter', sans-serif;
        font-size: .8rem;
        font-weight: 700;
        color: var(--admin-text, #334155);
    }
    .sewa-pill__desc {
        display: block;
        font-family: 'Public Sans', sans-serif;
        font-size: .65rem;
        font-weight: 500;
        color: var(--admin-secondary, #64748b);
        margin-top: .1rem;
    }
</style>

<?= $this->endSection() ?>