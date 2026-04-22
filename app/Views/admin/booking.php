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
                <p class="stat-chip__value">156</p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon green"><span class="material-symbols-outlined">check_circle</span>
            </div>
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
        <div class="px-3 pt-2 pb-2 border-bottom d-flex gap-2"
            style="background:var(--admin-surface-low); overflow-x:auto;">
            <button class="tab-pill active" onclick="filterStatus('all', this)">Semua Antrean</button>
            <button class="tab-pill" onclick="filterStatus('Menunggu Pembayaran', this)">Menunggu Pembayaran</button>
            <button class="tab-pill" onclick="filterStatus('Menunggu Verifikasi', this)">Butuh Verifikasi</button>
            <button class="tab-pill" onclick="filterStatus('Ditolak', this)">Ditolak</button>
        </div>
        <div class="table-toolbar">
            <div class="table-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" id="searchBooking" placeholder="Cari kode booking, nama penyewa..." oninput="searchBookingTable()" />
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
                    <tr data-status="Menunggu Verifikasi">
                        <td class="td-code">BK-20260411-001</td>
                        <td><span class="td-name">Lapang Futsal A</span></td>
                        <td>
                            <div class="fw-bold">Ahmad Fauzi</div>
                            <div class="td-secondary">Member</div>
                        </td>
                        <td>
                            <div class="mb-1"><span class="badge text-bg-primary" style="font-size:0.6rem;">Online Booking</span></div>
                            <div class="td-secondary"><span class="material-symbols-outlined align-bottom" style="font-size:0.85rem;">calendar_month</span> 11 Apr 2026, 09:00</div>
                        </td>
                        <td><span class="badge text-bg-warning">Menunggu Verifikasi</span></td>
                        <td class="td-currency">Rp 280.000</td>
                        <td><span class="badge-method transfer">Transfer</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="action-btn bukti" title="Cek & Verifikasi" data-bs-toggle="modal" data-bs-target="#buktiBayarModal"><span class="material-symbols-outlined">search_check</span> Cek</button>
                            </div>
                        </td>
                    </tr>
                    <tr data-status="Menunggu Pembayaran">
                        <td class="td-code">BK-20260411-002</td>
                        <td><span class="td-name">Lapang Badminton B</span></td>
                        <td>
                            <div class="fw-bold">Siti Rahmawati</div>
                            <div class="td-secondary">Member</div>
                        </td>
                        <td>
                            <div class="mb-1"><span class="badge text-bg-primary" style="font-size:0.6rem;">Online Booking</span></div>
                            <div class="td-secondary"><span class="material-symbols-outlined align-bottom" style="font-size:0.85rem;">calendar_month</span> 11 Apr 2026, 10:00</div>
                        </td>
                        <td><span class="badge text-bg-secondary">Menunggu Pembayaran</span></td>
                        <td class="td-currency">Rp 100.000</td>
                        <td><span class="badge-method transfer">Transfer</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="action-btn bukti" title="Cek Detail" data-bs-toggle="modal" data-bs-target="#buktiBayarModal"><span class="material-symbols-outlined">search</span> Cek</button>
                            </div>
                        </td>
                    </tr>
                    <tr data-status="Menunggu Verifikasi">
                        <td class="td-code">BK-20260412-003</td>
                        <td><span class="td-name">Lapang Basket C</span></td>
                        <td>
                            <div class="fw-bold">Budi Santoso</div>
                            <div class="td-secondary">Guest</div>
                        </td>
                        <td>
                            <div class="mb-1"><span class="badge text-bg-primary" style="font-size:0.6rem;">Online Booking</span></div>
                            <div class="td-secondary"><span class="material-symbols-outlined align-bottom" style="font-size:0.85rem;">calendar_month</span> 12 Apr 2026, 14:00</div>
                        </td>
                        <td><span class="badge text-bg-warning">Menunggu Verifikasi</span></td>
                        <td class="td-currency">Rp 400.000</td>
                        <td><span class="badge-method ewallet">E-Wallet</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="action-btn bukti" title="Cek & Verifikasi" data-bs-toggle="modal" data-bs-target="#buktiBayarModal"><span class="material-symbols-outlined">search_check</span> Cek</button>
                            </div>
                        </td>
                    </tr>
                    <tr data-status="Ditolak">
                        <td class="td-code">BK-20260411-004</td>
                        <td><span class="td-name">Lapang Badminton B</span></td>
                        <td>
                            <div class="fw-bold">Dewi Lestari</div>
                            <div class="td-secondary">Guest (Walk-in)</div>
                        </td>
                        <td>
                            <div class="mb-1"><span class="badge text-bg-secondary" style="font-size:0.6rem;">Walk-in Offline</span></div>
                            <div class="td-secondary"><span class="material-symbols-outlined align-bottom" style="font-size:0.85rem;">calendar_month</span> 11 Apr 2026, 15:00</div>
                        </td>
                        <td><span class="badge text-bg-danger">Ditolak</span></td>
                        <td class="td-currency">Rp 100.000</td>
                        <td><span class="badge-method cash">Cash</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="action-btn bukti" title="Cek Detail" data-bs-toggle="modal" data-bs-target="#buktiBayarModal"><span class="material-symbols-outlined">search</span> Cek</button>
                            </div>
                        </td>
                    </tr>
                    <tr data-status="Menunggu Pembayaran">
                        <td class="td-code">BK-20260413-005</td>
                        <td><span class="td-name">Lapang Futsal A</span></td>
                        <td>
                            <div class="fw-bold">Rizky Pratama</div>
                            <div class="td-secondary">Member</div>
                        </td>
                        <td>
                            <div class="mb-1"><span class="badge text-bg-primary" style="font-size:0.6rem;">Online Booking</span></div>
                            <div class="td-secondary"><span class="material-symbols-outlined align-bottom" style="font-size:0.85rem;">calendar_month</span> 13 Apr 2026, 19:00</div>
                        </td>
                        <td><span class="badge text-bg-secondary">Menunggu Pembayaran</span></td>
                        <td class="td-currency">Rp 150.000</td>
                        <td><span class="badge-method qris">QRIS</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="action-btn bukti" title="Cek Detail" data-bs-toggle="modal" data-bs-target="#buktiBayarModal"><span class="material-symbols-outlined">search</span> Cek</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span class="table-footer__info">Menampilkan 5 data</span>
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
                    Tambah Pesanan Walk-in
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
                                    <input type="text" name="nama_penyewa" class="form-control-custom" placeholder="Masukkan nama penyewa"
                                        required />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">mail</span> Email
                                    </label>
                                    <input type="email" name="email" class="form-control-custom" placeholder="email@contoh.com"
                                        required />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">call</span> No. HP
                                    </label>
                                    <input type="tel" name="no_hp" class="form-control-custom" placeholder="08xxxxxxxxxx" required />
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

                            <!-- Pembayaran Langsung -->
                            <div class="form-section-title">
                                <span class="material-symbols-outlined">payments</span>
                                Pembayaran Walk-in
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">sell</span> Total Harga
                                        Tagihan
                                    </label>
                                    <div class="price-input-wrap">
                                        <span class="prefix">Rp</span>
                                        <input type="number" class="form-control-custom"
                                            placeholder="Terhitung otomatis" readonly
                                            style="background:var(--admin-surface-low);" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label-custom">
                                        <span class="material-symbols-outlined">check_circle</span> Status
                                        Transaksi
                                    </label>
                                    <input type="text" class="form-control-custom" value="Dikonfirmasi (Lunas)" readonly
                                        style="background:#ecfdf5; color:#059669; border-color:#a7f3d0; font-weight:600;" />
                                    <small class="text-muted mt-1" style="font-size:0.65rem; display:block;">Otomatis
                                        tersimpan sebagai
                                        pembayaran Cash secara offline.</small>
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
                    Simpan Pesanan Walk-in
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
                            <label class="form-label-custom"><span class="material-symbols-outlined">tag</span>
                                Kode
                                Booking</label>
                            <input type="text" class="form-control-custom" value="BK-20260411-001" readonly
                                style="background:var(--admin-surface-low);cursor:not-allowed;" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom"><span class="material-symbols-outlined">stadium</span>
                                Nama
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
                            <label class="form-label-custom"><span class="material-symbols-outlined">badge</span>
                                Nama
                                Penyewa</label>
                            <input type="text" class="form-control-custom" value="Ahmad Fauzi" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom"><span class="material-symbols-outlined">mail</span>
                                Email</label>
                            <input type="email" class="form-control-custom" value="ahmad@email.com" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom"><span class="material-symbols-outlined">call</span>
                                No.
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
                            <label class="form-label-custom"><span class="material-symbols-outlined">schedule</span>
                                Jam
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
                            <label class="form-label-custom"><span class="material-symbols-outlined">sell</span>
                                Total
                                Harga</label>
                            <div class="price-input-wrap">
                                <span class="prefix">Rp</span>
                                <input type="number" class="form-control-custom" value="300000" />
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom"><span
                                    class="material-symbols-outlined">account_balance_wallet</span> Uang
                                Masuk</label>
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
                        BK-20260411-001</h6>
                    <p class="mb-0 text-muted" style="font-size:0.8rem;">Cek kesesuaian nominal tagihan
                        (<b>Rp 280.000</b>) sebelum klik Terima.</p>
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
                <div class="d-flex w-100 flex-column text-start">
                    <div class="collapse w-100 mb-3" id="collapseTolakPesanan">
                        <div class="card card-body p-3"
                            style="background:var(--admin-surface-low); border:1px solid #fca5a5;">
                            <label class="form-label mb-2 text-danger"
                                style="font-size:0.75rem; font-weight:700;">Alasan Penolakan (Akan dikirim
                                ke pengguna via Notifikasi/Email):</label>
                            <textarea class="form-control" rows="2"
                                placeholder="Contoh: Lampiran bukti transfer tidak terbaca / Nominal transfer kurang valid..."
                                style="font-size:0.8rem; border-color:#fca5a5; resize:none;"></textarea>
                            <div class="mt-2 text-end">
                                <button type="button" class="btn btn-danger px-3 py-1 fw-bold" data-bs-dismiss="modal"
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
                        <button type="button" class="btn btn-success d-flex align-items-center gap-1"
                            data-bs-dismiss="modal"
                            style="font-size:0.85rem; font-weight:600; background:#059669; border:none; padding:0.5rem 1rem;">
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">check_circle</span>
                            Terima & Konfirmasi
                        </button>
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
</script>

<?= $this->endSection() ?>