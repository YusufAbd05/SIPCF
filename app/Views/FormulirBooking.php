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

                            <!-- Submit Button -->
                            <button type="submit" class="bf-submit-btn" id="btnSubmitBooking">
                                <span class="material-symbols-outlined" style="font-size:1.2rem;">check_circle</span>
                                Konfirmasi Booking
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
</script>

<?= $this->endSection() ?>