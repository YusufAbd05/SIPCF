<?= $this->extend('template/landing/base') ?>
<?= $this->section('title') ?>Ubah Jadwal<?= $this->endSection() ?>
<?= $this->section('content') ?>

<section class="schedule-section">
    <div class="container">

        <!-- Section Header -->
        <div class="text-center mb-5">
            <div class="section-chip mx-auto mb-3">
                <span class="material-symbols-outlined" style="font-size:1rem;">edit_calendar</span>
                Ubah Jadwal
            </div>
            <h2 class="schedule-heading">Ubah Jadwal<br class="d-none d-md-block"> Booking Anda</h2>
            <p class="schedule-subheading mt-3">Masukkan kode booking yang Anda terima untuk mengubah jadwal bermain.
                Perubahan dapat dilakukan minimal 3 jam sebelum jadwal bermain.</p>
        </div>

        <!-- ═══ STEP 1: Booking Code Input ═══ -->
        <div class="booking-card mx-auto" id="bookingLookup">
            <div class="booking-card__icon-wrap">
                <div class="booking-card__icon"><span class="material-symbols-outlined">confirmation_number</span></div>
            </div>
            <h4 class="booking-card__title">Masukkan Kode Booking</h4>
            <p class="booking-card__desc">Kode booking terdapat pada halaman konfirmasi atau catatan Anda saat melakukan
                pemesanan.</p>
            <form id="formBookingCode" class="booking-form" onsubmit="return handleLookup(event)">
                <?= csrf_field() ?>
                <div class="booking-input-group">
                    <span class="material-symbols-outlined booking-input-icon">tag</span>
                    <input type="text" id="inputBookingCode" class="booking-input" placeholder="Contoh: BK-20260515-001"
                        maxlength="20" autocomplete="off" required>
                </div>
                <button type="submit" class="booking-submit-btn" id="btnLookup">
                    <span class="material-symbols-outlined" style="font-size:1.15rem;">search</span> Cari Booking
                </button>
            </form>
            <div class="booking-alert booking-alert--error d-none" id="alertError">
                <span class="material-symbols-outlined">error</span>
                <div>
                    <strong id="alertErrorTitle">Kode booking tidak ditemukan</strong>
                    <p class="mb-0" id="alertErrorMsg">Periksa kembali kode booking Anda.</p>
                </div>
            </div>
            <div class="booking-help">
                <span class="material-symbols-outlined" style="font-size:1rem;">help</span>
                <span>Tidak memiliki kode booking? <a href="<?= base_url('/') ?>" class="booking-help-link">Buat jadwal
                        baru</a></span>
            </div>
        </div>

        <!-- ═══ STEP 1.5: List Jadwal (hidden) ═══ -->
        <div class="d-none" id="jadwalListSection" style="max-width:800px;margin:0 auto;">
            <button type="button" class="booking-back-btn mb-4" onclick="showLookup()">
                <span class="material-symbols-outlined" style="font-size:1.1rem;">arrow_back</span> Kembali
            </button>
            <h4 class="mb-3" style="font-weight:700;">Daftar Jadwal Booking Anda</h4>
            <p class="text-muted mb-4">Pilih jadwal lapangan yang ingin Anda ubah waktunya. Perubahan hanya bisa dilakukan untuk masing-masing jadwal.</p>
            <div id="jadwalListContainer" style="display:flex;flex-direction:column;gap:1rem;"></div>
        </div>

        <!-- ═══ STEP 2: Reschedule with Calendar (hidden) ═══ -->
        <div class="d-none" id="rescheduleSection" style="max-width:1000px;margin:0 auto;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <button type="button" class="booking-back-btn" onclick="showJadwalList()">
                    <span class="material-symbols-outlined" style="font-size:1.1rem;">arrow_back</span> Kembali ke Daftar
                </button>
                <div class="step-indicator d-none d-sm-block">
                    <span class="step-badge">Tahap 2 dari 2</span>
                </div>
            </div>

            <div class="reschedule-layout">
                <!-- Left Sidebar: Current Info & Duration -->
                <div class="reschedule-sidebar">
                    <!-- Current Booking Info -->
                    <div class="booking-result-card mb-4" style="max-width:100%; border:1px solid #e2e8f0; box-shadow:0 10px 25px -5px rgba(0,0,0,0.05);">
                        <div class="booking-result__header" style="background:#f8fafc;">
                            <div class="booking-result__status">
                                <span class="status-pill status-pill--available" id="editStatus">Aktif</span>
                            </div>
                            <h4 class="booking-result__title" id="editTitle">Lapangan</h4>
                            <p class="booking-result__code" id="editCode">BK-XXXX</p>
                        </div>
                        <div class="booking-result__details" style="padding:1rem;">
                            <div class="booking-detail-row" style="flex-direction:column; gap:0.75rem;">
                                <div class="booking-detail-item" style="width:100%;">
                                    <span class="material-symbols-outlined booking-detail-icon">calendar_month</span>
                                    <div><span class="booking-detail-label">Tanggal Saat Ini</span><span
                                            class="booking-detail-value" id="editTanggal">-</span></div>
                                </div>
                                <div class="booking-detail-item" style="width:100%;">
                                    <span class="material-symbols-outlined booking-detail-icon">schedule</span>
                                    <div><span class="booking-detail-label">Jam Saat Ini</span><span
                                            class="booking-detail-value" id="editJam">-</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Duration Picker Card -->
                    <div class="booking-card" style="padding:1.5rem; max-width:100%;">
                        <h5 style="font-weight:700;font-size:1rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.6rem;">
                            <div style="width:2.25rem;height:2.25rem;background:#fef3c7;color:#d97706;border-radius:.6rem;display:flex;align-items:center;justify-content:center;">
                                <span class="material-symbols-outlined" style="font-size:1.3rem;">timer</span>
                            </div>
                            Pilih Durasi Baru
                        </h5>
                        <div class="duration-picker-modern">
                            <button type="button" class="duration-btn-modern" onclick="changeRcDurasi(-1)">
                                <span class="material-symbols-outlined">remove</span>
                            </button>
                            <div class="duration-display">
                                <input type="text" id="rcDurasiBaru" readonly value="1" class="duration-val">
                                <span class="duration-lbl">Jam</span>
                            </div>
                            <button type="button" class="duration-btn-modern" onclick="changeRcDurasi(1)">
                                <span class="material-symbols-outlined">add</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Content: Calendar & Slots -->
                <div class="reschedule-main">
                    <div class="booking-card" style="padding:1.5rem; max-width:100%;">
                        <h5 style="font-weight:700;font-size:1rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.6rem;">
                            <div style="width:2.25rem;height:2.25rem;background:#dbeafe;color:#2563eb;border-radius:.6rem;display:flex;align-items:center;justify-content:center;">
                                <span class="material-symbols-outlined" style="font-size:1.3rem;">edit_calendar</span>
                            </div>
                            Pilih Tanggal Baru
                        </h5>
                        
                        <div class="cal-card mb-4" style="box-shadow:none;border:1px solid #e2e8f0;border-radius:1rem;background:#f8fafc;">
                            <div class="cal-header">
                                <button type="button" class="cal-nav-btn" id="rcCalPrev"><span
                                        class="material-symbols-outlined">chevron_left</span></button>
                                <span class="cal-month-label" id="rcCalLabel">Mei 2026</span>
                                <button type="button" class="cal-nav-btn" id="rcCalNext"><span
                                        class="material-symbols-outlined">chevron_right</span></button>
                            </div>
                            <div class="cal-grid cal-dow">
                                <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                            </div>
                            <div class="cal-grid cal-dates" id="rcCalDates"></div>
                        </div>

                        <!-- Timeslot cards (hidden until date selected) -->
                        <div id="rcSlotSection" style="display:none;border-top:1px dashed #cbd5e1;padding-top:1.5rem;">
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                                <div>
                                    <h5 class="results-title mb-1" style="font-size:1.1rem;color:#0f172a;">Pilih Jam Baru</h5>
                                    <p class="results-subtitle mb-0" id="rcDateLabel" style="font-size:.85rem;color:#64748b;">
                                        <span class="material-symbols-outlined"
                                            style="font-size:1rem;vertical-align:-3px;">today</span>
                                        Pilih tanggal di kalender
                                    </p>
                                </div>
                                <div class="results-count" id="rcSlotSummary" style="display:none;background:#ecfdf5;color:#059669;padding:.4rem .85rem;border-radius:2rem;font-size:.8rem;font-weight:700;align-items:center;gap:.3rem;">
                                    <span class="material-symbols-outlined" style="font-size:1.1rem;">check_circle</span>
                                    <span id="rcSlotSummaryText"></span>
                                </div>
                            </div>

                            <div id="rcSlotLoading" class="text-center py-4" style="display:none;">
                                <div class="spinner-border text-primary" role="status" style="width:2.5rem;height:2.5rem;"></div>
                                <p class="mt-3" style="font-size:.9rem;color:#64748b;font-weight:600;">Memuat slot waktu...</p>
                            </div>

                            <!-- Single lapang card with timeslots -->
                            <div id="rcTimeslotCard"></div>

                            <!-- Error -->
                            <div class="booking-alert booking-alert--error d-none mt-4" id="rcError" style="border-radius:0.75rem;">
                                <span class="material-symbols-outlined">error</span>
                                <div><strong>Gagal mengubah jadwal</strong>
                                    <p class="mb-0" id="rcErrorMsg"></p>
                                </div>
                            </div>

                            <!-- Confirm button (shown after selecting a timeslot) -->
                            <div id="rcConfirmWrap" style="display:none;" class="mt-4">
                                <button type="button" class="booking-confirm-btn w-100" id="btnConfirm" onclick="confirmReschedule()" style="padding:1.1rem;font-size:1.1rem;border-radius:0.75rem;box-shadow:0 10px 20px -5px rgba(37,99,235,0.3);">
                                    <span class="material-symbols-outlined" style="font-size:1.3rem;">check_circle</span>
                                    Konfirmasi Perubahan Jadwal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ STEP 3: Success ═══ -->
        <div class="booking-success-card mx-auto d-none" id="bookingSuccess">
            <div class="booking-success-icon-wrap">
                <div class="booking-success-icon"><span class="material-symbols-outlined">check_circle</span></div>
            </div>
            <h4 class="booking-card__title">Jadwal Berhasil Diubah!</h4>
            <p class="booking-card__desc">Jadwal lapangan Anda telah berhasil diperbarui.</p>
            <div class="booking-result__details mt-3 mb-4">
                <div class="booking-detail-row">
                    <div class="booking-detail-item">
                        <span class="material-symbols-outlined booking-detail-icon">calendar_month</span>
                        <div><span class="booking-detail-label">Tanggal Baru</span><span class="booking-detail-value"
                                id="successDate">-</span></div>
                    </div>
                    <div class="booking-detail-item">
                        <span class="material-symbols-outlined booking-detail-icon">schedule</span>
                        <div><span class="booking-detail-label">Waktu Baru</span><span class="booking-detail-value"
                                id="successTime">-</span></div>
                    </div>
                </div>
                <div class="booking-detail-row mt-2" id="paymentDetails" style="display:none;">
                    <div class="booking-detail-item" style="flex-direction:column;align-items:flex-start;gap:.25rem;background:#f8fafc;width:100%;">
                        <div style="display:flex;justify-content:space-between;width:100%;font-size:.85rem;margin-bottom:.25rem;">
                            <span class="text-muted">Total Harga Baru:</span>
                            <span style="font-weight:700;" id="successTotal">-</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;width:100%;font-size:.85rem;margin-bottom:.25rem;">
                            <span class="text-muted">Sudah Dibayar:</span>
                            <span style="font-weight:700;color:#10b981;" id="successDibayar">-</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;width:100%;font-size:.9rem;border-top:1px dashed #cbd5e1;padding-top:.5rem;">
                            <span style="font-weight:700;color:#0f172a;">Sisa Bayar:</span>
                            <span style="font-weight:800;color:#ef4444;" id="successSisa">-</span>
                        </div>
                        <div class="mt-2" style="font-size:.75rem;color:#64748b;display:flex;gap:.35rem;">
                            <span class="material-symbols-outlined" style="font-size:1rem;color:#f59e0b;">info</span>
                            <span>Uang sisa dibayarkan setelah Anda selesai bermain di tempat.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                <a href="<?= base_url('/ubah-jadwal') ?>" class="booking-outline-btn"><span
                        class="material-symbols-outlined" style="font-size:1.1rem;">edit_calendar</span> Ubah Lagi</a>
                <a href="<?= base_url('/') ?>" class="booking-submit-btn" style="text-decoration:none;"><span
                        class="material-symbols-outlined" style="font-size:1.1rem;">home</span> Kembali ke Beranda</a>
            </div>
        </div>

    </div>
</section>

<!-- ═══ MODAL: Detail Booking ═══ -->
<div class="modal fade" id="detailBookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
        <div class="modal-content"
            style="border-radius:1.25rem;overflow:hidden;border:none;box-shadow:0 20px 60px -10px rgba(0,0,0,.25);">
            <div class="modal-header"
                style="background:linear-gradient(135deg,#1d4ed8,#4f46e5);border:none;padding:1.1rem 1.5rem;">
                <h5 class="modal-title"
                    style="color:#fff;font-size:1rem;font-weight:700;display:flex;align-items:center;gap:.5rem;margin:0;">
                    <span class="material-symbols-outlined" style="font-size:1.25rem;">receipt_long</span> Detail
                    Booking
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:.75rem;background:#f8fafc;">
                <div
                    style="background:linear-gradient(135deg,#0f172a,#1e3a5f);margin:0 -.75rem;padding:1.4rem 1.5rem;text-align:center;border-bottom:3px solid #facc15;display:flex;flex-direction:column;align-items:center;gap:.35rem;">
                    <span
                        style="color:#94a3b8;font-size:.72rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;">Kode
                        Booking</span>
                    <span style="color:#facc15;font-family:'Courier New',monospace;font-size:1.6rem;font-weight:800;"
                        id="modalKode">-</span>
                    <span class="dbm-status-pill" id="modalStatus">Aktif</span>
                </div>
                <div class="dbm-details">
                    <div class="dbm-detail-item">
                        <div class="dbm-detail-icon"><span class="material-symbols-outlined">person</span></div>
                        <div><span class="dbm-detail-label">Nama Penyewa</span><span class="dbm-detail-value"
                                id="modalNama">-</span></div>
                    </div>
                    <div class="dbm-detail-item">
                        <div class="dbm-detail-icon"><span class="material-symbols-outlined">stadium</span></div>
                        <div><span class="dbm-detail-label">Lapangan</span><span class="dbm-detail-value"
                                id="modalLapang">-</span></div>
                    </div>
                    <div class="dbm-detail-item">
                        <div class="dbm-detail-icon"><span class="material-symbols-outlined">calendar_month</span></div>
                        <div><span class="dbm-detail-label">Tanggal Main</span><span class="dbm-detail-value"
                                id="modalTanggal">-</span></div>
                    </div>
                    <div class="dbm-detail-item">
                        <div class="dbm-detail-icon"><span class="material-symbols-outlined">schedule</span></div>
                        <div><span class="dbm-detail-label">Jam Bermain</span><span class="dbm-detail-value"
                                id="modalJam">-</span></div>
                    </div>
                    <div class="dbm-detail-item">
                        <div class="dbm-detail-icon"><span class="material-symbols-outlined">account_balance_wallet</span></div>
                        <div><span class="dbm-detail-label">Sisa Pembayaran</span><span class="dbm-detail-value"
                                style="color:#ef4444;font-weight:700;" id="modalSisa">-</span></div>
                    </div>
                    <div class="dbm-detail-item">
                        <div class="dbm-detail-icon"><span class="material-symbols-outlined">payments</span></div>
                        <div><span class="dbm-detail-label">Total Bayar</span><span class="dbm-detail-value"
                                style="color:#1d4ed8;font-weight:700;" id="modalHarga">-</span></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"
                style="background:#fff;border-top:1px solid #e2e8f0;padding:.85rem 1rem;gap:.5rem;justify-content:flex-end;">
                <button type="button" class="dbm-btn-tutup" data-bs-dismiss="modal"><span
                        class="material-symbols-outlined">close</span> Tutup</button>
                <button type="button" class="dbm-btn-edit" id="btnEditBooking"><span
                        class="material-symbols-outlined">edit_calendar</span> Edit Jadwal</button>
            </div>
        </div>
    </div>
</div>

<style>
    .booking-alert--info {
        background: var(--primary-fixed);
        border: 1px solid var(--primary-fixed-dim);
        border-radius: .75rem;
        padding: .75rem 1rem;
        display: flex;
        align-items: flex-start;
        gap: .625rem;
        font-size: .85rem;
        color: var(--on-primary-fixed);
    }

    .booking-alert--info .material-symbols-outlined {
        font-size: 1.15rem;
        flex-shrink: 0;
        margin-top: .1rem;
    }

    .dbm-status-pill {
        display: inline-flex;
        padding: .2rem .75rem;
        border-radius: 9999px;
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        background: rgba(16, 185, 129, .15);
        color: #10b981;
        margin-top: .25rem;
    }

    .dbm-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .5rem;
        padding: 0 .25rem;
    }

    @media(max-width:480px) {
        .dbm-details {
            grid-template-columns: 1fr;
        }
    }

    .dbm-detail-item {
        display: flex;
        align-items: center;
        gap: .65rem;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .75rem;
        padding: .75rem .85rem;
        transition: border-color .15s;
    }

    .dbm-detail-item:hover {
        border-color: #c7d2fe;
    }

    .dbm-detail-icon {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: .6rem;
        background: var(--primary-fixed, #dae2ff);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .dbm-detail-icon .material-symbols-outlined {
        font-size: 1.15rem;
        color: var(--primary, #0057cd);
    }

    .dbm-detail-label {
        display: block;
        font-size: .65rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: .1rem;
    }

    .dbm-detail-value {
        display: block;
        font-size: .85rem;
        font-weight: 600;
        color: #0f172a;
    }

    .dbm-btn-tutup,
    .dbm-btn-edit {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .55rem 1.25rem;
        border-radius: .65rem;
        font-size: .82rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .18s;
    }

    .dbm-btn-tutup .material-symbols-outlined,
    .dbm-btn-edit .material-symbols-outlined {
        font-size: 1rem;
    }

    .dbm-btn-tutup {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .dbm-btn-tutup:hover {
        background: #e2e8f0;
    }

    .dbm-btn-edit {
        background: linear-gradient(135deg, #1d4ed8, #4f46e5);
        color: #fff;
    }

    .dbm-btn-edit:hover {
        background: linear-gradient(135deg, #1e40af, #4338ca);
        box-shadow: 0 6px 16px -4px rgba(79, 70, 229, .45);
        transform: translateY(-1px);
    }

    .timeslot-box--past {
        opacity: .35;
        cursor: not-allowed;
        background: var(--surface-container);
        border-color: transparent;
    }

    .timeslot-box--past:hover {
        transform: none;
        box-shadow: none;
        border-color: transparent;
    }

    .timeslot-badge {
        font-family: 'Public Sans', sans-serif;
        font-size: .55rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: .1rem .4rem;
        border-radius: 9999px;
        margin-left: auto;
        flex-shrink: 0;
    }

    .timeslot-badge--kosong {
        background: #ecfdf5;
        color: #059669;
    }

    .timeslot-badge--terisi {
        background: #fef2f2;
        color: #dc2626;
    }

    .timeslot-badge--lewat {
        background: #f1f5f9;
        color: #94a3b8;
    }

    .cal-cell--past {
        opacity: .35;
        cursor: not-allowed !important;
        pointer-events: none;
    }

    .cal-cell--past .cal-cell__num {
        text-decoration: line-through;
    }

    .lapang-card__subtitle {
        font-family: 'Public Sans', sans-serif;
        font-size: .68rem;
        font-weight: 600;
        color: rgba(255, 255, 255, .75);
        letter-spacing: .03em;
        margin-top: .15rem;
    }

    .lapang-card__stats {
        display: flex;
        gap: 1rem;
        padding: .5rem 1rem;
        background: var(--surface-container-low);
        border-bottom: 1px solid var(--outline-variant);
        font-family: 'Public Sans', sans-serif;
        font-size: .7rem;
        font-weight: 600;
        color: var(--on-surface-variant);
    }

    .lapang-card__stat {
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .lapang-card__stat .material-symbols-outlined {
        font-size: .85rem;
    }

    .stat--available {
        color: #059669;
    }

    .stat--booked {
        color: #dc2626;
    }

    /* Reschedule Grid Layout */
    .reschedule-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    @media (max-width: 768px) {
        .reschedule-layout {
            grid-template-columns: 1fr;
        }
    }

    /* Duration Picker Modern UI */
    .duration-picker-modern {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 0.6rem;
    }

    .duration-btn-modern {
        width: 3rem;
        height: 3rem;
        border-radius: 0.75rem;
        border: none;
        background: #fff;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .duration-btn-modern:hover {
        background: #f1f5f9;
        color: #0f172a;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .duration-btn-modern:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .duration-display {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .duration-val {
        width: 4rem;
        text-align: center;
        background: transparent;
        border: none;
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
        outline: none;
        line-height: 1;
        margin-bottom: 0.15rem;
    }

    .duration-lbl {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .step-badge {
        background: var(--primary-fixed, #dae2ff);
        color: var(--on-primary-fixed, #001946);
        padding: 0.45rem 0.85rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
</style>

<!-- PART 2: JavaScript in separate script tag -->
<script src="/js/ubah-jadwal.js?v=<?= time() ?>"></script>

<?= $this->endSection() ?>