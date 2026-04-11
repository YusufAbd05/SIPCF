<?= $this->extend('template/landing/base') ?>
<?= $this->section('title') ?>Daftar Membership<?= $this->endSection() ?>
<?= $this->section('content') ?>

<!-- ================= DAFTAR MEMBERSHIP ================= -->
<section class="schedule-section">
    <div class="container">

        <!-- Back Button -->
        <a href="<?= base_url('/membership') ?>" class="booking-back-btn">
            <span class="material-symbols-outlined" style="font-size:1.1rem;">arrow_back</span>
            Kembali ke Membership
        </a>

        <!-- Section Header -->
        <div class="text-center mb-5">
            <div class="section-chip mx-auto mb-3">
                <span class="material-symbols-outlined" style="font-size:1rem;">how_to_reg</span>
                Pendaftaran Member
            </div>
            <h2 class="schedule-heading">Daftar Membership</h2>
            <p class="schedule-subheading mt-3">Lengkapi data diri Anda untuk mendaftar sebagai member</p>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- Left: Paket Summary -->
            <div class="col-12 col-lg-5">
                <div class="bf-summary-card">
                    <div class="bf-summary-header">
                        <span class="material-symbols-outlined" style="font-size:1.5rem;">card_membership</span>
                        <span>Paket Dipilih</span>
                    </div>
                    <div class="bf-summary-body">
                        <!-- Paket -->
                        <div class="bf-summary-item">
                            <div class="bf-summary-icon">
                                <span class="material-symbols-outlined">loyalty</span>
                            </div>
                            <div>
                                <span class="bf-summary-label">Paket</span>
                                <span class="bf-summary-value" id="summaryPaket">-</span>
                            </div>
                        </div>
                        <!-- Durasi -->
                        <div class="bf-summary-item">
                            <div class="bf-summary-icon">
                                <span class="material-symbols-outlined">schedule</span>
                            </div>
                            <div>
                                <span class="bf-summary-label">Durasi</span>
                                <span class="bf-summary-value" id="summaryDurasi">-</span>
                            </div>
                        </div>
                        <!-- Diskon -->
                        <div class="bf-summary-item">
                            <div class="bf-summary-icon">
                                <span class="material-symbols-outlined">percent</span>
                            </div>
                            <div>
                                <span class="bf-summary-label">Diskon Booking</span>
                                <span class="bf-summary-value" id="summaryDiskon">-</span>
                            </div>
                        </div>
                        <!-- Sesi Gratis -->
                        <div class="bf-summary-item">
                            <div class="bf-summary-icon">
                                <span class="material-symbols-outlined">redeem</span>
                            </div>
                            <div>
                                <span class="bf-summary-label">Sesi Gratis</span>
                                <span class="bf-summary-value" id="summarySesi">-</span>
                            </div>
                        </div>

                        <hr style="border-color:var(--outline-variant); margin:0.75rem 0;">

                        <!-- Price -->
                        <div class="bf-summary-price">
                            <span>Total Biaya</span>
                            <span class="bf-summary-price-value" id="summaryHarga">Rp -</span>
                        </div>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="bf-info-alert mt-3">
                    <span class="material-symbols-outlined" style="font-size:1.2rem; flex-shrink:0;">info</span>
                    <div>
                        <strong>Informasi</strong>
                        <p class="mb-0 mt-1" style="font-size:.78rem; line-height:1.5;">Membership aktif setelah
                            pembayaran dikonfirmasi. Hubungi admin jika ada pertanyaan lebih lanjut.</p>
                    </div>
                </div>
            </div>

            <!-- Right: Registration Form -->
            <div class="col-12 col-lg-6">
                <div class="bf-form-card">
                    <div class="bf-form-header">
                        <span class="material-symbols-outlined" style="font-size:1.35rem;">person_add</span>
                        <span>Data Pendaftar</span>
                    </div>
                    <div class="bf-form-body">
                        <form id="membershipForm" action="#" method="post">
                            <input type="hidden" name="paket" id="formPaket">

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

                            <!-- Email -->
                            <div class="bf-field">
                                <label for="formEmail" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">mail</span>
                                    Email
                                </label>
                                <div class="bf-input-wrap">
                                    <span class="material-symbols-outlined bf-input-icon">alternate_email</span>
                                    <input type="email" id="formEmail" name="email" class="bf-input"
                                        placeholder="email@contoh.com" required>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="bf-field">
                                <label for="formAlamat" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">home</span>
                                    Alamat
                                </label>
                                <div class="bf-input-wrap bf-input-wrap--textarea">
                                    <textarea id="formAlamat" name="alamat" class="bf-input bf-textarea" rows="2"
                                        placeholder="Masukkan alamat lengkap" required></textarea>
                                </div>
                            </div>

                            <!-- Pilih Paket (if not pre-selected) -->
                            <div class="bf-field" id="fieldPilihPaket">
                                <label for="formPilihPaket" class="bf-field-label">
                                    <span class="material-symbols-outlined bf-field-label-icon">loyalty</span>
                                    Pilih Paket
                                </label>
                                <div class="bf-input-wrap">
                                    <span class="material-symbols-outlined bf-input-icon">card_membership</span>
                                    <select id="formPilihPaket" name="pilih_paket" class="bf-input bf-select">
                                        <option value="">-- Pilih Paket --</option>
                                        <option value="bulanan">Bulanan — Rp 150.000</option>
                                        <option value="3bulan">3 Bulan — Rp 400.000</option>
                                        <option value="tahunan">Tahunan — Rp 1.500.000</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="bf-submit-btn" id="btnSubmitMembership">
                                <span class="material-symbols-outlined" style="font-size:1.2rem;">how_to_reg</span>
                                Daftar Membership
                            </button>

                            <!-- Terms -->
                            <p class="bf-terms">
                                Dengan mendaftar, Anda menyetujui
                                <a href="#">syarat & ketentuan</a> membership yang berlaku.
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
        // Paket data
        const PAKET_DATA = {
            bulanan: {
                nama: 'Paket Bulanan',
                durasi: '1 Bulan',
                diskon: '10%',
                sesi: '1x per bulan',
                harga: 'Rp 150.000'
            },
            '3bulan': {
                nama: 'Paket 3 Bulan',
                durasi: '3 Bulan',
                diskon: '20%',
                sesi: '2x per bulan',
                harga: 'Rp 400.000'
            },
            tahunan: {
                nama: 'Paket Tahunan',
                durasi: '12 Bulan',
                diskon: '30%',
                sesi: '4x per bulan',
                harga: 'Rp 1.500.000'
            }
        };

        const params = new URLSearchParams(window.location.search);
        const paket = params.get('paket');

        const sumPaket = document.getElementById('summaryPaket');
        const sumDurasi = document.getElementById('summaryDurasi');
        const sumDiskon = document.getElementById('summaryDiskon');
        const sumSesi = document.getElementById('summarySesi');
        const sumHarga = document.getElementById('summaryHarga');
        const fPaket = document.getElementById('formPaket');
        const fieldPaket = document.getElementById('fieldPilihPaket');
        const selPaket = document.getElementById('formPilihPaket');

        function fillSummary(key) {
            const data = PAKET_DATA[key];
            if (data) {
                sumPaket.textContent = data.nama;
                sumDurasi.textContent = data.durasi;
                sumDiskon.textContent = data.diskon;
                sumSesi.textContent = data.sesi;
                sumHarga.textContent = data.harga;
                fPaket.value = key;
            }
        }

        // Pre-fill from URL
        if (paket && PAKET_DATA[paket]) {
            fillSummary(paket);
            fieldPaket.style.display = 'none';
        }

        // Manual selection
        if (selPaket) {
            selPaket.addEventListener('change', () => {
                if (selPaket.value && PAKET_DATA[selPaket.value]) {
                    fillSummary(selPaket.value);
                } else {
                    sumPaket.textContent = '-';
                    sumDurasi.textContent = '-';
                    sumDiskon.textContent = '-';
                    sumSesi.textContent = '-';
                    sumHarga.textContent = 'Rp -';
                    fPaket.value = '';
                }
            });
        }
    })();
</script>

<?= $this->endSection() ?>
