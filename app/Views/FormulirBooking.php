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

            <!-- Left: Booking Summary Card -->
            <div class="col-12 col-lg-5">
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

                        <!-- Pilihan Pembayaran (Per Jam & Harian only) -->
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

            <!-- Right: Booking Form -->
            <div class="col-12 col-lg-6">
                <div class="bf-form-card">
                    <div class="bf-form-header">
                        <span class="material-symbols-outlined" style="font-size:1.35rem;">person</span>
                        <span>Data Pemesan</span>
                    </div>
                    <div class="bf-form-body">
                        <form id="bookingForm" action="<?= base_url('/booking') ?>" method="post" enctype="multipart/form-data">
                            <!-- Hidden fields for booking data -->
                            <input type="hidden" name="id_lapang" id="formIdLapang">
                            <input type="hidden" name="tanggal_main" id="formTanggal">
                            <input type="hidden" name="jam_mulai" id="formJam">
                            <input type="hidden" name="total_bayar" id="formTotalBayar">
                            <input type="hidden" name="tipe_sewa" id="formTipeSewa" value="Per Jam">
                            <input type="hidden" name="jumlah_hari" id="formJumlahHari" value="1">
                            <input type="hidden" name="jenis_pembayaran" id="formJenisPembayaran" value="Full">

                            <!-- Tipe Sewa -->
                            <div class="bf-field">
                                <label class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">loyalty</span>
                                    Tipe Sewa
                                </label>
                                <div class="d-flex flex-wrap gap-4 mt-2"
                                    style="background: var(--surface-container); padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--outline-variant);">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipe_sewa" id="sewaReguler"
                                            value="Per Jam" checked>
                                        <label class="form-check-label" for="sewaReguler"
                                            style="font-size: 0.85rem; font-weight: 500; cursor: pointer;">
                                            Sewa Per Jam
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipe_sewa" id="sewaHarian"
                                            value="Harian">
                                        <label class="form-check-label" for="sewaHarian"
                                            style="font-size: 0.85rem; font-weight: 500; cursor: pointer;">
                                            Sewa Harian
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipe_sewa"
                                            id="sewaMembership" value="Membership">
                                        <label class="form-check-label" for="sewaMembership"
                                            style="font-size: 0.85rem; font-weight: 500; cursor: pointer; color: var(--primary);">
                                            Paket Membership
                                        </label>
                                    </div>
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
                                    <span class="material-symbols-outlined bf-input-icon">alternate_email</span>
                                    <input type="email" id="formEmail" name="email" class="bf-input"
                                        placeholder="email@contoh.com">
                                </div>
                            </div>

                            <!-- Pilih Lapang (if not pre-selected) -->
                            <div class="bf-field" id="fieldPilihLapang">
                                <label for="formPilihLapang" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">stadium</span>
                                    Pilih Lapangan
                                </label>
                                <div class="bf-input-wrap">
                                    <span class="material-symbols-outlined bf-input-icon">location_on</span>
                                    <select id="formPilihLapang" name="pilih_lapang" class="bf-input bf-select">
                                        <option value="">-- Pilih Lapangan --</option>
                                        <!-- Populated by JS from API -->
                                    </select>
                                </div>
                            </div>

                            <!-- Pilih Tanggal (if not pre-selected) -->
                            <div class="bf-field" id="fieldPilihTanggal">
                                <label for="formPilihTanggal" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">calendar_today</span>
                                    Pilih Tanggal
                                </label>
                                <div class="bf-input-wrap">
                                    <span class="material-symbols-outlined bf-input-icon">event</span>
                                    <input type="date" id="formPilihTanggal" name="pilih_tanggal"
                                        class="bf-input bf-input-date">
                                </div>
                            </div>

                            <!-- Pilih Jam (if not pre-selected) -->
                            <div class="bf-field" id="fieldPilihJam">
                                <label for="formPilihJam" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">schedule</span>
                                    Pilih Jam
                                </label>
                                <div class="bf-input-wrap">
                                    <span class="material-symbols-outlined bf-input-icon">schedule</span>
                                    <select id="formPilihJam" name="pilih_jam" class="bf-select bf-input">
                                        <option value="">-- Pilih Jam --</option>
                                        <option value="08:00 - 09:00">08:00 - 09:00</option>
                                        <option value="09:00 - 10:00">09:00 - 10:00</option>
                                        <option value="10:00 - 11:00">10:00 - 11:00</option>
                                        <option value="11:00 - 12:00">11:00 - 12:00</option>
                                        <option value="12:00 - 13:00">12:00 - 13:00</option>
                                        <option value="13:00 - 14:00">13:00 - 14:00</option>
                                        <option value="14:00 - 15:00">14:00 - 15:00</option>
                                        <option value="15:00 - 16:00">15:00 - 16:00</option>
                                        <option value="16:00 - 17:00">16:00 - 17:00</option>
                                        <option value="17:00 - 18:00">17:00 - 18:00</option>
                                        <option value="18:00 - 19:00">18:00 - 19:00</option>
                                        <option value="19:00 - 20:00">19:00 - 20:00</option>
                                        <option value="20:00 - 21:00">20:00 - 21:00</option>
                                        <option value="21:00 - 22:00">21:00 - 22:00</option>
                                        <option value="22:00 - 23:00">22:00 - 23:00</option>
                                        <option value="23:00 - 24:00">23:00 - 24:00</option>
                                    </select>
                                </div>
                            </div>
                            <div class="bf-field" id="fieldDurasiWrap">
                                <label for="formDurasi" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">timer</span>
                                    <span id="labelDurasiText">Durasi Bermain</span>
                                </label>
                                <div class="bf-input-wrap">
                                    <span class="material-symbols-outlined bf-input-icon">schedule</span>
                                    <input type="number" id="formDurasi" name="durasi" class="bf-input" min="1"
                                        value="1">
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

                            <!-- Submit Button — opens payment guide modal -->
                            <button type="button" class="bf-submit-btn" id="btnSubmitBooking" data-bs-toggle="modal"
                                data-bs-target="#petunjukBayarModal">
                                <span class="material-symbols-outlined" style="font-size:1.2rem;">check_circle</span>
                                Booking Sekarang
                            </button>

                            <!-- Terms -->
                            <p class="bf-terms">
                                Dengan menekan tombol di atas, Anda menyetujui
                                <a href="#">syarat & ketentuan</a> yang berlaku.
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

<style>
    /* ===== PETUNJUK BAYAR MODAL ===== */
    .pbm-dialog {
        max-width: 440px;
    }

    .pbm-content {
        border-radius: 1.25rem;
        overflow: hidden;
        border: none;
        box-shadow: 0 20px 60px -10px rgba(0, 0, 0, 0.25);
    }

    .pbm-header {
        background: linear-gradient(135deg, #1d4ed8 0%, #4f46e5 100%);
        border-bottom: none;
        padding: 1.1rem 1.5rem;
    }

    .pbm-title {
        color: #fff;
        font-size: 1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    .pbm-title .material-symbols-outlined {
        font-size: 1.25rem;
    }

    /* Total Box */
    .pbm-total-box {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
        margin: 0 -0.75rem;
        padding: 1.6rem 2rem;
        text-align: center;
        border-bottom: 3px solid #facc15;
    }

    .pbm-total-label {
        color: #94a3b8;
        font-size: 0.78rem;
        font-weight: 500;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 0.35rem;
    }

    .pbm-total-amount {
        color: #facc15;
        font-size: 2.4rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin: 0 0 0.35rem;
        line-height: 1;
    }

    .pbm-total-sub {
        color: #64748b;
        font-size: 0.75rem;
        margin: 0;
    }

    /* Body */
    .pbm-body {
        padding: 0.75rem;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    /* Sections */
    .pbm-section {
        background: #fff;
        border-radius: 0.85rem;
        padding: 0.9rem 1rem;
        margin-bottom: 0.6rem;
        border: 1px solid #e2e8f0;
    }

    .pbm-section-title {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
    }

    .pbm-section-title .material-symbols-outlined {
        font-size: 1rem;
        color: #4f46e5;
    }

    /* Bank Card */
    .pbm-bank-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: #f1f5f9;
        border-radius: 0.6rem;
        padding: 0.75rem 0.9rem;
        position: relative;
    }

    .pbm-bank-logo {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        background: linear-gradient(135deg, #1d4ed8, #4f46e5);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .pbm-bank-logo .material-symbols-outlined {
        color: #fff;
        font-size: 1.3rem;
    }

    .pbm-bank-info {
        flex: 1;
    }

    .pbm-bank-name {
        font-weight: 700;
        font-size: 0.85rem;
        color: #0f172a;
        margin: 0 0 0.1rem;
    }

    .pbm-bank-norek {
        font-family: 'Courier New', monospace;
        font-size: 1rem;
        font-weight: 700;
        color: #1d4ed8;
        letter-spacing: 0.05em;
        margin: 0 0 0.1rem;
    }

    .pbm-bank-an {
        font-size: 0.72rem;
        color: #64748b;
        margin: 0;
    }

    .pbm-copy-btn {
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 0.45rem;
        padding: 0.3rem 0.4rem;
        cursor: pointer;
        color: #4f46e5;
        display: flex;
        align-items: center;
        transition: background 0.15s, color 0.15s;
        flex-shrink: 0;
    }

    .pbm-copy-btn:hover {
        background: #ede9fe;
    }

    .pbm-copy-btn .material-symbols-outlined {
        font-size: 1rem;
    }

    /* Steps */
    .pbm-steps {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .pbm-step {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        font-size: 0.83rem;
        color: #334155;
        font-weight: 500;
    }

    .pbm-step-num {
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #1d4ed8, #4f46e5);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Upload Zone */
    .pbm-upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 0.75rem;
        padding: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        background: #f8fafc;
    }

    .pbm-upload-zone:hover,
    .pbm-upload-zone.has-file {
        border-color: #4f46e5;
        background: #eef2ff;
    }

    .pbm-upload-icon {
        font-size: 2rem;
        color: #94a3b8;
        display: block;
        margin-bottom: 0.35rem;
        transition: color 0.2s;
    }

    .pbm-upload-zone:hover .pbm-upload-icon {
        color: #4f46e5;
    }

    .pbm-upload-text {
        font-size: 0.83rem;
        font-weight: 600;
        color: #475569;
        margin: 0 0 0.1rem;
    }

    .pbm-upload-hint {
        font-size: 0.72rem;
        color: #94a3b8;
        margin: 0;
    }

    .pbm-remove-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        border-radius: 0.4rem;
        padding: 0.25rem 0.65rem;
        font-size: 0.72rem;
        font-weight: 600;
        cursor: pointer;
    }

    .pbm-remove-btn .material-symbols-outlined {
        font-size: 0.9rem;
    }

    /* Footer */
    .pbm-footer {
        background: #fff;
        border-top: 1px solid #e2e8f0;
        padding: 0.85rem 1rem;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .pbm-btn-batal,
    .pbm-btn-kirim {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 1.1rem;
        border-radius: 0.6rem;
        font-size: 0.82rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: background 0.18s, transform 0.15s, box-shadow 0.18s;
    }

    .pbm-btn-batal .material-symbols-outlined,
    .pbm-btn-kirim .material-symbols-outlined {
        font-size: 1rem;
    }

    .pbm-btn-batal {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .pbm-btn-batal:hover {
        background: #e2e8f0;
    }

    .pbm-btn-kirim {
        background: linear-gradient(135deg, #1d4ed8, #4f46e5);
        color: #fff;
    }

    .pbm-btn-kirim:hover {
        background: linear-gradient(135deg, #1e40af, #4338ca);
        box-shadow: 0 6px 16px -4px rgba(79, 70, 229, 0.45);
        transform: translateY(-1px);
    }

    .pbm-btn-kirim:active {
        transform: translateY(0);
    }
</style>

<script>
    (function () {
        const MONTH_NAMES = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        const DAY_NAMES = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Read URL query params
        const params = new URLSearchParams(window.location.search);
        const lapang = params.get('lapang');
        const tanggal = params.get('tanggal');
        const jam = params.get('jam');
        const sewaParam = params.get('sewa'); // 'per-jam' | 'per-hari' | 'membership'

        // Summary elements
        const sumLapang = document.getElementById('summaryLapang');
        const sumTanggal = document.getElementById('summaryTanggal');
        const sumJam = document.getElementById('summaryJam');
        const sumDurasi = document.getElementById('summaryDurasi');
        const sumHarga = document.getElementById('summaryHarga');

        // Hidden form fields
        const fLapang = document.getElementById('formLapang');
        const fTanggal = document.getElementById('formTanggal');
        const fJam = document.getElementById('formJam');

        // Manual select fields
        const fieldLapang = document.getElementById('fieldPilihLapang');
        const fieldTanggal = document.getElementById('fieldPilihTanggal');
        const fieldJam = document.getElementById('fieldPilihJam');
        const selLapang = document.getElementById('formPilihLapang');
        const selTanggal = document.getElementById('formPilihTanggal');
        const selJam = document.getElementById('formPilihJam');
        const fIdLapang = document.getElementById('formIdLapang');
        const fTotalBayar = document.getElementById('formTotalBayar');

        // Lapangs data from API
        let lapangsApiData = [];

        let hasPreselected = false;

        // If params are provided (from index.php), pre-fill and hide manual selectors
        if (lapang) {
            sumLapang.textContent = lapang;
            // We'll set fIdLapang when lapangs data loads
            fieldLapang.style.display = 'none';
            hasPreselected = true;
        }

        if (tanggal) {
            const parts = tanggal.split('-');
            const dt = new Date(+parts[0], +parts[1] - 1, +parts[2]);
            sumTanggal.textContent = `${DAY_NAMES[dt.getDay()]}, ${dt.getDate()} ${MONTH_NAMES[dt.getMonth()]} ${dt.getFullYear()}`;
            fTanggal.value = tanggal;
            fieldTanggal.style.display = 'none';
            hasPreselected = true;
        }

        if (jam) {
            sumJam.textContent = jam;
            // Store jam in HH:00 format for backend
            const jamParts = jam.split('.');
            const jamFormatted = jamParts[0].padStart(2, '0') + ':00';
            fJam.value = jamFormatted;
            fieldJam.style.display = 'none';
            sumDurasi.textContent = '1 Jam';
            hasPreselected = true;
        }

        // If manual selection, update summary on change
        if (!lapang && selLapang) {
            selLapang.addEventListener('change', () => {
                const selectedOpt = selLapang.options[selLapang.selectedIndex];
                sumLapang.textContent = selectedOpt.textContent || '-';
                fIdLapang.value = selLapang.value;
                updateSummaryData();
            });
        }

        if (!tanggal && selTanggal) {
            selTanggal.addEventListener('change', () => {
                if (selTanggal.value) {
                    const parts = selTanggal.value.split('-');
                    const dt = new Date(+parts[0], +parts[1] - 1, +parts[2]);
                    sumTanggal.textContent = `${DAY_NAMES[dt.getDay()]}, ${dt.getDate()} ${MONTH_NAMES[dt.getMonth()]} ${dt.getFullYear()}`;
                    fTanggal.value = selTanggal.value;
                } else {
                    sumTanggal.textContent = '-';
                    fTanggal.value = '';
                }
            });
        }

        if (!jam && selJam) {
            selJam.addEventListener('change', () => {
                sumJam.textContent = selJam.value || '-';
                fJam.value = selJam.value;
                updateSummaryData();
            });
        }

        // ─── Fetch lapangs from API to populate dropdown ───
        async function loadLapangs() {
            try {
                const res = await fetch('<?= base_url("/api/getLapangs") ?>');
                lapangsApiData = await res.json();

                if (selLapang) {
                    selLapang.innerHTML = '<option value="">-- Pilih Lapangan --</option>';
                    lapangsApiData.forEach(l => {
                        const opt = document.createElement('option');
                        opt.value = l.id_lapang;
                        opt.textContent = l.nama_lapangan;
                        selLapang.appendChild(opt);
                    });
                }

                // If preselected via URL, find id_lapang by name
                if (lapang) {
                    const found = lapangsApiData.find(l => l.nama_lapangan === lapang);
                    if (found) {
                        fIdLapang.value = found.id_lapang;
                        fetchTarif(found.id_lapang);
                    }
                }
            } catch (err) {
                console.error('Failed to load lapangs:', err);
            }
        }

        // ─── Fetch tarif from API ───
        let currentTarifs = [];
        async function fetchTarif(idLapang) {
            const tgl = fTanggal.value || (selTanggal ? selTanggal.value : '');
            if (!idLapang || !tgl) return;
            try {
                const res = await fetch(`<?= base_url('/api/getTarif') ?>?id_lapang=${idLapang}&tanggal=${tgl}`);
                const data = await res.json();
                currentTarifs = data.tarifs || [];
                updateSummaryData();
            } catch (err) {
                console.error('Failed to fetch tarif:', err);
            }
        }

        // Tipe Sewa Radio Button Logic
        const radioReguler = document.getElementById('sewaReguler');
        const radioHarian = document.getElementById('sewaHarian');
        const radioMembership = document.getElementById('sewaMembership');
        const formDurasi = document.getElementById('formDurasi');
        const labelDurasiText = document.getElementById('labelDurasiText');
        const summaryDurasiLabel = document.getElementById('summaryDurasiLabel');

        radioReguler.addEventListener('change', updateSummaryData);
        radioHarian.addEventListener('change', updateSummaryData);
        radioMembership.addEventListener('change', updateSummaryData);
        formDurasi.addEventListener('input', updateSummaryData);

        function getHargaDasar() {
            // Get jam from hidden field
            const jamVal = fJam.value || '';
            const jamHour = parseInt(jamVal) || 0;

            if (currentTarifs.length > 0) {
                // Find matching tarif by hour range
                for (const t of currentTarifs) {
                    const tStart = parseInt(t.jam_mulai) || 0;
                    const tEnd   = parseInt(t.jam_selesai) || 24;
                    if (jamHour >= tStart && jamHour < tEnd) {
                        return parseInt(t.harga_umum) || 0;
                    }
                }
                // Fallback: use first tarif
                return parseInt(currentTarifs[0].harga_umum) || 0;
            }
            return 0;
        }

        function updateSummaryData() {
            const hargaDasar = getHargaDasar();
            const isMembership = radioMembership.checked;
            const isHarian = radioHarian.checked;
            const fTipeSewa = document.getElementById('formTipeSewa');

            // Ambil input durasi (default 1 jika kosong/invalid)
            let durasiVal = parseInt(formDurasi.value) || 1;

            // Cek apakah jam sudah terisi
            const isJamFilled = fJam.value || (selJam && selJam.value);
            let totalHarga = 0;

            // Sync hidden tipe_sewa field
            if (isHarian) {
                fTipeSewa.value = 'Harian';
            } else if (isMembership) {
                fTipeSewa.value = 'Membership';
            } else {
                fTipeSewa.value = 'Per Jam';
            }

            if (isHarian) {
                labelDurasiText.textContent = 'Durasi Hari';
                summaryDurasiLabel.textContent = 'Durasi Hari';

                // Compute operating hours from lapang data
                let opHours = 12; // default full day hours
                const tgl = fTanggal.value || (selTanggal ? selTanggal.value : '');
                const currentIdLapang = fIdLapang.value || (selLapang ? selLapang.value : '');
                if (tgl && currentIdLapang && lapangsApiData.length > 0) {
                    const lapangInfo = lapangsApiData.find(l => String(l.id_lapang) === String(currentIdLapang));
                    if (lapangInfo) {
                        const dt = new Date(tgl);
                        const dow = dt.getDay();
                        const isWeekend = (dow === 0 || dow === 6);
                        const jamBuka = parseInt(isWeekend ? lapangInfo.jam_buka_weekend : lapangInfo.jam_buka_weekday) || 0;
                        let jamTutup = parseInt(isWeekend ? lapangInfo.jam_tutup_weekend : lapangInfo.jam_tutup_weekday) || 0;
                        if (jamTutup <= jamBuka) jamTutup = 24;
                        opHours = jamTutup - jamBuka;

                        // Set jam_mulai to actual opening hour
                        fJam.value = String(jamBuka).padStart(2, '0') + ':00';
                        sumJam.textContent = String(jamBuka).padStart(2, '0') + '.00 - ' + String(jamTutup).padStart(2, '0') + '.00 (Full Day)';
                    }
                } else {
                    sumJam.textContent = '08:00 - 20:00 (Full)';
                    fJam.value = '08:00';
                }

                const hargaHarian = hargaDasar * opHours;
                totalHarga = hargaHarian * durasiVal;
                sumDurasi.textContent = durasiVal + ' Hari (' + opHours + ' jam/hari)';
                sumHarga.textContent = hargaDasar > 0 ? 'Rp ' + totalHarga.toLocaleString('id-ID') : 'Rp -';

                // Set durasi in HOURS for backend (total operating hours * days)
                formDurasi.setAttribute('data-original', durasiVal);
                formDurasi.setAttribute('data-ophours', opHours);

                if (selJam) {
                    selJam.disabled = true;
                    selJam.value = '';
                }

                // Hide membership UI when in harian mode
                const diskonWrapH = document.getElementById('summaryDiskonWrap');
                const memberDatesWrapH = document.getElementById('summaryMembershipDates');
                if (diskonWrapH) diskonWrapH.style.display = 'none';
                if (memberDatesWrapH) memberDatesWrapH.style.display = 'none';
            } else {
                labelDurasiText.textContent = 'Durasi Bermain';
                summaryDurasiLabel.textContent = 'Durasi Bermain';

                if (selJam && selJam.disabled) {
                    selJam.disabled = false;
                    sumJam.textContent = selJam.value || '-';
                    fJam.value = selJam.value;
                }

                // Clear harian data attributes
                formDurasi.removeAttribute('data-original');
                formDurasi.removeAttribute('data-ophours');

                if (isJamFilled || (selJam && selJam.value)) {
                    if (isMembership) {
                        const hargaNormal = hargaDasar * 4 * durasiVal;
                        const diskon = Math.round(hargaNormal * 0.1);
                        totalHarga = hargaNormal - diskon;
                        sumDurasi.textContent = '4x Main (' + durasiVal + ' Jam/sesi) — Diskon 10%';

                        // Show discount breakdown
                        const diskonWrap = document.getElementById('summaryDiskonWrap');
                        const hargaNormalEl = document.getElementById('summaryHargaNormal');
                        const hargaHematEl = document.getElementById('summaryHargaHemat');
                        if (diskonWrap && hargaDasar > 0) {
                            diskonWrap.style.display = 'block';
                            hargaNormalEl.textContent = 'Rp ' + hargaNormal.toLocaleString('id-ID');
                            hargaHematEl.textContent = '- Rp ' + diskon.toLocaleString('id-ID');
                        }

                        // Generate & show 4 weekly dates
                        const tgl = fTanggal.value || (selTanggal ? selTanggal.value : '');
                        const memberDatesWrap = document.getElementById('summaryMembershipDates');
                        const memberDatesList = document.getElementById('membershipDatesList');
                        if (tgl && memberDatesWrap) {
                            const baseDt = new Date(tgl);
                            let datesHtml = '';
                            for (let i = 0; i < 4; i++) {
                                const d = new Date(baseDt);
                                d.setDate(d.getDate() + (i * 7));
                                const label = DAY_NAMES[d.getDay()] + ', ' + d.getDate() + ' ' + MONTH_NAMES[d.getMonth()] + ' ' + d.getFullYear();
                                datesHtml += '<div style="display:flex;align-items:center;gap:0.35rem;font-size:0.78rem;color:var(--on-surface);padding:0.15rem 0;">' +
                                    '<span class="material-symbols-outlined" style="font-size:0.85rem;color:#059669;">event_available</span>' +
                                    '<span>Sesi ' + (i+1) + ': <strong>' + label + '</strong></span></div>';
                            }
                            memberDatesList.innerHTML = datesHtml;
                            memberDatesWrap.style.display = 'flex';
                        }
                    } else {
                        totalHarga = hargaDasar * durasiVal;
                        sumDurasi.textContent = durasiVal + ' Jam';

                        // Hide membership UI
                        const diskonWrap = document.getElementById('summaryDiskonWrap');
                        const memberDatesWrap = document.getElementById('summaryMembershipDates');
                        if (diskonWrap) diskonWrap.style.display = 'none';
                        if (memberDatesWrap) memberDatesWrap.style.display = 'none';
                    }
                    sumHarga.textContent = hargaDasar > 0 ? 'Rp ' + totalHarga.toLocaleString('id-ID') : 'Rp -';
                } else {
                    sumDurasi.textContent = '-';
                    sumHarga.textContent = 'Rp -';
                    // Hide membership UI
                    const diskonWrap = document.getElementById('summaryDiskonWrap');
                    const memberDatesWrap = document.getElementById('summaryMembershipDates');
                    if (diskonWrap) diskonWrap.style.display = 'none';
                    if (memberDatesWrap) memberDatesWrap.style.display = 'none';
                }
            }

            // Update hidden total_bayar field
            fTotalBayar.value = totalHarga;

            // Show/hide payment type selector (only for Per Jam & Harian)
            const payTypeWrap = document.getElementById('summaryPaymentType');
            if (payTypeWrap) {
                payTypeWrap.style.display = (isMembership || totalHarga <= 0) ? 'none' : 'block';
                // Reset to Full when switching to membership
                if (isMembership) {
                    const fullRadio = document.querySelector('input[name="bayar_type"][value="Full"]');
                    if (fullRadio) fullRadio.checked = true;
                    document.getElementById('formJenisPembayaran').value = 'Full';
                }
            }
            updatePaymentType();
        }

        // Pre-select tipe sewa from URL param
        if (sewaParam === 'per-hari') {
            radioHarian.checked = true;
            hasPreselected = true;
        } else if (sewaParam === 'membership') {
            radioMembership.checked = true;
            hasPreselected = true;
        } else if (sewaParam === 'per-jam') {
            radioReguler.checked = true;
        }

        // Initial call if preselected
        if (hasPreselected) {
            updateSummaryData();
        }

        // Load lapangs on init
        loadLapangs();

        // Fetch tarif when lapang or tanggal changes
        if (selLapang) {
            selLapang.addEventListener('change', () => {
                fetchTarif(selLapang.value);
            });
        }
        if (selTanggal) {
            selTanggal.addEventListener('change', () => {
                fetchTarif(fIdLapang.value || (selLapang ? selLapang.value : ''));
            });
        }
    })();

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

        // Sync total & sub-info from summary card when modal opens
        modal.addEventListener('show.bs.modal', function () {
            const harga = document.getElementById('summaryHarga');
            const lapang = document.getElementById('summaryLapang');
            const tgl = document.getElementById('summaryTanggal');
            const jam = document.getElementById('summaryJam');

            pbmTotal.textContent = harga && harga.textContent !== 'Rp -' ? harga.textContent : 'Rp 75.000';

            // If DP mode, show DP amount instead of total
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

        // Upload zone click
        uploadZone.addEventListener('click', () => fileInput.click());

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

        // Remove file
        removeBtn.addEventListener('click', function () {
            fileInput.value = '';
            previewImg.src = '';
            previewWrap.style.display = 'none';
            uploadZone.classList.remove('has-file');
            uploadZone.querySelector('.pbm-upload-text').textContent = 'Klik untuk pilih file';
            uploadZone.querySelector('.pbm-upload-hint').textContent = 'JPG, PNG — Maks 2MB';
        });

        // Copy nomor rekening
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

        // Submit form from inside modal
        kirimBtn.addEventListener('click', function () {
            const form = document.getElementById('bookingForm');
            if (form) {
                // If harian mode, convert durasi (days) to total hours before submit
                const durasiInput = document.getElementById('formDurasi');
                const tipeSewa = document.getElementById('formTipeSewa');
                if (tipeSewa && tipeSewa.value === 'Harian' && durasiInput) {
                    const opHours = parseInt(durasiInput.getAttribute('data-ophours')) || 12;
                    const days = parseInt(durasiInput.value) || 1;
                    // Store original day count before converting
                    document.getElementById('formJumlahHari').value = days;
                    durasiInput.value = opHours * days;
                }
                form.submit();
            }
        });
    })();

    /* ===== GLOBAL: Update Payment Type (Full / DP) ===== */
    function updatePaymentType() {
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

        // Highlight active label
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
    }
</script>

<?= $this->endSection() ?>