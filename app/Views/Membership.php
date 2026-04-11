<?= $this->extend('template/landing/base') ?>
<?= $this->section('title') ?>Membership<?= $this->endSection() ?>
<?= $this->section('content') ?>

<!-- ================= MEMBERSHIP ================= -->
<section class="schedule-section">
    <div class="container">

        <!-- Section Header -->
        <div class="text-center mb-5">
            <div class="section-chip mx-auto mb-3">
                <span class="material-symbols-outlined" style="font-size:1rem;">card_membership</span>
                Membership
            </div>
            <h2 class="schedule-heading">Bergabung Sebagai<br class="d-none d-md-block"> Member</h2>
            <p class="schedule-subheading mt-3">Dapatkan berbagai keuntungan eksklusif dan harga spesial dengan
                menjadi member lapangan kami</p>
        </div>

        <!-- Benefits Section -->
        <div class="row g-4 mb-5 justify-content-center">
            <div class="col-12 col-md-4">
                <div class="ms-benefit-card">
                    <div class="ms-benefit-icon ms-benefit-icon--primary">
                        <span class="material-symbols-outlined">savings</span>
                    </div>
                    <h4 class="ms-benefit-title">Harga Spesial</h4>
                    <p class="ms-benefit-desc">Nikmati potongan harga hingga 30% untuk setiap sesi bermain sebagai
                        member tetap kami.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="ms-benefit-card">
                    <div class="ms-benefit-icon ms-benefit-icon--tertiary">
                        <span class="material-symbols-outlined">priority_high</span>
                    </div>
                    <h4 class="ms-benefit-title">Prioritas Booking</h4>
                    <p class="ms-benefit-desc">Member mendapatkan akses prioritas untuk booking lapangan di jam-jam
                        favorit.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="ms-benefit-card">
                    <div class="ms-benefit-icon ms-benefit-icon--secondary">
                        <span class="material-symbols-outlined">event_repeat</span>
                    </div>
                    <h4 class="ms-benefit-title">Jadwal Rutin</h4>
                    <p class="ms-benefit-desc">Atur jadwal bermain rutin mingguan tanpa perlu booking ulang setiap
                        kali.</p>
                </div>
            </div>
        </div>

        <!-- Pricing Cards -->
        <div class="text-center mb-4">
            <h3 class="results-title">Pilih Paket Membership</h3>
            <p class="schedule-subheading mt-2">Pilih paket yang paling sesuai dengan kebutuhan Anda</p>
        </div>

        <div class="row g-4 mb-5 justify-content-center">
            <!-- Paket Bulanan -->
            <div class="col-12 col-md-4">
                <div class="ms-pricing-card">
                    <div class="ms-pricing-header">
                        <span class="ms-pricing-badge">Bulanan</span>
                        <div class="ms-pricing-price">
                            <span class="ms-pricing-currency">Rp</span>
                            <span class="ms-pricing-amount">150.000</span>
                        </div>
                        <span class="ms-pricing-period">/ bulan</span>
                    </div>
                    <div class="ms-pricing-body">
                        <ul class="ms-pricing-features">
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Diskon 10% setiap booking
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Prioritas booking 1 hari sebelum
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Akses 3 lapangan
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Gratis 1x sesi per bulan
                            </li>
                            <li class="ms-feature-disabled">
                                <span class="material-symbols-outlined">cancel</span>
                                Jadwal rutin mingguan
                            </li>
                            <li class="ms-feature-disabled">
                                <span class="material-symbols-outlined">cancel</span>
                                Free locker
                            </li>
                        </ul>
                        <a href="<?= base_url('/daftar-membership?paket=bulanan') ?>"
                            class="ms-pricing-btn ms-pricing-btn--outline">
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">arrow_forward</span>
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Paket 3 Bulan (Popular) -->
            <div class="col-12 col-md-4">
                <div class="ms-pricing-card ms-pricing-card--popular">
                    <div class="ms-popular-ribbon">POPULER</div>
                    <div class="ms-pricing-header ms-pricing-header--popular">
                        <span class="ms-pricing-badge ms-pricing-badge--popular">3 Bulan</span>
                        <div class="ms-pricing-price">
                            <span class="ms-pricing-currency">Rp</span>
                            <span class="ms-pricing-amount">400.000</span>
                        </div>
                        <span class="ms-pricing-period">/ 3 bulan</span>
                        <div class="ms-pricing-save">Hemat Rp 50.000</div>
                    </div>
                    <div class="ms-pricing-body">
                        <ul class="ms-pricing-features">
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Diskon 20% setiap booking
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Prioritas booking 3 hari sebelum
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Akses 3 lapangan
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Gratis 2x sesi per bulan
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Jadwal rutin mingguan
                            </li>
                            <li class="ms-feature-disabled">
                                <span class="material-symbols-outlined">cancel</span>
                                Free locker
                            </li>
                        </ul>
                        <a href="<?= base_url('/daftar-membership?paket=3bulan') ?>"
                            class="ms-pricing-btn ms-pricing-btn--primary">
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">star</span>
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Paket Tahunan -->
            <div class="col-12 col-md-4">
                <div class="ms-pricing-card">
                    <div class="ms-pricing-header">
                        <span class="ms-pricing-badge">Tahunan</span>
                        <div class="ms-pricing-price">
                            <span class="ms-pricing-currency">Rp</span>
                            <span class="ms-pricing-amount">1.500.000</span>
                        </div>
                        <span class="ms-pricing-period">/ tahun</span>
                        <div class="ms-pricing-save">Hemat Rp 300.000</div>
                    </div>
                    <div class="ms-pricing-body">
                        <ul class="ms-pricing-features">
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Diskon 30% setiap booking
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Prioritas booking 7 hari sebelum
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Akses 3 lapangan
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Gratis 4x sesi per bulan
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Jadwal rutin mingguan
                            </li>
                            <li>
                                <span class="material-symbols-outlined ms-check">check_circle</span>
                                Free locker
                            </li>
                        </ul>
                        <a href="<?= base_url('/daftar-membership?paket=tahunan') ?>"
                            class="ms-pricing-btn ms-pricing-btn--outline">
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">arrow_forward</span>
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="ms-faq-card mx-auto">
            <div class="text-center mb-4">
                <h3 class="results-title">Pertanyaan Umum</h3>
            </div>
            <div class="accordion" id="faqAccordion">
                <div class="ms-faq-item">
                    <button class="ms-faq-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq1"
                        aria-expanded="true">
                        <span>Bagaimana cara mendaftar membership?</span>
                        <span class="material-symbols-outlined ms-faq-arrow">expand_more</span>
                    </button>
                    <div id="faq1" class="collapse show" data-bs-parent="#faqAccordion">
                        <div class="ms-faq-answer">
                            Klik tombol "Daftar Sekarang" pada paket yang diinginkan, lalu isi formulir pendaftaran
                            dengan data diri Anda. Setelah itu, lakukan pembayaran sesuai paket yang dipilih.
                        </div>
                    </div>
                </div>
                <div class="ms-faq-item">
                    <button class="ms-faq-btn collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq2">
                        <span>Apakah membership bisa diperpanjang?</span>
                        <span class="material-symbols-outlined ms-faq-arrow">expand_more</span>
                    </button>
                    <div id="faq2" class="collapse" data-bs-parent="#faqAccordion">
                        <div class="ms-faq-answer">
                            Ya, membership otomatis bisa diperpanjang sebelum masa berlaku habis. Anda akan mendapat
                            notifikasi pengingat 7 hari sebelum expired.
                        </div>
                    </div>
                </div>
                <div class="ms-faq-item">
                    <button class="ms-faq-btn collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq3">
                        <span>Apakah bisa upgrade paket?</span>
                        <span class="material-symbols-outlined ms-faq-arrow">expand_more</span>
                    </button>
                    <div id="faq3" class="collapse" data-bs-parent="#faqAccordion">
                        <div class="ms-faq-answer">
                            Tentu! Anda bisa upgrade paket kapan saja. Selisih harga akan dihitung secara prorata
                            berdasarkan sisa masa berlaku membership Anda.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>
