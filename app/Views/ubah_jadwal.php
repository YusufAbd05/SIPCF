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
                <p class="schedule-subheading mt-3">Masukkan kode booking yang Anda terima untuk mengubah jadwal konsultasi</p>
            </div>

            <!-- Booking Code Card -->
            <div class="booking-card mx-auto" id="bookingLookup">
                <!-- Illustration -->
                <div class="booking-card__icon-wrap">
                    <div class="booking-card__icon">
                        <span class="material-symbols-outlined">confirmation_number</span>
                    </div>
                </div>

                <h4 class="booking-card__title">Masukkan Kode Booking</h4>
                <p class="booking-card__desc">Kode booking terdapat pada email konfirmasi atau SMS yang Anda terima saat melakukan pemesanan jadwal.</p>

                <!-- Input Group -->
                <form id="formBookingCode" class="booking-form" onsubmit="return handleLookup(event)">
                    <div class="booking-input-group">
                        <span class="material-symbols-outlined booking-input-icon">tag</span>
                        <input
                            type="text"
                            id="inputBookingCode"
                            class="booking-input"
                            placeholder="Contoh: BK-2024-XXXX"
                            maxlength="20"
                            autocomplete="off"
                            required
                        >
                    </div>
                    <button type="submit" class="booking-submit-btn" id="btnLookup">
                        <span class="material-symbols-outlined" style="font-size:1.15rem;">search</span>
                        Cari Booking
                    </button>
                </form>

                <!-- Error State (hidden by default) -->
                <div class="booking-alert booking-alert--error d-none" id="alertError">
                    <span class="material-symbols-outlined">error</span>
                    <div>
                        <strong>Kode booking tidak ditemukan</strong>
                        <p class="mb-0">Periksa kembali kode booking Anda dan pastikan formatnya benar.</p>
                    </div>
                </div>

                <!-- Help Info -->
                <div class="booking-help">
                    <span class="material-symbols-outlined" style="font-size:1rem;">help</span>
                    <span>Tidak memiliki kode booking? <a href="<?= base_url('/') ?>" class="booking-help-link">Buat jadwal baru</a></span>
                </div>
            </div>

            <!-- Result Card (hidden by default, shown after successful lookup) -->
            <div class="booking-result-card mx-auto d-none" id="bookingResult">
                <!-- Back Button -->
                <button type="button" class="booking-back-btn" onclick="showLookup()">
                    <span class="material-symbols-outlined" style="font-size:1.1rem;">arrow_back</span>
                    Kembali
                </button>

                <!-- Booking Info Header -->
                <div class="booking-result__header">
                    <div class="booking-result__status">
                        <span class="status-pill status-pill--available">Aktif</span>
                    </div>
                    <h4 class="booking-result__title" id="resultTitle">Konsultasi Strategis</h4>
                    <p class="booking-result__code" id="resultCode">BK-2024-0812</p>
                </div>

                <!-- Booking Details -->
                <div class="booking-result__details">
                    <div class="booking-detail-row">
                        <div class="booking-detail-item">
                            <span class="material-symbols-outlined booking-detail-icon">calendar_month</span>
                            <div>
                                <span class="booking-detail-label">Tanggal</span>
                                <span class="booking-detail-value" id="resultDate">Kamis, 12 Oktober 2024</span>
                            </div>
                        </div>
                        <div class="booking-detail-item">
                            <span class="material-symbols-outlined booking-detail-icon">schedule</span>
                            <div>
                                <span class="booking-detail-label">Waktu</span>
                                <span class="booking-detail-value" id="resultTime">09:00 WIB</span>
                            </div>
                        </div>
                    </div>
                    <div class="booking-detail-row">
                        <div class="booking-detail-item">
                            <span class="material-symbols-outlined booking-detail-icon">timer</span>
                            <div>
                                <span class="booking-detail-label">Durasi</span>
                                <span class="booking-detail-value" id="resultDuration">60 Menit</span>
                            </div>
                        </div>
                        <div class="booking-detail-item">
                            <span class="material-symbols-outlined booking-detail-icon">videocam</span>
                            <div>
                                <span class="booking-detail-label">Tipe</span>
                                <span class="booking-detail-value" id="resultType">Daring</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Schedule Selection -->
                <div class="booking-reschedule">
                    <h5 class="booking-reschedule__title">
                        <span class="material-symbols-outlined" style="font-size:1.2rem;">edit_calendar</span>
                        Pilih Jadwal Baru
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label for="newDate" class="filter-label">
                                <span class="material-symbols-outlined filter-label-icon">event</span>
                                Tanggal Baru
                            </label>
                            <div class="filter-input-wrap">
                                <input type="date" id="newDate" class="filter-input filter-input-date">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="newTime" class="filter-label">
                                <span class="material-symbols-outlined filter-label-icon">schedule</span>
                                Jam Baru
                            </label>
                            <div class="filter-input-wrap">
                                <select id="newTime" class="filter-input">
                                    <option value="">Pilih Jam</option>
                                    <option value="08:00">08:00 WIB</option>
                                    <option value="09:00">09:00 WIB</option>
                                    <option value="10:00">10:00 WIB</option>
                                    <option value="11:00">11:00 WIB</option>
                                    <option value="13:00">13:00 WIB</option>
                                    <option value="14:00">14:00 WIB</option>
                                    <option value="15:00">15:00 WIB</option>
                                    <option value="16:00">16:00 WIB</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="booking-confirm-btn" onclick="confirmReschedule()">
                        <span class="material-symbols-outlined" style="font-size:1.15rem;">check_circle</span>
                        Konfirmasi Perubahan Jadwal
                    </button>
                </div>
            </div>

            <!-- Success Card (hidden by default) -->
            <div class="booking-success-card mx-auto d-none" id="bookingSuccess">
                <div class="booking-success-icon-wrap">
                    <div class="booking-success-icon">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                </div>
                <h4 class="booking-card__title">Jadwal Berhasil Diubah!</h4>
                <p class="booking-card__desc">Jadwal booking Anda telah berhasil diperbarui. Detail perubahan telah dikirim ke email Anda.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                    <a href="<?= base_url('/ubah-jadwal') ?>" class="booking-outline-btn">
                        <span class="material-symbols-outlined" style="font-size:1.1rem;">edit_calendar</span>
                        Ubah Lagi
                    </a>
                    <a href="<?= base_url('/') ?>" class="booking-submit-btn" style="text-decoration:none;">
                        <span class="material-symbols-outlined" style="font-size:1.1rem;">home</span>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

        </div>
    </section>

    <script>
    // Simulated booking data
    const bookings = {
        'BK-2024-0812': {
            title: 'Konsultasi Strategis',
            date: 'Kamis, 12 Oktober 2024',
            time: '09:00 WIB',
            duration: '60 Menit',
            type: 'Daring',
        },
        'BK-2024-0915': {
            title: 'Audit Arsitektur',
            date: 'Senin, 15 Oktober 2024',
            time: '10:30 WIB',
            duration: '90 Menit',
            type: 'Tatap Muka',
        },
        'BK-2024-1001': {
            title: 'Sesi Roadmap Proyek',
            date: 'Rabu, 17 Oktober 2024',
            time: '13:00 WIB',
            duration: '45 Menit',
            type: 'Daring',
        }
    };

    function handleLookup(e) {
        e.preventDefault();
        const code = document.getElementById('inputBookingCode').value.trim().toUpperCase();
        const alertErr = document.getElementById('alertError');
        const btnLookup = document.getElementById('btnLookup');

        // Reset error
        alertErr.classList.add('d-none');

        // Animate button
        btnLookup.disabled = true;
        btnLookup.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mencari...';

        setTimeout(() => {
            btnLookup.disabled = false;
            btnLookup.innerHTML = '<span class="material-symbols-outlined" style="font-size:1.15rem;">search</span> Cari Booking';

            if (bookings[code]) {
                showResult(code, bookings[code]);
            } else {
                alertErr.classList.remove('d-none');
                // Shake animation
                alertErr.style.animation = 'none';
                alertErr.offsetHeight; // trigger reflow
                alertErr.style.animation = 'shakeX 0.5s ease';
            }
        }, 1200);

        return false;
    }

    function showResult(code, data) {
        document.getElementById('bookingLookup').classList.add('d-none');
        document.getElementById('bookingSuccess').classList.add('d-none');

        const result = document.getElementById('bookingResult');
        result.classList.remove('d-none');
        result.style.animation = 'none';
        result.offsetHeight;
        result.style.animation = 'slideUp 0.45s cubic-bezier(0.22, 1, 0.36, 1) both';

        document.getElementById('resultTitle').textContent = data.title;
        document.getElementById('resultCode').textContent = code;
        document.getElementById('resultDate').textContent = data.date;
        document.getElementById('resultTime').textContent = data.time;
        document.getElementById('resultDuration').textContent = data.duration;
        document.getElementById('resultType').textContent = data.type;
    }

    function showLookup() {
        document.getElementById('bookingResult').classList.add('d-none');
        document.getElementById('bookingSuccess').classList.add('d-none');

        const lookup = document.getElementById('bookingLookup');
        lookup.classList.remove('d-none');
        lookup.style.animation = 'none';
        lookup.offsetHeight;
        lookup.style.animation = 'slideUp 0.45s cubic-bezier(0.22, 1, 0.36, 1) both';
    }

    function confirmReschedule() {
        const newDate = document.getElementById('newDate').value;
        const newTime = document.getElementById('newTime').value;

        if (!newDate || !newTime) {
            alert('Silakan pilih tanggal dan jam baru terlebih dahulu.');
            return;
        }

        document.getElementById('bookingResult').classList.add('d-none');

        const success = document.getElementById('bookingSuccess');
        success.classList.remove('d-none');
        success.style.animation = 'none';
        success.offsetHeight;
        success.style.animation = 'slideUp 0.45s cubic-bezier(0.22, 1, 0.36, 1) both';
    }
    </script>

<?= $this->endSection() ?>
