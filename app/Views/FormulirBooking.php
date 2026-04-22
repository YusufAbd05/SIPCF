<?= $this->extend('template/landing/base') ?>
<?= $this->section('title') ?>Formulir Booking<?= $this->endSection() ?>
<?= $this->section('content') ?>

<!-- ================= FORMULIR BOOKING ================= -->
<section class="schedule-section">
    <div class="container">

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
                                <span class="bf-summary-label">Durasi</span>
                                <span class="bf-summary-value" id="summaryDurasi">-</span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <hr style="border-color:var(--outline-variant); margin:0.75rem 0;">

                        <!-- Price -->
                        <div class="bf-summary-price">
                            <span>Total Estimasi</span>
                            <span class="bf-summary-price-value" id="summaryHarga">Rp -</span>
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
                        <form id="bookingForm" action="#" method="post">
                            <!-- Hidden fields for booking data -->
                            <input type="hidden" name="lapang" id="formLapang">
                            <input type="hidden" name="tanggal" id="formTanggal">
                            <input type="hidden" name="jam" id="formJam">

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
                                        <option value="Lapang 1">Lapang 1</option>
                                        <option value="Lapang 2">Lapang 2</option>
                                        <option value="Lapang 3">Lapang 3</option>
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
                            <div class="bf-field" id="fieldPilihJam">
                                <label for="formPilihJam" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">schedule</span>
                                    Durasi Bermain
                                </label>
                                <div class="bf-input-wrap">
                                    <span class="material-symbols-outlined bf-input-icon">schedule</span>
                                    <input type="text" id="formDurasi" name="durasi" class="bf-input">
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
                        <input type="file" id="pbmFileInput" accept="image/*" style="display:none;">
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

        let hasPreselected = false;

        // If params are provided (from index.php), pre-fill and hide manual selectors
        if (lapang) {
            sumLapang.textContent = lapang;
            fLapang.value = lapang;
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
            fJam.value = jam;
            fieldJam.style.display = 'none';
            sumDurasi.textContent = '1 Jam';
            sumHarga.textContent = 'Rp 75.000';
            hasPreselected = true;
        }

        // If manual selection, update summary on change
        if (!lapang && selLapang) {
            selLapang.addEventListener('change', () => {
                sumLapang.textContent = selLapang.value || '-';
                fLapang.value = selLapang.value;
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
                if (selJam.value) {
                    sumDurasi.textContent = '1 Jam';
                    sumHarga.textContent = 'Rp 75.000';
                } else {
                    sumDurasi.textContent = '-';
                    sumHarga.textContent = 'Rp -';
                }
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
            if (form) form.submit();
        });
    })();
</script>

<?= $this->endSection() ?>