<?= $this->extend('template/landing/base') ?>
<?= $this->section('title') ?>Formulir Booking<?= $this->endSection() ?>
<?= $this->section('content') ?>

<!-- ================= FORMULIR BOOKING ================= -->
<section class="schedule-section">
    <div class="container">

        <?php if (session()->getFlashdata('booking_success')): ?>
        <!-- ===== SUCCESS STATE ===== -->
        <div class="text-center py-5" style="max-width:560px; margin:0 auto;">
            <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#059669,#10b981);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;box-shadow:0 8px 24px -6px rgba(5,150,105,0.35);">
                <span class="material-symbols-outlined" style="font-size:2.5rem;color:#fff;">check_circle</span>
            </div>
            <h2 style="font-family:'Public Sans',sans-serif;font-weight:800;font-size:1.6rem;color:var(--on-surface);margin-bottom:0.5rem;">Booking Berhasil!</h2>
            <p style="font-size:0.9rem;color:var(--on-surface-variant);margin-bottom:1.5rem;">Pesanan Anda telah dikirim dan sedang menunggu konfirmasi admin.</p>
            <div style="background:var(--surface-container);border:1px solid var(--outline-variant);border-radius:1rem;padding:1.25rem 1.5rem;margin-bottom:1.5rem;">
                <span style="font-size:0.75rem;font-weight:600;color:var(--on-surface-variant);text-transform:uppercase;letter-spacing:0.06em;">Kode Booking Anda</span>
                <div style="font-family:'Courier New',monospace;font-size:1.8rem;font-weight:800;color:var(--primary);letter-spacing:0.03em;margin-top:0.25rem;">
                    <?= session()->getFlashdata('kode_sewa') ?>
                </div>
                <p style="font-size:0.72rem;color:var(--outline);margin-top:0.5rem;margin-bottom:0;">Simpan kode ini untuk mengecek status booking Anda</p>
            </div>
            <div style="display:flex;gap:0.75rem;justify-content:center;flex-wrap:wrap;">
                <a href="<?= base_url('/') ?>" class="bf-submit-btn" style="text-decoration:none;font-size:0.85rem;padding:0.65rem 1.5rem;">
                    <span class="material-symbols-outlined" style="font-size:1.1rem;">home</span>
                    Kembali ke Jadwal
                </a>
            </div>
        </div>
        <?php else: ?>
        <!-- ===== FORM STATE ===== -->

        <!-- Error Alert -->
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2" role="alert" style="border-radius:0.85rem;font-size:0.85rem;font-weight:600;max-width:900px;margin:0 auto 1rem;">
            <span class="material-symbols-outlined" style="font-size:1.2rem;">error</span>
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <!-- Back Button -->
        <a href="<?= base_url('/') ?>" class="booking-back-btn">
            <span class="material-symbols-outlined" style="font-size:1.1rem;">arrow_back</span>
            Kembali ke Jadwal
        </a>

        <!-- Section Header -->
        <div class="text-center mb-5">
            <div class="section-chip mx-auto mb-3">
                <span class="material-symbols-outlined" style="font-size:1rem;">edit_calendar</span>
                Formulir Booking
            </div>
            <h2 class="schedule-heading">Booking Lapangan</h2>
            <p class="schedule-subheading mt-3">Lengkapi formulir di bawah untuk melakukan pemesanan lapangan</p>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- Left Column: Booking Summary Card & Calendar Schedule Selection -->
            <div class="col-12 col-lg-5">
                <!-- 1. Booking Summary -->
                <div class="bf-summary-card">
                    <div class="bf-summary-header">
                        <span class="material-symbols-outlined" style="font-size:1.5rem;">receipt_long</span>
                        <span>Ringkasan Booking</span>
                    </div>
                    <div class="bf-summary-body">
                        <!-- Lapang Info -->
                        <div class="bf-summary-item">
                            <div class="bf-summary-icon">
                                <span class="material-symbols-outlined">stadium</span>
                            </div>
                            <div>
                                <span class="bf-summary-label">Lapangan</span>
                                <span class="bf-summary-value" id="summaryLapang">-</span>
                            </div>
                        </div>
                        <!-- Date Info -->
                        <div class="bf-summary-item">
                            <div class="bf-summary-icon">
                                <span class="material-symbols-outlined">calendar_today</span>
                            </div>
                            <div>
                                <span class="bf-summary-label">Tanggal</span>
                                <span class="bf-summary-value" id="summaryTanggal">-</span>
                            </div>
                        </div>
                        <!-- Time Info -->
                        <div class="bf-summary-item">
                            <div class="bf-summary-icon">
                                <span class="material-symbols-outlined">schedule</span>
                            </div>
                            <div>
                                <span class="bf-summary-label">Jam</span>
                                <span class="bf-summary-value" id="summaryJam">-</span>
                            </div>
                        </div>
                        <!-- Duration -->
                        <div class="bf-summary-item">
                            <div class="bf-summary-icon">
                                <span class="material-symbols-outlined">timer</span>
                            </div>
                            <div>
                                <span class="bf-summary-label" id="summaryDurasiLabel">Durasi Bermain</span>
                                <span class="bf-summary-value" id="summaryDurasi">-</span>
                            </div>
                        </div>

                        <!-- Membership Dates (hidden by default) -->
                        <div class="bf-summary-item" id="summaryMembershipDates" style="display:none;">
                            <div class="bf-summary-icon" style="background:#ecfdf5; align-self:flex-start;">
                                <span class="material-symbols-outlined" style="color:#059669;">event_repeat</span>
                            </div>
                            <div>
                                <span class="bf-summary-label">Jadwal 4 Sesi</span>
                                <div id="membershipDatesList" style="margin-top:0.3rem;"></div>
                            </div>
                        </div>

                        <!-- Membership Discount Info (hidden by default) -->
                        <div id="summaryDiskonWrap" style="display:none; background:#ecfdf5; border:1px solid #a7f3d0; border-radius:0.6rem; padding:0.6rem 0.85rem; margin-top:0.5rem;">
                            <div style="display:flex; align-items:center; gap:0.35rem; font-size:0.75rem; font-weight:700; color:#059669; margin-bottom:0.25rem;">
                                <span class="material-symbols-outlined" style="font-size:0.95rem;">loyalty</span>
                                Diskon Membership 10%
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:0.75rem; color:#64748b;">
                                <span>Harga Normal</span>
                                <span style="text-decoration:line-through;" id="summaryHargaNormal">Rp -</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:0.75rem; color:#059669; font-weight:600;">
                                <span>Anda Hemat</span>
                                <span id="summaryHargaHemat">- Rp 0</span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <hr style="border-color:var(--outline-variant); margin:0.75rem 0;">

                        <!-- Price -->
                        <div class="bf-summary-price">
                            <span>Total Estimasi</span>
                            <span class="bf-summary-price-value" id="summaryHarga">Rp -</span>
                        </div>

                        <!-- Pilihan Pembayaran -->
                        <div id="summaryPaymentType" style="display:none; margin-top:0.6rem;">
                            <hr style="border-color:var(--outline-variant); margin:0 0 0.6rem 0;">
                            <label style="font-size:0.78rem; font-weight:600; color:var(--on-surface); display:flex; align-items:center; gap:0.3rem; margin-bottom:0.4rem;">
                                <span class="material-symbols-outlined" style="font-size:1rem;">payments</span>
                                Metode Pembayaran
                            </label>
                            <div style="display:flex; gap:0.5rem;">
                                <label style="flex:1; display:flex; align-items:center; gap:0.4rem; padding:0.5rem 0.65rem; border-radius:0.5rem; border:2px solid var(--outline-variant); cursor:pointer; font-size:0.78rem; font-weight:500; transition:all .2s;" id="labelBayarFull">
                                    <input type="radio" name="bayar_type" value="Full" checked style="accent-color:var(--primary);" onchange="updatePaymentType()">
                                    <div>
                                        <div style="font-weight:600;">Bayar Full</div>
                                        <div style="font-size:0.7rem; color:var(--on-surface-variant);">100% lunas</div>
                                    </div>
                                </label>
                                <label style="flex:1; display:flex; align-items:center; gap:0.4rem; padding:0.5rem 0.65rem; border-radius:0.5rem; border:2px solid var(--outline-variant); cursor:pointer; font-size:0.78rem; font-weight:500; transition:all .2s;" id="labelBayarDP">
                                    <input type="radio" name="bayar_type" value="DP" style="accent-color:var(--primary);" onchange="updatePaymentType()">
                                    <div>
                                        <div style="font-weight:600;">Bayar DP</div>
                                        <div style="font-size:0.7rem; color:var(--on-surface-variant);">50% dari total</div>
                                    </div>
                                </label>
                            </div>
                            <div id="summaryDPInfo" style="display:none; background:#fff7ed; border:1px solid #fed7aa; border-radius:0.5rem; padding:0.5rem 0.65rem; margin-top:0.5rem;">
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; color:#9a3412;">
                                    <span>Yang harus dibayar (DP 50%)</span>
                                    <span style="font-weight:700;" id="summaryDPAmount">Rp -</span>
                                </div>
                                <div style="display:flex; justify-content:space-between; font-size:0.7rem; color:#c2410c; margin-top:0.15rem;">
                                    <span>Sisa pelunasan di tempat</span>
                                    <span id="summarySisaAmount">Rp -</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Calendar -->
                <div class="cal-card mb-4 mt-4">
                    <!-- Calendar Header -->
                    <div class="cal-header">
                        <button type="button" class="cal-nav-btn" id="calPrev" aria-label="Bulan sebelumnya">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                        <span class="cal-month-label" id="calMonthLabel">...</span>
                        <button type="button" class="cal-nav-btn" id="calNext" aria-label="Bulan berikutnya">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>

                    <!-- Day-of-week labels -->
                    <div class="cal-grid cal-dow">
                        <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                    </div>

                    <!-- Date cells -->
                    <div class="cal-grid cal-dates" id="calDates"></div>

                    <!-- Legend -->
                    <div class="cal-legend">
                        <div class="cal-legend-item">
                            <span class="cal-legend-dot cal-legend-dot--available"></span>
                            <span>Tersedia</span>
                        </div>
                        <div class="cal-legend-item">
                            <span class="cal-legend-dot cal-legend-dot--partial"></span>
                            <span>Sebagian</span>
                        </div>
                        <div class="cal-legend-item">
                            <span class="cal-legend-dot cal-legend-dot--full"></span>
                            <span>Penuh</span>
                        </div>
                        <div class="cal-legend-item">
                            <span class="cal-legend-dot cal-legend-dot--today"></span>
                            <span>Hari ini</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Lapang Cards (hidden until date selected) -->
                <div id="lapangSection" style="display:none; margin-bottom: 2rem;">
                    <!-- Results Header -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                        <div>
                            <h3 class="results-title mb-1" style="font-size:1.25rem;">Jadwal Tersedia</h3>
                            <p class="results-subtitle mb-0" id="lapangDateLabel" style="font-size:0.8rem;">
                                <span class="material-symbols-outlined"
                                    style="font-size:.95rem;vertical-align:-3px;">today</span>
                                Pilih tanggal di kalender
                            </p>
                        </div>
                        <div class="results-count" id="slotSummary" style="display:none; padding: 0.35rem 0.75rem; font-size: 0.75rem;">
                            <span class="material-symbols-outlined" style="font-size:0.9rem;">check_circle</span>
                            <span id="slotSummaryText"></span>
                        </div>
                    </div>

                    <!-- Loading indicator -->
                    <div id="lapangLoading" class="text-center py-4" style="display:none;">
                        <div class="spinner-border text-primary" role="status" style="width:2rem; height:2rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2" style="font-size:.85rem; color:var(--on-surface-variant);">Memuat jadwal...</p>
                    </div>

                    <!-- Dynamic Lapang Cards Container -->
                    <div class="row g-4" id="lapangCards"></div>

                    <!-- Empty state -->
                    <div id="lapangEmpty" class="text-center py-5" style="display:none;">
                        <span class="material-symbols-outlined" style="font-size:2.5rem; color:var(--outline);">event_busy</span>
                        <p class="mt-2" style="font-size:.85rem; color:var(--on-surface-variant); font-weight:500;">Tidak ada lapangan tersedia saat ini.</p>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="bf-info-alert mt-3">
                    <span class="material-symbols-outlined" style="font-size:1.2rem; flex-shrink:0;">info</span>
                    <div>
                        <strong>Informasi</strong>
                        <p class="mb-0 mt-1" style="font-size:.78rem; line-height:1.5;">Harga dapat berubah tergantung
                            jam dan hari yang dipilih. Pembayaran dilakukan di tempat pada saat bermain.</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Booking Form -->
            <div class="col-12 col-lg-6">
                <div class="bf-form-card">
                    <div class="bf-form-header">
                        <span class="material-symbols-outlined" style="font-size:1.35rem;">person</span>
                        <span>Data Pemesan</span>
                    </div>
                    <div class="bf-form-body">
                        <form id="bookingForm" action="<?= base_url('/booking') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <!-- Hidden fields for booking data -->
                            <input type="hidden" name="id_lapang" id="formIdLapang">
                            <input type="hidden" name="tanggal_main" id="formTanggal">
                            <input type="hidden" name="jam_mulai" id="formJam">
                            <input type="hidden" name="total_bayar" id="formTotalBayar">
                            <input type="hidden" name="tipe_sewa" id="formTipeSewa" value="Per Jam">
                            <input type="hidden" name="jumlah_hari" id="formJumlahHari" value="1">
                            <input type="hidden" name="jenis_pembayaran" id="formJenisPembayaran" value="Full">
                            <input type="hidden" name="items_json" id="formItemsJson">

                            <!-- Jenis Sewa Selector -->
                            <div class="bf-field sewa-selector mb-4">
                                <label class="bf-field-label" style="margin-bottom:.75rem;">
                                    <span class="material-symbols-outlined bf-field-label-icon">category</span>
                                    Pilih Jenis Sewa
                                </label>
                                <div class="sewa-pills">
                                    <button type="button" class="sewa-pill sewa-pill--active" data-sewa="per-jam"
                                        onclick="setSewa('per-jam')">
                                        <span class="material-symbols-outlined">schedule</span>
                                        <div>
                                            <span class="sewa-pill__title">Per Jam</span>
                                            <span class="sewa-pill__desc">Sewa per jam</span>
                                        </div>
                                    </button>
                                    <button type="button" class="sewa-pill" data-sewa="per-hari" onclick="setSewa('per-hari')">
                                        <span class="material-symbols-outlined">today</span>
                                        <div>
                                            <span class="sewa-pill__title">Per Hari</span>
                                            <span class="sewa-pill__desc">Full 1 hari</span>
                                        </div>
                                    </button>
                                    <button type="button" class="sewa-pill" data-sewa="membership" onclick="setSewa('membership')">
                                        <span class="material-symbols-outlined">card_membership</span>
                                        <div>
                                            <span class="sewa-pill__title">Membership</span>
                                            <span class="sewa-pill__desc">Diskon 10%</span>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="bf-field">
                                <label for="formNama" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">badge</span>
                                    Nama Lengkap
                                </label>
                                <div class="bf-input-wrap">
                                    <span class="material-symbols-outlined bf-input-icon">person</span>
                                    <input type="text" id="formNama" name="nama" class="bf-input"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <!-- No. WhatsApp -->
                            <div class="bf-field">
                                <label for="formWhatsapp" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">call</span>
                                    No. WhatsApp
                                </label>
                                <div class="bf-input-wrap">
                                    <span class="material-symbols-outlined bf-input-icon">phone_android</span>
                                    <input type="tel" id="formWhatsapp" name="whatsapp" class="bf-input"
                                        placeholder="08xxxxxxxxxx" required>
                                </div>
                            </div>

                            <!-- Email (Optional) -->
                            <div class="bf-field">
                                <label for="formEmail" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">mail</span>
                                    Email <span style="font-weight:400; opacity:.6;">(Opsional)</span>
                                </label>
                                <div class="bf-input-wrap">
                                    <span class="material-symbols-outlined bf-input-icon">mail</span>
                                    <input type="email" id="formEmail" name="email" class="bf-input"
                                        placeholder="email@contoh.com">
                                </div>
                            </div>

                            <!-- ═══════════════════════════════════════════ -->
                            <!--  CART ITEM LIST (Per Jam & Harian)        -->
                            <!-- ═══════════════════════════════════════════ -->
                            <div id="cartSection">
                                <hr style="border-color:var(--outline-variant); margin:1rem 0;">
                                <div style="display:flex;align-items:center;gap:0.4rem;margin-bottom:0.75rem;">
                                    <span class="material-symbols-outlined" style="font-size:1.1rem;color:var(--primary);">shopping_cart</span>
                                    <span style="font-size:0.85rem;font-weight:700;color:var(--on-surface);">Keranjang Booking Anda</span>
                                </div>

                                <!-- Cart Items List -->
                                <div id="cartItemsList" style="margin-top:0.75rem;"></div>

                                <!-- Cart Empty Notice -->
                                <div id="cartEmptyNotice" style="text-align:center;padding:1rem;color:var(--on-surface-variant);font-size:0.8rem;">
                                    <span class="material-symbols-outlined" style="font-size:1.5rem;display:block;margin-bottom:0.25rem;opacity:0.4;">shopping_cart</span>
                                    Belum ada item di keranjang. Silakan pilih jadwal di kalender dan kartu di atas.
                                </div>
                            </div>

                            <!-- ═══════════════════════════════════════════ -->
                            <!--  SINGLE-ITEM FIELDS (Membership)          -->
                            <!-- ═══════════════════════════════════════════ -->
                            <div id="singleItemSection" style="display:none;">
                                <div class="bf-field" id="fieldDurasiWrap">
                                    <label for="formDurasi" class="bf-field-label">
                                        <span class="material-symbols-outlined bf-field-label-icon">timer</span>
                                        <span id="labelDurasiText">Durasi Bermain</span>
                                    </label>
                                    <div class="bf-input-wrap">
                                        <span class="material-symbols-outlined bf-input-icon">schedule</span>
                                        <input type="number" id="formDurasi" name="durasi" class="bf-input" min="1" value="1">
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="bf-field">
                                <label for="formCatatan" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">notes</span>
                                    Catatan <span style="font-weight:400; opacity:.6;">(Opsional)</span>
                                </label>
                                <div class="bf-input-wrap bf-input-wrap--textarea">
                                    <textarea id="formCatatan" name="catatan" class="bf-input bf-textarea" rows="3"
                                        placeholder="Catatan tambahan... (contoh: minta bola, dll)"></textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="button" class="bf-submit-btn" id="btnSubmitBooking" data-bs-toggle="modal"
                                data-bs-target="#petunjukBayarModal">
                                <span class="material-symbols-outlined" style="font-size:1.2rem;">check_circle</span>
                                Booking Sekarang
                            </button>

                            <p class="bf-terms">
                                Dengan menekan tombol di atas, Anda menyetujui
                                <a href="#">syarat &amp; ketentuan</a> yang berlaku.
                            </p>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
        <?php endif; ?>

<!-- ===== MODAL: PETUNJUK PEMBAYARAN ===== -->
<div class="modal fade" id="petunjukBayarModal" tabindex="-1" aria-labelledby="petunjukBayarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered pbm-dialog">
        <div class="modal-content pbm-content">

            <!-- Header -->
            <div class="modal-header pbm-header">
                <h5 class="modal-title pbm-title" id="petunjukBayarLabel">
                    <span class="material-symbols-outlined">payments</span>
                    Petunjuk Pembayaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body pbm-body">

                <!-- 1. TOTAL YANG HARUS DIBAYAR -->
                <div class="pbm-total-box">
                    <p class="pbm-total-label">Total Pembayaran</p>
                    <p class="pbm-total-amount" id="pbmTotalAmount">Rp 75.000</p>
                    <p class="pbm-total-sub" id="pbmBookingSub">—</p>
                </div>

                <!-- 2. INFO REKENING -->
                <div class="pbm-section">
                    <div class="pbm-section-title">
                        <span class="material-symbols-outlined">account_balance</span>
                        Transfer Bank
                    </div>
                    <div class="pbm-bank-card">
                        <div class="pbm-bank-logo">
                            <span class="material-symbols-outlined">credit_card</span>
                        </div>
                        <div class="pbm-bank-info">
                            <p class="pbm-bank-name">Bank BCA</p>
                            <p class="pbm-bank-norek">1234567890</p>
                            <p class="pbm-bank-an">a.n <strong>Carrera Futsal</strong></p>
                        </div>
                        <button type="button" class="pbm-copy-btn" id="pbmCopyBtn" title="Salin nomor rekening">
                            <span class="material-symbols-outlined">content_copy</span>
                        </button>
                    </div>
                </div>

                <!-- 3. LANGKAH-LANGKAH -->
                <div class="pbm-section">
                    <div class="pbm-section-title">
                        <span class="material-symbols-outlined">format_list_numbered</span>
                        Instruksi Pembayaran
                    </div>
                    <ol class="pbm-steps">
                        <li class="pbm-step">
                            <span class="pbm-step-num">1</span>
                            <span>Transfer sesuai nominal yang tertera</span>
                        </li>
                        <li class="pbm-step">
                            <span class="pbm-step-num">2</span>
                            <span>Simpan bukti transfer / screenshot</span>
                        </li>
                        <li class="pbm-step">
                            <span class="pbm-step-num">3</span>
                            <span>Upload bukti pembayaran di bawah ini</span>
                        </li>
                        <li class="pbm-step">
                            <span class="pbm-step-num">4</span>
                            <span>Tunggu konfirmasi dari admin</span>
                        </li>
                    </ol>
                </div>

                <!-- 4. UPLOAD BUKTI -->
                <div class="pbm-section">
                    <div class="pbm-section-title">
                        <span class="material-symbols-outlined">attach_file</span>
                        Upload Bukti Pembayaran
                    </div>
                    <div class="pbm-upload-zone" id="pbmUploadZone">
                        <input type="file" id="pbmFileInput" name="bukti_bayar" accept="image/*" style="display:none;" form="bookingForm">
                        <span class="material-symbols-outlined pbm-upload-icon">cloud_upload</span>
                        <p class="pbm-upload-text">Klik untuk pilih file</p>
                        <p class="pbm-upload-hint">JPG, PNG — Maks 2MB</p>
                    </div>
                    <div id="pbmPreviewWrap" style="display:none; margin-top:0.75rem; text-align:center;">
                        <img id="pbmPreviewImg" src="" alt="Preview"
                            style="max-height:130px; border-radius:0.6rem; border:2px solid #a7f3d0; box-shadow:0 4px 12px -4px rgba(0,0,0,0.15);">
                        <div style="margin-top:0.4rem;">
                            <button type="button" id="pbmRemoveFile" class="pbm-remove-btn">
                                <span class="material-symbols-outlined">delete</span> Hapus
                            </button>
                        </div>
                    </div>
                </div>

            </div><!-- /modal-body -->

            <!-- Footer -->
            <div class="modal-footer pbm-footer">
                <button type="button" class="pbm-btn-batal" data-bs-dismiss="modal">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Kembali
                </button>
                <button type="button" class="pbm-btn-kirim" id="pbmBtnKirim">
                    <span class="material-symbols-outlined">send</span>
                    Konfirmasi &amp; Kirim
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ═══ MODAL: Info Membership ═══ -->
<div class="modal fade" id="membershipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
        <div class="modal-content"
            style="border-radius:1.25rem;overflow:hidden;border:none;box-shadow:0 20px 60px -10px rgba(0,0,0,.25);">
            <div class="modal-header"
                style="background:linear-gradient(135deg,#059669,#10b981);border:none;padding:1.1rem 1.5rem;">
                <h5 class="modal-title"
                    style="color:#fff;font-size:1rem;font-weight:700;display:flex;align-items:center;gap:.5rem;margin:0;">
                    <span class="material-symbols-outlined" style="font-size:1.25rem;">card_membership</span> Sewa
                    Membership
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:1.5rem;">
                <div
                    style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);border-radius:1rem;padding:1.25rem;margin-bottom:1.25rem;text-align:center;">
                    <span class="material-symbols-outlined" style="font-size:3rem;color:#059669;">loyalty</span>
                    <h5 style="font-weight:800;font-size:1.1rem;color:#065f46;margin:.75rem 0 .25rem;">Potongan Harga
                        10%</h5>
                    <p style="font-size:.8rem;color:#047857;margin:0;">dari total harga sewa selama 1 bulan</p>
                </div>
                <div style="font-size:.85rem;color:#334155;line-height:1.7;">
                    <p style="margin-bottom:.75rem;"><strong>Ketentuan Membership:</strong></p>
                    <ul style="padding-left:1.2rem;margin:0;">
                        <li>Booking berlaku selama <strong>1 bulan penuh</strong></li>
                        <li>Jadwal bermain <strong>1 minggu 1 kali</strong> (hari yang sama)</li>
                        <li>Anda mendapat <strong>diskon 10%</strong> dari total harga sewa</li>
                    </ul>
                    <div
                        style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:.75rem;padding:1rem;margin-top:1rem;">
                        <p style="margin:0;font-size:.8rem;color:#0369a1;"><span class="material-symbols-outlined"
                                style="font-size:1rem;vertical-align:-3px;margin-right:.25rem;">info</span>
                            <strong>Contoh:</strong> Anda booking hari <strong>Minggu, 17 Mei 2026</strong>, maka jadwal
                            bermain Anda:
                            <strong>17 Mei, 24 Mei, 31 Mei,</strong> dan <strong>7 Juni 2026</strong> (4 sesi).
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer"
                style="background:#fff;border-top:1px solid #e2e8f0;padding:.85rem 1rem;gap:.5rem;justify-content:flex-end;">
                <button type="button" class="dbm-btn-tutup" data-bs-dismiss="modal"
                    style="display:inline-flex;align-items:center;gap:.35rem;padding:.55rem 1.25rem;border-radius:.65rem;font-size:.82rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;background:#f1f5f9;color:#475569;">
                    <span class="material-symbols-outlined" style="font-size:1rem;">close</span> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== CSS PETUNJUK BAYAR MODAL ===== -->
<style>
    .pbm-content {
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
    }

    .pbm-header {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: #fff;
        border-bottom: none;
        padding: 1.25rem 1.5rem;
    }

    .pbm-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
    }

    .pbm-title .material-symbols-outlined {
        font-size: 1.4rem;
        color: #38bdf8;
    }

    .pbm-body {
        padding: 1.5rem;
        background: #f8fafc;
    }

    .pbm-total-box {
        background: linear-gradient(135deg, #059669, #10b981);
        color: #fff;
        border-radius: 1rem;
        padding: 1.25rem;
        text-align: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
    }

    .pbm-total-label {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        opacity: 0.9;
        margin-bottom: 0.25rem;
    }

    .pbm-total-amount {
        font-family: 'Inter', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .pbm-total-sub {
        font-size: 0.8rem;
        opacity: 0.8;
        margin: 0.25rem 0 0 0;
    }

    .pbm-section {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .pbm-section-title {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
    }

    .pbm-section-title .material-symbols-outlined {
        font-size: 1.2rem;
        color: #64748b;
    }

    .pbm-bank-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f1f5f9;
        padding: 1rem;
        border-radius: 0.75rem;
        border: 1px dashed #cbd5e1;
    }

    .pbm-bank-logo {
        width: 45px;
        height: 45px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .pbm-bank-logo .material-symbols-outlined {
        font-size: 1.5rem;
        color: #0284c7;
    }

    .pbm-bank-info {
        flex: 1;
    }

    .pbm-bank-name {
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
        margin: 0;
    }

    .pbm-bank-norek {
        font-family: 'Courier New', Courier, monospace;
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0.15rem 0;
        letter-spacing: 0.05em;
    }

    .pbm-bank-an {
        font-size: 0.75rem;
        color: #475569;
        margin: 0;
    }

    .pbm-copy-btn {
        background: #e0f2fe;
        color: #0284c7;
        border: none;
        border-radius: 0.5rem;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pbm-copy-btn:hover {
        background: #bae6fd;
        transform: scale(1.05);
    }

    .pbm-steps {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .pbm-step {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        font-size: 0.85rem;
        color: #334155;
        line-height: 1.4;
    }

    .pbm-step-num {
        width: 22px;
        height: 22px;
        background: #e2e8f0;
        color: #475569;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .pbm-upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 0.75rem;
        padding: 1.5rem;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pbm-upload-zone:hover {
        border-color: #38bdf8;
        background: #f0f9ff;
    }

    .pbm-upload-icon {
        font-size: 2rem;
        color: #94a3b8;
        margin-bottom: 0.5rem;
        transition: color 0.2s;
    }

    .pbm-upload-zone:hover .pbm-upload-icon {
        color: #0284c7;
    }

    .pbm-upload-text {
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        margin: 0 0 0.25rem 0;
    }

    .pbm-upload-hint {
        font-size: 0.75rem;
        color: #94a3b8;
        margin: 0;
    }

    .pbm-remove-btn {
        background: #fee2e2;
        color: #dc2626;
        border: none;
        border-radius: 0.5rem;
        padding: 0.4rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pbm-remove-btn:hover {
        background: #fca5a5;
    }

    .pbm-remove-btn .material-symbols-outlined {
        font-size: 1rem;
    }

    .pbm-footer {
        background: #fff;
        border-top: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        gap: 1rem;
    }

    .pbm-btn-batal {
        background: #f1f5f9;
        color: #475569;
        border: none;
        border-radius: 0.75rem;
        padding: 0.65rem 1.25rem;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pbm-btn-batal:hover {
        background: #e2e8f0;
    }

    .pbm-btn-kirim {
        background: linear-gradient(135deg, #0284c7, #0369a1);
        color: #fff;
        border: none;
        border-radius: 0.75rem;
        padding: 0.65rem 1.5rem;
        font-size: 0.85rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px -2px rgba(2, 132, 199, 0.3);
    }

    .pbm-btn-kirim:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px -2px rgba(2, 132, 199, 0.4);
    }
</style>

<!-- Timeslot / Card Styling from index.php -->
<style>
    .timeslot-box--past {
        opacity: 0.35;
        cursor: not-allowed;
        background: var(--surface-container);
        border-color: transparent;
    }

    .timeslot-box--past:hover {
        transform: none;
        box-shadow: none;
        border-color: transparent;
    }

    .lapang-card__subtitle {
        font-family: 'Public Sans', sans-serif;
        font-size: 0.68rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.75);
        letter-spacing: 0.03em;
        margin-top: 0.15rem;
    }

    .lapang-card__stats {
        display: flex;
        gap: 1rem;
        padding: 0.5rem 1rem;
        background: var(--surface-container-low);
        border-bottom: 1px solid var(--outline-variant);
        font-family: 'Public Sans', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--on-surface-variant);
    }

    .lapang-card__stat {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .lapang-card__stat .material-symbols-outlined {
        font-size: 0.85rem;
    }

    .stat--available {
        color: #059669;
    }

    .stat--booked {
        color: #dc2626;
    }

    /* ===== TIMESLOT STATUS BADGE ===== */
    .timeslot-badge {
        font-family: 'Public Sans', sans-serif;
        font-size: 0.55rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.1rem 0.4rem;
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

    /* ===== CALENDAR AVAILABILITY DOT ===== */
    .cal-cell {
        position: relative;
    }

    .cal-avail-dot {
        display: block;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        margin: 2px auto 0;
    }

    .cal-avail-dot--available {
        background: #059669;
    }

    .cal-avail-dot--partial {
        background: #f59e0b;
    }

    .cal-avail-dot--full {
        background: #dc2626;
    }

    /* Past date styling for calendar */
    .cal-cell--past {
        opacity: 0.35;
        cursor: not-allowed !important;
        pointer-events: none;
    }

    .cal-cell--past .cal-cell__num {
        text-decoration: line-through;
    }

    /* Legend extra: partial indicator */
    .cal-legend-dot--partial {
        background: #f59e0b;
    }

    /* ===== SEWA PILLS ===== */
    .sewa-selector {
        width: 100%;
    }

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
        background: var(--surface-container-lowest);
        border: 1.5px solid var(--outline-variant);
        border-radius: 0.75rem;
        text-align: left;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sewa-pill:hover {
        border-color: var(--primary-fixed-dim);
        background: var(--surface-container-low);
    }

    .sewa-pill--active {
        border-color: var(--primary);
        background: color-mix(in srgb, var(--primary) 8%, transparent);
        box-shadow: 0 4px 12px -2px rgba(0,87,205,0.08);
    }

    .sewa-pill .material-symbols-outlined {
        font-size: 1.6rem;
        color: var(--on-surface-variant);
    }

    .sewa-pill--active .material-symbols-outlined {
        color: var(--primary);
    }

    .sewa-pill__title {
        display: block;
        font-family: 'Inter', sans-serif;
        font-size: .8rem;
        font-weight: 700;
        color: var(--on-surface);
    }

    .sewa-pill__desc {
        display: block;
        font-family: 'Public Sans', sans-serif;
        font-size: .65rem;
        font-weight: 500;
        color: var(--on-surface-variant);
        margin-top: .1rem;
    }

    /* ===== DAILY CARD ===== */
    .daily-card {
        background: var(--surface-container-lowest);
        border: 1.5px solid var(--outline-variant);
        border-radius: 1.25rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        transition: transform .25s ease, border-color .2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .daily-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .daily-card--selected {
        border-color: var(--primary) !important;
        box-shadow: 0 10px 25px rgba(0, 87, 205, 0.15) !important;
    }

    .daily-card__header {
        padding: 1rem 1.25rem;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .daily-card__header .material-symbols-outlined {
        font-size: 1.8rem;
    }

    .daily-card__title {
        font-family: 'Inter', sans-serif;
        font-weight: 800;
        font-size: 1.05rem;
        letter-spacing: -0.02em;
    }

    .daily-card__subtitle {
        font-family: 'Public Sans', sans-serif;
        font-size: .68rem;
        font-weight: 600;
        color: rgba(255,255,255,0.85);
        margin-top: .1rem;
    }

    .daily-card__body {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: .75rem;
    }

    .daily-card__info {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-family: 'Public Sans', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--on-surface-variant);
    }

    .daily-card__info .material-symbols-outlined {
        font-size: 0.95rem;
        color: var(--primary);
    }

    .daily-card__btn {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        width: 100%;
        padding: .65rem;
        background: linear-gradient(135deg, var(--primary) 0%, #0d6efd 100%);
        border: none;
        color: #fff;
        border-radius: .65rem;
        text-decoration: none;
        font-weight: 700;
        font-size: .8rem;
        transition: all .2s;
        cursor: pointer;
    }

    .daily-card__btn:hover {
        opacity: .95;
        box-shadow: 0 4px 12px rgba(13,110,253,0.3);
        color: #fff;
    }
</style>

<script>
    (function () {
        const MONTH_NAMES = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        const DAY_NAMES = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // API URLs
        const API_LAPANGS = '<?= base_url("/api/getLapangs") ?>';
        const API_BOOKED = '<?= base_url("/api/getBookedSlots") ?>';
        const API_MONTH = '<?= base_url("/api/getMonthBookings") ?>';
        const API_TARIF = '<?= base_url("/api/getTarif") ?>';

        // Summary elements
        const sumLapang = document.getElementById('summaryLapang');
        const sumTanggal = document.getElementById('summaryTanggal');
        const sumJam = document.getElementById('summaryJam');
        const sumDurasi = document.getElementById('summaryDurasi');
        const sumHarga = document.getElementById('summaryHarga');

        // Hidden form fields
        const fIdLapang = document.getElementById('formIdLapang');
        const fTanggal = document.getElementById('formTanggal');
        const fJam = document.getElementById('formJam');
        const fTotalBayar = document.getElementById('formTotalBayar');
        const fTipeSewa = document.getElementById('formTipeSewa');
        const fJumlahHari = document.getElementById('formJumlahHari');
        const fItemsJson = document.getElementById('formItemsJson');

        // Form inputs
        const formDurasi = document.getElementById('formDurasi');
        const labelDurasiText = document.getElementById('labelDurasiText');
        const summaryDurasiLabel = document.getElementById('summaryDurasiLabel');

        // Calendar state
        const today = new Date();
        let currentYear = today.getFullYear();
        let currentMonth = today.getMonth();
        let selectedDate = null;
        let sewaMode = 'per-jam'; // 'per-jam' | 'per-hari' | 'membership'

        // Selected items state
        let lapangsData = [];
        let bookedSlotsData = {};
        let monthBookingsData = {};
        let cartItems = []; // for 'per-jam'
        let selectedHarianCourtId = null; // for 'per-hari'
        let selectedMembershipSlot = null; // for 'membership'

        const todayStr = `${today.getFullYear()}-${pad(today.getMonth() + 1)}-${pad(today.getDate())}`;

        function pad(n) { return String(n).padStart(2, '0'); }
        function dateStr(y, m, d) { return `${y}-${pad(m + 1)}-${pad(d)}`; }

        function isPastSlot(ds, hour) {
            if (ds !== todayStr) return false;
            return hour <= today.getHours();
        }

        function getOperatingHours(lapang, ds) {
            const dt = new Date(ds);
            const dow = dt.getDay();
            const isWeekend = (dow === 0 || dow === 6);
            const jamBuka = parseInt(isWeekend ? lapang.jam_buka_weekend : lapang.jam_buka_weekday) || 0;
            let jamTutup = parseInt(isWeekend ? lapang.jam_tutup_weekend : lapang.jam_tutup_weekday) || 0;
            if (jamTutup <= jamBuka) jamTutup = 24;
            return { jamBuka, jamTutup, isWeekend };
        }

        // Read URL query params
        const urlParams = new URLSearchParams(window.location.search);
        const paramLapang = urlParams.get('lapang');
        const paramTanggal = urlParams.get('tanggal');
        const paramJam = urlParams.get('jam');
        const paramSewa = urlParams.get('sewa'); // 'per-jam' | 'per-hari' | 'membership'

        // Set initial mode from URL param
        if (paramSewa === 'per-hari' || paramSewa === 'membership' || paramSewa === 'per-jam') {
            sewaMode = paramSewa;
        }

        // Helper: map JS sewaMode to DB tipe_sewa value
        function getTipeSewa() {
            return sewaMode === 'per-hari' ? 'Harian' : (sewaMode === 'membership' ? 'Membership' : 'Per Jam');
        }

        // Set initial date from URL param
        if (paramTanggal) {
            selectedDate = paramTanggal;
            const parts = paramTanggal.split('-');
            currentYear = parseInt(parts[0]);
            currentMonth = parseInt(parts[1]) - 1;
        }

        // ─── Fetch lapangs from API ───
        async function loadLapangs() {
            try {
                const res = await fetch(API_LAPANGS);
                lapangsData = await res.json();

                // Once loaded, process preselected values
                if (paramLapang && paramTanggal) {
                    const found = lapangsData.find(l => l.nama_lapangan === paramLapang);
                    if (found) {
                        if (sewaMode === 'per-jam' && paramJam) {
                            const jamFormatted = paramJam.split('.')[0].padStart(2, '0') + ':00';
                            const harga = await getCartItemPrice(found.id_lapang, paramTanggal, jamFormatted, 1);
                            cartItems = [{
                                id_lapang: found.id_lapang,
                                nama_lapang: found.nama_lapangan,
                                tanggal: paramTanggal,
                                jam_mulai: jamFormatted,
                                durasi: 1,
                                harga: harga
                            }];
                            renderCart();
                        } else if (sewaMode === 'per-hari') {
                            const { jamBuka } = getOperatingHours(found, paramTanggal);
                            try {
                                const res = await fetch(`${API_TARIF}?id_lapang=${found.id_lapang}&tanggal=${paramTanggal}`);
                                const data = await res.json();
                                const tarifs = data.tarifs || [];
                                const harianTarif = tarifs.find(t => parseInt(t.harga_harian) > 0);
                                const hargaHarian = harianTarif ? parseInt(harianTarif.harga_harian) : 0;
                                cartItems = [{
                                    id_lapang: found.id_lapang,
                                    nama_lapang: found.nama_lapangan,
                                    tanggal: paramTanggal,
                                    jam_mulai: pad(jamBuka) + ':00',
                                    durasi: 1,
                                    harga_satuan: hargaHarian,
                                    harga: hargaHarian
                                }];
                            } catch(e) {
                                cartItems = [{
                                    id_lapang: found.id_lapang,
                                    nama_lapang: found.nama_lapangan,
                                    tanggal: paramTanggal,
                                    jam_mulai: pad(jamBuka) + ':00',
                                    durasi: 1,
                                    harga_satuan: 0,
                                    harga: 0
                                }];
                            }
                            renderCart();
                        } else if (sewaMode === 'membership' && paramJam) {
                            const jamFormatted = paramJam.split('.')[0].padStart(2, '0') + ':00';
                            selectedMembershipSlot = {
                                id_lapang: found.id_lapang,
                                jam_mulai: jamFormatted
                            };
                            fIdLapang.value = found.id_lapang;
                            fTanggal.value = paramTanggal;
                            fJam.value = jamFormatted;
                            updateSummaryData();
                        }
                    }
                }
            } catch (err) {
                console.error('Failed to load lapangs:', err);
            }
        }

        // ─── Fetch tarif from API ───
        async function getCartItemPrice(idLapang, tanggal, jamMulai, durasi) {
            try {
                const res = await fetch(`${API_TARIF}?id_lapang=${idLapang}&tanggal=${tanggal}`);
                const data = await res.json();
                const tarifs = data.tarifs || [];
                const jamHour = parseInt(jamMulai) || 0;
                let total = 0;
                for (let h = jamHour; h < jamHour + durasi; h++) {
                    let slotPrice = 0;
                    for (const t of tarifs) {
                        const tStart = parseInt(t.jam_mulai) || 0;
                        const tEnd = parseInt(t.jam_selesai) || 24;
                        if (h >= tStart && h < tEnd && parseInt(t.harga_umum) > 0) {
                            slotPrice = parseInt(t.harga_umum) || 0;
                            break;
                        }
                    }
                    if (slotPrice === 0 && tarifs.length > 0) {
                        const defaultTarif = tarifs.find(t => parseInt(t.harga_umum) > 0);
                        slotPrice = defaultTarif ? parseInt(defaultTarif.harga_umum) : 0;
                    }
                    total += slotPrice;
                }
                return total;
            } catch (err) {
                console.error('Failed to fetch tarif:', err);
                return 0;
            }
        }

        // ─── Sewa Mode Switcher ───
        window.setSewa = function (mode) {
            sewaMode = mode;
            document.querySelectorAll('.sewa-pill').forEach(p => {
                p.classList.toggle('sewa-pill--active', p.dataset.sewa === mode);
            });
            if (mode === 'membership') {
                new bootstrap.Modal(document.getElementById('membershipModal')).show();
            }

            selectedHarianCourtId = null;
            selectedMembershipSlot = null;
            cartItems = [];

            fIdLapang.value = '';
            fTanggal.value = '';
            fJam.value = '';
            fTotalBayar.value = '';
            fItemsJson.value = '';

            renderCart();
            updateSummaryData();

            const cartSection = document.getElementById('cartSection');
            const singleSection = document.getElementById('singleItemSection');
            if (cartSection) cartSection.style.display = (mode === 'per-jam' || mode === 'per-hari') ? 'block' : 'none';
            if (singleSection) singleSection.style.display = (mode === 'membership') ? 'block' : 'none';

            selectedDate = null;
            document.getElementById('lapangSection').style.display = 'none';
            renderCalendar();
        };

        // Listen for durasi input updates for Harian/Membership
        if (formDurasi) {
            formDurasi.addEventListener('input', updateSummaryData);
        }

        // ─── Update Summary Card ───
        async function updateSummaryData() {
            const isMembership = sewaMode === 'membership';
            const isHarian = sewaMode === 'per-hari';
            let durasiVal = parseInt(formDurasi.value) || 1;
            let totalHarga = 0;

            fTipeSewa.value = getTipeSewa();

            if (sewaMode === 'per-jam') return;

            const idLapang = fIdLapang.value;
            const tanggal = fTanggal.value;
            const jamMulai = fJam.value;

            if (!idLapang || !tanggal || !jamMulai) {
                sumLapang.textContent = '-';
                sumTanggal.textContent = '-';
                sumJam.textContent = '-';
                sumDurasi.textContent = '-';
                sumHarga.textContent = 'Rp -';
                fTotalBayar.value = '';

                const diskonWrap = document.getElementById('summaryDiskonWrap');
                const memberDatesWrap = document.getElementById('summaryMembershipDates');
                if (diskonWrap) diskonWrap.style.display = 'none';
                if (memberDatesWrap) memberDatesWrap.style.display = 'none';

                const payTypeWrap = document.getElementById('summaryPaymentType');
                if (payTypeWrap) payTypeWrap.style.display = 'none';
                return;
            }

            const lapangInfo = lapangsData.find(l => String(l.id_lapang) === String(idLapang));
            sumLapang.textContent = lapangInfo ? lapangInfo.nama_lapangan : '-';

            const parts = tanggal.split('-');
            const dt = new Date(+parts[0], +parts[1] - 1, +parts[2]);
            sumTanggal.textContent = `${DAY_NAMES[dt.getDay()]}, ${dt.getDate()} ${MONTH_NAMES[dt.getMonth()]} ${dt.getFullYear()}`;

            const { jamBuka, jamTutup } = getOperatingHours(lapangInfo, tanggal);
            const opHours = jamTutup - jamBuka;

            let hargaDasar = 0;
            let hargaAccumulated = 0;
            let hargaHarianExplicit = 0;
            try {
                const res = await fetch(`${API_TARIF}?id_lapang=${idLapang}&tanggal=${tanggal}`);
                const data = await res.json();
                const tarifs = data.tarifs || [];

                if (tarifs.length > 0) {
                    const harianTarif = tarifs.find(t => parseInt(t.harga_harian) > 0);
                    hargaHarianExplicit = harianTarif ? parseInt(harianTarif.harga_harian) : 0;
                }

                const jamHour = parseInt(jamMulai) || 0;
                
                const startHourToCalc = jamHour;
                const hoursToCalc = durasiVal;
                
                if (!isHarian) {
                    for (let h = startHourToCalc; h < startHourToCalc + hoursToCalc; h++) {
                        let slotPrice = 0;
                        for (const t of tarifs) {
                            const tStart = parseInt(t.jam_mulai) || 0;
                            const tEnd = parseInt(t.jam_selesai) || 24;
                            if (h >= tStart && h < tEnd && parseInt(t.harga_umum) > 0) {
                                slotPrice = parseInt(t.harga_umum) || 0;
                                break;
                            }
                        }
                        if (slotPrice === 0 && tarifs.length > 0) {
                            const defaultTarif = tarifs.find(t => parseInt(t.harga_umum) > 0);
                            slotPrice = defaultTarif ? parseInt(defaultTarif.harga_umum) : 0;
                        }
                        hargaAccumulated += slotPrice;

                        if (h === startHourToCalc) hargaDasar = slotPrice;
                    }
                }
            } catch (err) {
                console.error('Failed to load tariff:', err);
            }

            if (isHarian) {
                labelDurasiText.textContent = 'Durasi Hari';
                summaryDurasiLabel.textContent = 'Durasi Hari';

                sumJam.textContent = `${pad(jamBuka)}.00 - ${pad(jamTutup)}.00 (Full Day)`;
                totalHarga = hargaHarianExplicit * durasiVal;
                sumDurasi.textContent = `${durasiVal} Hari`;

                formDurasi.setAttribute('data-original', durasiVal);
                formDurasi.setAttribute('data-ophours', opHours);

                const diskonWrap = document.getElementById('summaryDiskonWrap');
                const memberDatesWrap = document.getElementById('summaryMembershipDates');
                if (diskonWrap) diskonWrap.style.display = 'none';
                if (memberDatesWrap) memberDatesWrap.style.display = 'none';
            } else if (isMembership) {
                labelDurasiText.textContent = 'Durasi Bermain';
                summaryDurasiLabel.textContent = 'Durasi Bermain';

                sumJam.textContent = jamMulai;
                const hargaNormal = hargaAccumulated * 4;
                const diskon = Math.round(hargaNormal * 0.1);
                totalHarga = hargaNormal - diskon;
                sumDurasi.textContent = `4x Sesi (${durasiVal} Jam/sesi) — Diskon 10%`;

                formDurasi.removeAttribute('data-original');
                formDurasi.removeAttribute('data-ophours');

                const diskonWrap = document.getElementById('summaryDiskonWrap');
                const hargaNormalEl = document.getElementById('summaryHargaNormal');
                const hargaHematEl = document.getElementById('summaryHargaHemat');
                if (diskonWrap && hargaDasar > 0) {
                    diskonWrap.style.display = 'block';
                    hargaNormalEl.textContent = 'Rp ' + hargaNormal.toLocaleString('id-ID');
                    hargaHematEl.textContent = '- Rp ' + diskon.toLocaleString('id-ID');
                }

                const memberDatesWrap = document.getElementById('summaryMembershipDates');
                const memberDatesList = document.getElementById('membershipDatesList');
                if (memberDatesWrap && memberDatesList) {
                    let datesHtml = '';
                    for (let i = 0; i < 4; i++) {
                        const d = new Date(dt);
                        d.setDate(d.getDate() + (i * 7));
                        const label = DAY_NAMES[d.getDay()] + ', ' + d.getDate() + ' ' + MONTH_NAMES[d.getMonth()] + ' ' + d.getFullYear();
                        datesHtml += `<div style="display:flex;align-items:center;gap:0.35rem;font-size:0.78rem;color:var(--on-surface);padding:0.15rem 0;">
                            <span class="material-symbols-outlined" style="font-size:0.85rem;color:#059669;">event_available</span>
                            <span>Sesi ${i+1}: <strong>${label}</strong></span>
                        </div>`;
                    }
                    memberDatesList.innerHTML = datesHtml;
                    memberDatesWrap.style.display = 'flex';
                }
            }

            sumHarga.textContent = totalHarga > 0 ? 'Rp ' + totalHarga.toLocaleString('id-ID') : 'Rp -';
            fTotalBayar.value = totalHarga;

            const payTypeWrap = document.getElementById('summaryPaymentType');
            if (payTypeWrap) {
                payTypeWrap.style.display = (isMembership || totalHarga <= 0) ? 'none' : 'block';
                if (isMembership) {
                    const fullRadio = document.querySelector('input[name="bayar_type"][value="Full"]');
                    if (fullRadio) fullRadio.checked = true;
                    document.getElementById('formJenisPembayaran').value = 'Full';
                }
            }
            updatePaymentType();
        }

        // ─── Render Cart (Per Jam) ───
        function renderCart() {
            // Always sync tipe_sewa hidden field with current sewaMode
            fTipeSewa.value = getTipeSewa();
            const listEl = document.getElementById('cartItemsList');
            const emptyEl = document.getElementById('cartEmptyNotice');
            const sumHarga = document.getElementById('summaryHarga');

            if (cartItems.length === 0) {
                if (listEl) listEl.innerHTML = '';
                if (emptyEl) emptyEl.style.display = 'block';
                fItemsJson.value = '';
                fTotalBayar.value = 0;
                if (sumHarga) sumHarga.textContent = 'Rp -';
                sumLapang.textContent = '-';
                sumTanggal.textContent = '-';
                sumJam.textContent = '-';
                sumDurasi.textContent = '-';

                const payTypeWrap = document.getElementById('summaryPaymentType');
                if (payTypeWrap) payTypeWrap.style.display = 'none';

                syncTimeslotClasses();
                return;
            }

            if (emptyEl) emptyEl.style.display = 'none';

            const MONTH_NAMES_SHORT = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            let html = '';
            let totalHarga = 0;

            cartItems.forEach((item, idx) => {
                totalHarga += item.harga;
                const dt = new Date(item.tanggal);
                const tglText = dt.getDate() + ' ' + MONTH_NAMES_SHORT[dt.getMonth()] + ' ' + dt.getFullYear();
                const jamEnd = sewaMode === 'per-hari' ? '(Full Day)' : String(parseInt(item.jam_mulai) + item.durasi).padStart(2, '0') + ':00';
                const durasiLabel = sewaMode === 'per-hari' ? item.durasi + ' Hari' : item.durasi + ' Jam';
                const subTglText = sewaMode === 'per-hari' ? `${tglText} · Full Day` : `${tglText} · ${item.jam_mulai} - ${jamEnd}`;

                html += `<div style="display:flex;align-items:center;justify-content:space-between;padding:0.6rem 0.75rem;background:var(--surface-container);border:1px solid var(--outline-variant);border-radius:0.65rem;margin-bottom:0.4rem;animation:fadeIn .3s ease;">
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.82rem;font-weight:700;color:var(--on-surface);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            <span class="material-symbols-outlined" style="font-size:0.85rem;vertical-align:-2px;color:var(--primary);margin-right:2px;">stadium</span>
                            ${item.nama_lapang}
                        </div>
                        <div style="font-size:0.72rem;color:var(--on-surface-variant);margin-top:1px;">
                            ${subTglText}
                        </div>
                        <div style="font-size:0.75rem;font-weight:700;color:var(--primary);margin-top:2px;">
                            Rp ${item.harga.toLocaleString('id-ID')}
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:0.5rem; margin-right:1rem; background:var(--surface-container-low); padding:0.25rem 0.5rem; border-radius:0.5rem; border:1px solid var(--outline-variant);">
                        <button type="button" onclick="updateCartItemDurasi(${idx}, -1)" style="border:none; background:none; cursor:pointer; display:flex; align-items:center; justify-content:center; padding:0; color:var(--on-surface);" ${item.durasi <= 1 ? 'disabled style="opacity:0.3;cursor:not-allowed;"' : ''}>
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">remove</span>
                        </button>
                        <span style="font-size:0.8rem; font-weight:700; width:50px; text-align:center;">${durasiLabel}</span>
                        <button type="button" onclick="updateCartItemDurasi(${idx}, 1)" style="border:none; background:none; cursor:pointer; display:flex; align-items:center; justify-content:center; padding:0; color:var(--on-surface);">
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">add</span>
                        </button>
                    </div>
                    <button type="button" onclick="removeFromCart(${idx})" style="background:none;border:none;cursor:pointer;padding:0.25rem;color:#dc2626;flex-shrink:0;" title="Hapus">
                        <span class="material-symbols-outlined" style="font-size:1.1rem;">delete</span>
                    </button>
                </div>`;
            });

            html += `<div style="display:flex;justify-content:space-between;align-items:center;padding:0.55rem 0.75rem;background:color-mix(in srgb, var(--primary) 10%, transparent);border:1px solid color-mix(in srgb, var(--primary) 30%, transparent);border-radius:0.65rem;margin-top:0.4rem;">
                <span style="font-size:0.82rem;font-weight:700;color:var(--on-surface);">
                    <span class="material-symbols-outlined" style="font-size:0.9rem;vertical-align:-2px;">shopping_cart</span>
                    ${cartItems.length} item
                </span>
                <span style="font-size:0.9rem;font-weight:800;color:var(--primary);">
                    Rp ${totalHarga.toLocaleString('id-ID')}
                </span>
            </div>`;

            if (listEl) listEl.innerHTML = html;

            fItemsJson.value = JSON.stringify(cartItems);
            fTotalBayar.value = totalHarga;
            
            // Populate hidden inputs with the first item's data to bypass backend validation rules
            fIdLapang.value = cartItems[0].id_lapang;
            fTanggal.value = cartItems[0].tanggal;
            fJam.value = cartItems[0].jam_mulai;

            if (sumHarga) sumHarga.textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');

            if (sumLapang) {
                const names = [...new Set(cartItems.map(i => i.nama_lapang))];
                sumLapang.textContent = names.join(', ');
            }
            if (sumTanggal) {
                const dates = [...new Set(cartItems.map(i => i.tanggal))];
                sumTanggal.textContent = dates.length === 1 ? (() => {
                    const parts = dates[0].split('-');
                    const d = new Date(+parts[0], +parts[1]-1, +parts[2]);
                    return `${DAY_NAMES[d.getDay()]}, ${d.getDate()} ${MONTH_NAMES[d.getMonth()]} ${d.getFullYear()}`;
                })() : dates.length + ' tanggal berbeda';
            }
            if (sumJam) sumJam.textContent = cartItems.length + ' sesi';
            if (sumDurasi) sumDurasi.textContent = cartItems.reduce((a, i) => a + i.durasi, 0) + (sewaMode === 'per-hari' ? ' Hari' : ' Jam');

            const payTypeWrap = document.getElementById('summaryPaymentType');
            if (payTypeWrap) payTypeWrap.style.display = totalHarga > 0 ? 'block' : 'none';
            updatePaymentType();

            syncTimeslotClasses();
        }

        window.removeFromCart = function (index) {
            cartItems.splice(index, 1);
            renderCart();
        };

        window.updateCartItemDurasi = async function(idx, delta) {
            const item = cartItems[idx];
            const newDurasi = item.durasi + delta;
            if (newDurasi < 1) return;

            if (sewaMode === 'per-hari') {
                // Multi-day overlap check not strictly implemented on frontend for simplicity
                item.durasi = newDurasi;
                item.harga = item.harga_satuan * newDurasi;
            } else {
                if (delta > 0) {
                    const checkHour = parseInt(item.jam_mulai) + item.durasi;
                    const slotKey = pad(checkHour) + ':00';

                    const lapang = lapangsData.find(l => String(l.id_lapang) === String(item.id_lapang));
                    if (lapang) {
                        const { jamTutup } = getOperatingHours(lapang, item.tanggal);
                        if (checkHour >= jamTutup) {
                            alert('Durasi melebihi jam operasional lapangan.');
                            return;
                        }
                    }

                    const booked = bookedSlotsData[item.id_lapang] || [];
                    if (booked.includes(slotKey)) {
                        alert('Jam berikutnya sudah terisi. Tidak dapat menambah durasi.');
                        return;
                    }

                    const overlaps = cartItems.some((other, oIdx) => {
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
                item.harga = await getCartItemPrice(item.id_lapang, item.tanggal, item.jam_mulai, item.durasi);
            }
            
            renderCart();
            syncTimeslotClasses();
        };

        // ─── Sync timeslot selection classes ───
        function syncTimeslotClasses() {
            document.querySelectorAll('.timeslot-box').forEach(box => {
                const lapangId = box.closest('.lapang-card').id.replace('lapang-card-', '');
                const slotKey = box.dataset.slotkey;

                if (sewaMode === 'per-jam') {
                    const boxHour = parseInt(slotKey);
                    const inCart = cartItems.some(item => {
                        if (String(item.id_lapang) !== String(lapangId) || item.tanggal !== selectedDate) return false;
                        const startHour = parseInt(item.jam_mulai);
                        const durasi = parseInt(item.durasi) || 1;
                        return (boxHour >= startHour && boxHour < startHour + durasi);
                    });
                    box.classList.toggle('timeslot-box--selected', inCart);
                } else if (sewaMode === 'membership') {
                    const isSelected = selectedMembershipSlot &&
                        String(selectedMembershipSlot.id_lapang) === String(lapangId) &&
                        selectedMembershipSlot.jam_mulai === slotKey;
                    box.classList.toggle('timeslot-box--selected', isSelected);
                }
            });
        }

        // ─── Handle slot clicks ───
        window.handleTimeslotClick = async function (element, idLapang, slotKey, namaLapangan) {
            if (sewaMode === 'per-jam') {
                const isSelected = element.classList.contains('timeslot-box--selected');
                if (isSelected) {
                    const boxHour = parseInt(slotKey);
                    const idx = cartItems.findIndex(item => {
                        if (String(item.id_lapang) !== String(idLapang) || item.tanggal !== selectedDate) return false;
                        const startHour = parseInt(item.jam_mulai);
                        const durasi = parseInt(item.durasi) || 1;
                        return (boxHour >= startHour && boxHour < startHour + durasi);
                    });
                    if (idx !== -1) {
                        cartItems.splice(idx, 1);
                        renderCart();
                    }
                } else {
                    const harga = await getCartItemPrice(idLapang, selectedDate, slotKey, 1);
                    cartItems.push({
                        id_lapang: idLapang,
                        nama_lapang: namaLapangan,
                        tanggal: selectedDate,
                        jam_mulai: slotKey,
                        durasi: 1,
                        harga: harga
                    });
                    renderCart();
                }
            } else if (sewaMode === 'membership') {
                const isSelected = element.classList.contains('timeslot-box--selected');
                if (isSelected) {
                    selectedMembershipSlot = null;
                    fIdLapang.value = '';
                    fTanggal.value = '';
                    fJam.value = '';
                } else {
                    selectedMembershipSlot = {
                        id_lapang: idLapang,
                        jam_mulai: slotKey
                    };
                    fIdLapang.value = idLapang;
                    fTanggal.value = selectedDate;
                    fJam.value = slotKey;
                }
                syncTimeslotClasses();
                updateSummaryData();
            }
        };

        // ─── Handle daily court select (Harian) ───
        window.handleDailySelection = async function (idLapang, namaLapangan, jamBuka) {
            const idx = cartItems.findIndex(item => String(item.id_lapang) === String(idLapang) && item.tanggal === selectedDate);
            if (idx !== -1) {
                cartItems.splice(idx, 1);
                renderDailyCards(selectedDate, new Date(selectedDate));
                renderCart();
            } else {
                try {
                    const res = await fetch(`${API_TARIF}?id_lapang=${idLapang}&tanggal=${selectedDate}`);
                    const data = await res.json();
                    const tarifs = data.tarifs || [];
                    const harianTarif = tarifs.find(t => parseInt(t.harga_harian) > 0);
                    const hargaHarian = harianTarif ? parseInt(harianTarif.harga_harian) : 0;
                    
                    cartItems.push({
                        id_lapang: idLapang,
                        nama_lapang: namaLapangan,
                        tanggal: selectedDate,
                        jam_mulai: pad(jamBuka) + ':00',
                        durasi: 1,
                        harga_satuan: hargaHarian,
                        harga: hargaHarian
                    });
                } catch(e) {}
                renderDailyCards(selectedDate, new Date(selectedDate));
                renderCart();
            }
        };

        // ─── Render hourly timeslot cards (Stacked vertically in sidebar) ───
        function renderLapangCards() {
            const lapangEmpty = document.getElementById('lapangEmpty');
            const lapangCards = document.getElementById('lapangCards');
            if (lapangsData.length === 0) {
                lapangCards.innerHTML = '';
                lapangEmpty.style.display = 'block';
                return;
            }

            lapangEmpty.style.display = 'none';
            let html = '';
            let totalAvailable = 0;
            let totalBooked = 0;

            lapangsData.forEach((lapang, idx) => {
                const { jamBuka, jamTutup, isWeekend } = getOperatingHours(lapang, selectedDate);
                const bookedSlots = bookedSlotsData[lapang.id_lapang] || [];

                let slotsHtml = '';
                let availCount = 0;
                let bookedCount = 0;

                for (let h = jamBuka; h < jamTutup; h++) {
                    const slotKey = pad(h) + ':00';
                    const start = pad(h) + '.00';
                    const end = pad(h + 1) + '.00';
                    const label = start;
                    const isBooked = bookedSlots.includes(slotKey);
                    const isPast = isPastSlot(selectedDate, h);

                    let boxClass = 'timeslot-box';
                    let icon = 'schedule';
                    let canClick = true;
                    let badge = '';
                    if (isBooked) {
                        boxClass += ' timeslot-box--booked';
                        icon = 'event_busy';
                        canClick = false;
                        bookedCount++;
                        badge = '<span class="timeslot-badge timeslot-badge--terisi">Terisi</span>';
                    } else if (isPast) {
                        boxClass += ' timeslot-box--past';
                        icon = 'history';
                        canClick = false;
                        bookedCount++; // count past as occupied/booked for stats
                        badge = '<span class="timeslot-badge timeslot-badge--lewat">Lewat</span>';
                    } else {
                        boxClass += ' timeslot-box--available';
                        availCount++;
                        badge = '<span class="timeslot-badge timeslot-badge--kosong">Kosong</span>';
                    }

                    let isSelected = false;
                    if (sewaMode === 'per-jam') {
                        const boxHour = parseInt(slotKey);
                        isSelected = cartItems.some(item => {
                            if (String(item.id_lapang) !== String(lapang.id_lapang) || item.tanggal !== selectedDate) return false;
                            const itemStartHour = parseInt(item.jam_mulai);
                            const itemDurasi = parseInt(item.durasi) || 1;
                            return (boxHour >= itemStartHour && boxHour < itemStartHour + itemDurasi);
                        });
                    } else if (sewaMode === 'membership') {
                        isSelected = selectedMembershipSlot &&
                            String(selectedMembershipSlot.id_lapang) === String(lapang.id_lapang) &&
                            selectedMembershipSlot.jam_mulai === slotKey;
                    }
                    if (isSelected) {
                        boxClass += ' timeslot-box--selected';
                    }

                    slotsHtml += `<div class="${boxClass}" data-slot="${start}-${end}" data-label="${label}" data-slotkey="${slotKey}" data-lapang-id="${lapang.id_lapang}" data-lapang-name="${lapang.nama_lapangan}" ${canClick ? 'tabindex="0" role="button"' : ''} style="animation-delay:${0.03 * (h - jamBuka)}s">
                        <span class="material-symbols-outlined timeslot-box__icon">${icon}</span>
                        <span class="timeslot-box__label">${label}</span>
                        ${badge}
                    </div>`;
                }

                totalAvailable += availCount;
                totalBooked += bookedCount;

                const jamLabel = isWeekend ? 'Weekend' : 'Weekday';

                html += `<div class="col-12" style="animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both; animation-delay: ${0.1 * (idx + 1)}s;">
                    <div class="lapang-card" id="lapang-card-${lapang.id_lapang}">
                        <div class="lapang-card__header">
                            <span class="material-symbols-outlined lapang-card__icon">stadium</span>
                            <div>
                                <span class="lapang-card__title">${lapang.nama_lapangan}</span>
                                <div class="lapang-card__subtitle">${jamLabel} · ${pad(jamBuka)}.00 - ${pad(jamTutup)}.00</div>
                            </div>
                        </div>
                        <div class="lapang-card__stats">
                            <span class="lapang-card__stat stat--available">
                                <span class="material-symbols-outlined">check_circle</span>
                                ${availCount} tersedia
                            </span>
                            <span class="lapang-card__stat stat--booked">
                                <span class="material-symbols-outlined">block</span>
                                ${bookedCount} terisi/lewat
                            </span>
                        </div>
                        <div class="lapang-card__body">
                            <div class="timeslot-grid" id="timeslots-lapang-${lapang.id_lapang}">${slotsHtml}</div>
                        </div>
                    </div>
                </div>`;
            });

            lapangCards.innerHTML = html;

            // Attach click via event delegation (no inline onclick)
            bindTimeslotClicks();

            const slotSummary = document.getElementById('slotSummary');
            const slotSummaryText = document.getElementById('slotSummaryText');
            if (slotSummary && slotSummaryText) {
                slotSummary.style.display = 'flex';
                slotSummaryText.textContent = `${totalAvailable} slot tersedia · ${totalBooked} terisi/lewat`;
            }
        }

        // ─── Render Daily Cards (Harian - Stacked vertically in sidebar) ───
        function renderDailyCards(ds, dt) {
            const lapangEmpty = document.getElementById('lapangEmpty');
            const lapangCards = document.getElementById('lapangCards');
            let html = '';
            let availableLapangs = 0;

            lapangsData.forEach((lapang, idx) => {
                const { jamBuka, jamTutup, isWeekend } = getOperatingHours(lapang, ds);
                const bookedSlots = bookedSlotsData[lapang.id_lapang] || [];
                const totalSlots = jamTutup - jamBuka;
                const bookedCount = bookedSlots.length;
                const availSlots = totalSlots - bookedCount;
                const isFullyAvailable = bookedCount === 0;

                const jamLabel = isWeekend ? 'Weekend' : 'Weekday';
                const statusText = isFullyAvailable ? 'Tersedia Full Day' : `${availSlots}/${totalSlots} slot tersedia`;
                
                const isSelected = cartItems.some(i => String(i.id_lapang) === String(lapang.id_lapang) && i.tanggal === ds);
                
                let cardClass = 'daily-card';
                if (isSelected) cardClass += ' daily-card--selected';

                let headerBg = isFullyAvailable
                    ? 'background:linear-gradient(135deg,#059669,#10b981);'
                    : 'background:linear-gradient(135deg,#d97706,#f59e0b);';
                
                if (isSelected) {
                    headerBg = 'background:linear-gradient(135deg,#1d4ed8,#4f46e5);';
                }

                let btnHtml = '';
                if (isFullyAvailable) {
                    if (isSelected) {
                        btnHtml = `<button type="button" class="daily-card__btn daily-select-btn" style="background:#059669;" data-lapang-id="${lapang.id_lapang}" data-lapang-name="${lapang.nama_lapangan}" data-jam-buka="${jamBuka}">
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">check_circle</span>
                            Terpilih (Full Day)
                        </button>`;
                    } else {
                        btnHtml = `<button type="button" class="daily-card__btn daily-select-btn" data-lapang-id="${lapang.id_lapang}" data-lapang-name="${lapang.nama_lapangan}" data-jam-buka="${jamBuka}">
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">event_available</span>
                            Pilih Lapangan
                        </button>`;
                    }
                    availableLapangs++;
                } else {
                    btnHtml = `<span style="font-size:.75rem;color:#94a3b8;text-align:center;display:block;">Tidak tersedia untuk sewa per hari</span>`;
                }

                html += `<div class="col-12" style="animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both; animation-delay: ${0.1 * (idx + 1)}s;">
                    <div class="${cardClass}">
                        <div class="daily-card__header" style="${headerBg}">
                            <span class="material-symbols-outlined">stadium</span>
                            <div>
                                <div class="daily-card__title">${lapang.nama_lapangan}</div>
                                <div class="daily-card__subtitle">${jamLabel} · ${pad(jamBuka)}.00 - ${pad(jamTutup)}.00</div>
                            </div>
                        </div>
                        <div class="daily-card__body">
                            <div class="daily-card__info">
                                <span class="material-symbols-outlined">${isFullyAvailable ? 'check_circle' : 'info'}</span>
                                <span>${statusText}</span>
                            </div>
                            <div class="daily-card__info">
                                <span class="material-symbols-outlined">schedule</span>
                                <span>Jam operasional: ${pad(jamBuka)}.00 - ${pad(jamTutup)}.00 (${totalSlots} jam)</span>
                            </div>
                            ${btnHtml}
                        </div>
                    </div>
                </div>`;
            });

            if (lapangsData.length === 0) {
                lapangEmpty.style.display = 'block';
            } else {
                lapangEmpty.style.display = 'none';
                lapangCards.innerHTML = html;

                // Attach click via event delegation for daily cards
                bindDailyCardClicks();

                const slotSummary = document.getElementById('slotSummary');
                const slotSummaryText = document.getElementById('slotSummaryText');
                if (slotSummary && slotSummaryText) {
                    slotSummary.style.display = 'flex';
                    slotSummaryText.textContent = `${availableLapangs} lapangan tersedia full day`;
                }
            }
        }
        // ─── Event Delegation: Bind Timeslot Clicks ───
        function bindTimeslotClicks() {
            const container = document.getElementById('lapangCards');
            if (!container) return;
            container.querySelectorAll('.timeslot-box--available, .timeslot-box--selected').forEach(box => {
                box.addEventListener('click', function () {
                    const lapangId = this.dataset.lapangId;
                    const slotKey = this.dataset.slotkey;
                    const lapangName = this.dataset.lapangName;
                    if (lapangId && slotKey) {
                        handleTimeslotClick(this, lapangId, slotKey, lapangName);
                    }
                });
                box.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });
        }

        // ─── Event Delegation: Bind Daily Card Clicks ───
        function bindDailyCardClicks() {
            const container = document.getElementById('lapangCards');
            if (!container) return;
            container.querySelectorAll('.daily-select-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const lapangId = this.dataset.lapangId;
                    const lapangName = this.dataset.lapangName;
                    const jamBuka = parseInt(this.dataset.jamBuka);
                    if (lapangId && lapangName) {
                        handleDailySelection(lapangId, lapangName, jamBuka);
                    }
                });
            });
        }

        // ─── Render Calendar ───
        async function fetchMonthBookings() {
            try {
                const res = await fetch(`${API_MONTH}?year=${currentYear}&month=${currentMonth + 1}`);
                monthBookingsData = await res.json();
            } catch (err) {
                console.error('Failed to fetch month bookings:', err);
                monthBookingsData = {};
            }
        }

        function getTotalSlotsForDate(ds) {
            if (lapangsData.length === 0) return 0;
            let total = 0;
            lapangsData.forEach(lapang => {
                const { jamBuka, jamTutup } = getOperatingHours(lapang, ds);
                total += Math.max(0, jamTutup - jamBuka);
            });
            return total;
        }

        async function renderCalendar() {
            const calLabel = document.getElementById('calMonthLabel');
            const calDates = document.getElementById('calDates');
            if (!calLabel || !calDates) return;

            calLabel.textContent = `${MONTH_NAMES[currentMonth]} ${currentYear}`;

            if (lapangsData.length === 0) await loadLapangs();
            await fetchMonthBookings();

            let firstDay = new Date(currentYear, currentMonth, 1).getDay();
            firstDay = (firstDay + 6) % 7; // Monday = 0

            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            let html = '';
            for (let i = 0; i < firstDay; i++) {
                html += '<span class="cal-cell cal-cell--empty"></span>';
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const ds = dateStr(currentYear, currentMonth, d);
                const isToday = ds === todayStr;
                const isSelected = ds === selectedDate;
                const isPastDate = ds < todayStr;

                const totalSlots = getTotalSlotsForDate(ds);
                const bookedSlots = monthBookingsData[ds] || 0;
                const availableSlots = totalSlots - bookedSlots;

                let cls = 'cal-cell';
                if (isToday) cls += ' cal-cell--today';
                if (isSelected) cls += ' cal-cell--selected';
                if (isPastDate) cls += ' cal-cell--past';

                let dotHtml = '';
                if (!isPastDate && totalSlots > 0) {
                    if (availableSlots <= 0) {
                        dotHtml = '<span class="cal-avail-dot cal-avail-dot--full"></span>';
                    } else if (bookedSlots > 0) {
                        dotHtml = '<span class="cal-avail-dot cal-avail-dot--partial"></span>';
                    } else {
                        dotHtml = '<span class="cal-avail-dot cal-avail-dot--available"></span>';
                    }
                }

                html += `<span class="${cls}" data-date="${ds}" role="button" tabindex="0" ${isPastDate ? 'aria-disabled="true"' : ''}
                            title="${isPastDate ? '' : `${availableSlots}/${totalSlots} slot tersedia`}">
                            <span class="cal-cell__num">${d}</span>
                            ${dotHtml}
                         </span>`;
            }

            calDates.innerHTML = html;

            calDates.querySelectorAll('.cal-cell:not(.cal-cell--empty):not(.cal-cell--past)').forEach(cell => {
                cell.addEventListener('click', () => selectDate(cell.dataset.date));
                cell.addEventListener('keydown', e => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        selectDate(cell.dataset.date);
                    }
                });
            });
        }

        async function selectDate(ds) {
            selectedDate = ds;
            await renderCalendar();
            await showLapangCards(ds);
        }

        async function showLapangCards(ds) {
            const lapangSection = document.getElementById('lapangSection');
            const lapangDateLabel = document.getElementById('lapangDateLabel');
            const lapangLoading = document.getElementById('lapangLoading');
            
            if (!lapangSection || !lapangDateLabel || !lapangLoading) return;

            const parts = ds.split('-');
            const dt = new Date(+parts[0], +parts[1] - 1, +parts[2]);
            lapangDateLabel.innerHTML = `<span class="material-symbols-outlined" style="font-size:.95rem;vertical-align:-3px;">today</span> ${DAY_NAMES[dt.getDay()]}, ${dt.getDate()} ${MONTH_NAMES[dt.getMonth()]} ${dt.getFullYear()}`;

            lapangSection.style.display = 'block';
            lapangLoading.style.display = 'block';
            document.getElementById('lapangCards').innerHTML = '';
            document.getElementById('lapangEmpty').style.display = 'none';

            await Promise.all([
                lapangsData.length === 0 ? loadLapangs() : Promise.resolve(),
                fetchBookedSlots(ds)
            ]);

            lapangLoading.style.display = 'none';

            if (sewaMode === 'per-hari') {
                renderDailyCards(ds, dt);
            } else {
                renderLapangCards();
            }
        }

        async function fetchBookedSlots(tanggal) {
            try {
                const res = await fetch(`${API_BOOKED}?tanggal=${tanggal}`);
                bookedSlotsData = await res.json();
            } catch (err) {
                console.error('Failed to fetch booked slots:', err);
                bookedSlotsData = {};
            }
        }

        // Calendar Nav Button bindings
        const btnPrev = document.getElementById('calPrev');
        const btnNext = document.getElementById('calNext');
        if (btnPrev && btnNext) {
            btnPrev.addEventListener('click', async () => {
                currentMonth--;
                if (currentMonth < 0) { currentMonth = 11; currentYear--; }
                await renderCalendar();
            });

            btnNext.addEventListener('click', async () => {
                currentMonth++;
                if (currentMonth > 11) { currentMonth = 0; currentYear++; }
                await renderCalendar();
            });
        }

        // ─── Initial Page Load Initialization ───
        (async () => {
            await loadLapangs();

            if (paramSewa === 'per-hari' || paramSewa === 'membership' || paramSewa === 'per-jam') {
                sewaMode = paramSewa;
                document.querySelectorAll('.sewa-pill').forEach(p => {
                    p.classList.toggle('sewa-pill--active', p.dataset.sewa === sewaMode);
                });

                // Sync hidden tipe_sewa field with the URL param sewa mode
                fTipeSewa.value = getTipeSewa();

                const cartSection = document.getElementById('cartSection');
                const singleSection = document.getElementById('singleItemSection');
                if (cartSection) cartSection.style.display = (sewaMode === 'per-jam' || sewaMode === 'per-hari') ? 'block' : 'none';
                if (singleSection) singleSection.style.display = (sewaMode === 'membership') ? 'block' : 'none';
            }

            await renderCalendar();

            if (selectedDate) {
                await showLapangCards(selectedDate);
            }
        })();

    })();

    /* ===== GLOBAL: Update Payment Type (Full / DP) ===== */
    window.updatePaymentType = function () {
        const dpRadio = document.querySelector('input[name="bayar_type"]:checked');
        const hiddenField = document.getElementById('formJenisPembayaran');
        const dpInfoBox = document.getElementById('summaryDPInfo');
        const dpAmountEl = document.getElementById('summaryDPAmount');
        const sisaAmountEl = document.getElementById('summarySisaAmount');
        const totalBayar = parseInt(document.getElementById('formTotalBayar').value) || 0;
        const labelFull = document.getElementById('labelBayarFull');
        const labelDP = document.getElementById('labelBayarDP');

        if (!dpRadio || !hiddenField) return;

        const isDP = dpRadio.value === 'DP';
        hiddenField.value = isDP ? 'DP' : 'Full';

        if (labelFull && labelDP) {
            labelFull.style.borderColor = !isDP ? 'var(--primary)' : 'var(--outline-variant)';
            labelFull.style.background = !isDP ? 'color-mix(in srgb, var(--primary) 8%, transparent)' : '';
            labelDP.style.borderColor = isDP ? '#ea580c' : 'var(--outline-variant)';
            labelDP.style.background = isDP ? '#fff7ed' : '';
        }

        if (dpInfoBox) {
            dpInfoBox.style.display = isDP ? 'block' : 'none';
        }

        if (isDP && totalBayar > 0) {
            const dpAmount = Math.ceil(totalBayar / 2);
            const sisa = totalBayar - dpAmount;
            if (dpAmountEl) dpAmountEl.textContent = 'Rp ' + dpAmount.toLocaleString('id-ID');
            if (sisaAmountEl) sisaAmountEl.textContent = 'Rp ' + sisa.toLocaleString('id-ID');
        }
    };

    /* ===== MODAL PETUNJUK BAYAR ===== */
    (function () {
        const modal = document.getElementById('petunjukBayarModal');
        const pbmTotal = document.getElementById('pbmTotalAmount');
        const pbmSub = document.getElementById('pbmBookingSub');
        const uploadZone = document.getElementById('pbmUploadZone');
        const fileInput = document.getElementById('pbmFileInput');
        const previewWrap = document.getElementById('pbmPreviewWrap');
        const previewImg = document.getElementById('pbmPreviewImg');
        const removeBtn = document.getElementById('pbmRemoveFile');
        const copyBtn = document.getElementById('pbmCopyBtn');
        const kirimBtn = document.getElementById('pbmBtnKirim');

        if (!modal) return;

        modal.addEventListener('show.bs.modal', function () {
            const harga = document.getElementById('summaryHarga');
            const lapang = document.getElementById('summaryLapang');
            const tgl = document.getElementById('summaryTanggal');
            const jam = document.getElementById('summaryJam');

            pbmTotal.textContent = harga && harga.textContent !== 'Rp -' ? harga.textContent : 'Rp 75.000';

            const dpRadio = document.querySelector('input[name="bayar_type"]:checked');
            if (dpRadio && dpRadio.value === 'DP') {
                const dpAmount = document.getElementById('summaryDPAmount');
                if (dpAmount) {
                    pbmTotal.textContent = dpAmount.textContent;
                    pbmTotal.style.color = '#c2410c';
                }
            } else {
                pbmTotal.style.color = '';
            }

            const lText = lapang ? lapang.textContent : '-';
            const tText = tgl ? tgl.textContent : '-';
            const jText = jam ? jam.textContent : '-';
            pbmSub.textContent = `${lText} · ${tText} · ${jText}`;
        });

        if (uploadZone) uploadZone.addEventListener('click', () => fileInput.click());

        if (fileInput) {
            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => {
                    previewImg.src = e.target.result;
                    previewWrap.style.display = 'block';
                    uploadZone.classList.add('has-file');
                    uploadZone.querySelector('.pbm-upload-text').textContent = file.name;
                    uploadZone.querySelector('.pbm-upload-hint').textContent = (file.size / 1024).toFixed(1) + ' KB';
                };
                reader.readAsDataURL(file);
            });
        }

        if (removeBtn) {
            removeBtn.addEventListener('click', function () {
                fileInput.value = '';
                previewImg.src = '';
                previewWrap.style.display = 'none';
                uploadZone.classList.remove('has-file');
                uploadZone.querySelector('.pbm-upload-text').textContent = 'Klik untuk pilih file';
                uploadZone.querySelector('.pbm-upload-hint').textContent = 'JPG, PNG — Maks 2MB';
            });
        }

        if (copyBtn) {
            copyBtn.addEventListener('click', function () {
                navigator.clipboard.writeText('1234567890').then(() => {
                    const icon = copyBtn.querySelector('.material-symbols-outlined');
                    icon.textContent = 'check';
                    copyBtn.style.color = '#059669';
                    setTimeout(() => {
                        icon.textContent = 'content_copy';
                        copyBtn.style.color = '';
                    }, 2000);
                });
            });
        }

        if (kirimBtn) {
            kirimBtn.addEventListener('click', function () {
                const form = document.getElementById('bookingForm');
                if (form) {
                    const tipeSewa = document.getElementById('formTipeSewa');

                    if (tipeSewa && tipeSewa.value === 'Per Jam') {
                        const itemsJson = document.getElementById('formItemsJson').value;
                        if (!itemsJson || itemsJson === '[]') {
                            alert('Silakan pilih minimal 1 sesi jadwal bermain di atas.');
                            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('petunjukBayarModal'));
                            if (modalInstance) modalInstance.hide();
                            return;
                        }
                    } else {
                        const idLapang = document.getElementById('formIdLapang').value;
                        const tanggal = document.getElementById('formTanggal').value;
                        const jam = document.getElementById('formJam').value;
                        if (!idLapang || !tanggal || !jam) {
                            alert('Silakan pilih lapangan dan sesi jadwal bermain terlebih dahulu di atas.');
                            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('petunjukBayarModal'));
                            if (modalInstance) modalInstance.hide();
                            return;
                        }
                    }

                    const durasiInput = document.getElementById('formDurasi');
                    if (tipeSewa && tipeSewa.value === 'Harian' && durasiInput) {
                        const opHours = parseInt(durasiInput.getAttribute('data-ophours')) || 12;
                        const days = parseInt(durasiInput.value) || 1;
                        document.getElementById('formJumlahHari').value = days;
                        durasiInput.value = opHours * days;
                    }
                    form.submit();
                }
            });
        }
    })();
</script>

<?= $this->endSection() ?>