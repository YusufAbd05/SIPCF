<?= $this->extend('template/landing/base') ?>
<?= $this->section('title') ?>Jadwal Tersedia<?= $this->endSection() ?>
<?= $this->section('content') ?>

<!-- ================= JADWAL TERSEDIA ================= -->
<section class="schedule-section">
    <div class="container">

        <!-- Section Header -->
        <div class="text-center mb-5">
            <div class="section-chip mx-auto mb-3">
                <span class="material-symbols-outlined" style="font-size:1rem;">calendar_month</span>
                Jadwal Layanan
            </div>
            <h2 class="schedule-heading">Temukan Jadwal<br class="d-none d-md-block"> yang Tersedia</h2>
            <p class="schedule-subheading mt-3">Gunakan filter di bawah untuk mencari jadwal yang paling sesuai dengan
                kebutuhan Anda</p>
        </div>

        <!-- Filter Card -->
        <div class="filter-card mx-auto mb-5">
            <div class="row g-3 align-items-end">
                <!-- Filter Jam Bermain -->
                <div class="col-12 col-md-4">
                    <label for="filterJam" class="filter-label">
                        <span class="material-symbols-outlined filter-label-icon">schedule</span>
                        Jam Bermain
                    </label>
                    <div class="filter-input-wrap">
                        <select id="filterJam" class="filter-input">
                            <option value="">Semua Jam</option>
                            <option value="06:00-09:00">06:00 – 09:00 (Pagi)</option>
                            <option value="09:00-12:00">09:00 – 12:00 (Siang)</option>
                            <option value="12:00-15:00">12:00 – 15:00 (Siang)</option>
                            <option value="15:00-18:00">15:00 – 18:00 (Sore)</option>
                            <option value="18:00-21:00">18:00 – 21:00 (Malam)</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Hari -->
                <div class="col-12 col-md-4">
                    <label for="filterHari" class="filter-label">
                        <span class="material-symbols-outlined filter-label-icon">calendar_view_week</span>
                        Hari
                    </label>
                    <div class="filter-input-wrap">
                        <select id="filterHari" class="filter-input">
                            <option value="">Semua Hari</option>
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jumat</option>
                            <option value="sabtu">Sabtu</option>
                            <option value="minggu">Minggu</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Tanggal -->
                <div class="col-12 col-md-4">
                    <label for="filterTanggal" class="filter-label">
                        <span class="material-symbols-outlined filter-label-icon">event</span>
                        Tanggal
                    </label>
                    <div class="filter-input-wrap">
                        <input type="date" id="filterTanggal" class="filter-input filter-input-date">
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="cal-card mx-auto mb-5">
            <!-- Calendar Header -->
            <div class="cal-header">
                <button type="button" class="cal-nav-btn" id="calPrev" aria-label="Bulan sebelumnya">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <span class="cal-month-label" id="calMonthLabel">Oktober 2024</span>
                <button type="button" class="cal-nav-btn" id="calNext" aria-label="Bulan berikutnya">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>

            <!-- Day-of-week labels -->
            <div class="cal-grid cal-dow">
                <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
            </div>

            <!-- Date cells (rendered by JS) -->
            <div class="cal-grid cal-dates" id="calDates"></div>

            <!-- Legend -->
            <div class="cal-legend">
                <div class="cal-legend-item">
                    <span class="cal-legend-dot cal-legend-dot--available"></span>
                    <span>Tersedia</span>
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

        <!-- Lapang Cards (hidden until date selected) -->
        <div id="lapangSection" style="display:none;">
            <!-- Results Header -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h3 class="results-title mb-1">Jadwal Tersedia</h3>
                    <p class="results-subtitle mb-0" id="lapangDateLabel">
                        <span class="material-symbols-outlined" style="font-size:.95rem;vertical-align:-3px;">today</span>
                        Pilih tanggal di kalender
                    </p>
                </div>
            </div>

            <!-- 3 Lapang Cards -->
            <div class="row g-4" id="lapangCards">
                <!-- Lapang 1 -->
                <div class="col-12 col-md-4">
                    <div class="lapang-card">
                        <div class="lapang-card__header">
                            <span class="material-symbols-outlined lapang-card__icon">stadium</span>
                            <span class="lapang-card__title">Lapang 1</span>
                        </div>
                        <div class="lapang-card__body">
                            <div class="timeslot-grid" id="timeslots-lapang-1"></div>
                            <div class="lapang-booking-btn-wrap" id="bookingBtn-lapang-1" style="display:none;">
                                <a href="#" class="lapang-booking-btn" id="bookingLink-lapang-1">
                                    <span class="material-symbols-outlined" style="font-size:1.1rem;">event_available</span>
                                    Booking Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Lapang 2 -->
                <div class="col-12 col-md-4">
                    <div class="lapang-card">
                        <div class="lapang-card__header">
                            <span class="material-symbols-outlined lapang-card__icon">stadium</span>
                            <span class="lapang-card__title">Lapang 2</span>
                        </div>
                        <div class="lapang-card__body">
                            <div class="timeslot-grid" id="timeslots-lapang-2"></div>
                            <div class="lapang-booking-btn-wrap" id="bookingBtn-lapang-2" style="display:none;">
                                <a href="#" class="lapang-booking-btn" id="bookingLink-lapang-2">
                                    <span class="material-symbols-outlined" style="font-size:1.1rem;">event_available</span>
                                    Booking Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Lapang 3 -->
                <div class="col-12 col-md-4">
                    <div class="lapang-card">
                        <div class="lapang-card__header">
                            <span class="material-symbols-outlined lapang-card__icon">stadium</span>
                            <span class="lapang-card__title">Lapang 3</span>
                        </div>
                        <div class="lapang-card__body">
                            <div class="timeslot-grid" id="timeslots-lapang-3"></div>
                            <div class="lapang-booking-btn-wrap" id="bookingBtn-lapang-3" style="display:none;">
                                <a href="#" class="lapang-booking-btn" id="bookingLink-lapang-3">
                                    <span class="material-symbols-outlined" style="font-size:1.1rem;">event_available</span>
                                    Booking Sekarang
                                </a>
                            </div>
                        </div>
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

        // Time slots from 08:00 to 24:00
        const TIME_SLOTS = [];
        for (let h = 8; h < 24; h++) {
            const start = String(h).padStart(2, '0') + ':00';
            const end = String(h + 1).padStart(2, '0') + ':00';
            TIME_SLOTS.push({ start, end, label: `${start} - ${end}` });
        }

        const today = new Date();
        let currentYear = today.getFullYear();
        let currentMonth = today.getMonth();
        let selectedDate = null;

        const calDates = document.getElementById('calDates');
        const calLabel = document.getElementById('calMonthLabel');
        const btnPrev = document.getElementById('calPrev');
        const btnNext = document.getElementById('calNext');
        const dateInput = document.getElementById('filterTanggal');
        const lapangSection = document.getElementById('lapangSection');
        const lapangDateLabel = document.getElementById('lapangDateLabel');

        const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

        function pad(n) { return String(n).padStart(2, '0'); }

        function dateStr(y, m, d) {
            return `${y}-${pad(m + 1)}-${pad(d)}`;
        }

        // Base URL for booking
        const BOOKING_BASE = '<?= base_url("/booking") ?>';

        // Generate timeslot boxes for a given lapang grid element
        function renderTimeslots(gridEl, lapangNum) {
            let html = '';
            TIME_SLOTS.forEach((slot, idx) => {
                html += `<div class="timeslot-box timeslot-box--available" data-slot="${slot.start}-${slot.end}" data-label="${slot.label}" tabindex="0" style="animation-delay:${0.03 * idx}s">
                            <span class="material-symbols-outlined timeslot-box__icon">schedule</span>
                            <span class="timeslot-box__label">${slot.label}</span>
                         </div>`;
            });
            gridEl.innerHTML = html;

            const btnWrap = document.getElementById(`bookingBtn-lapang-${lapangNum}`);
            const btnLink = document.getElementById(`bookingLink-lapang-${lapangNum}`);

            // Click to toggle selection & show/hide booking button
            gridEl.querySelectorAll('.timeslot-box').forEach(box => {
                box.addEventListener('click', () => {
                    // Deselect all other boxes in THIS lapang (single selection per card)
                    gridEl.querySelectorAll('.timeslot-box--selected').forEach(sel => {
                        if (sel !== box) sel.classList.remove('timeslot-box--selected');
                    });
                    box.classList.toggle('timeslot-box--selected');

                    // Check if any slot is selected
                    const selected = gridEl.querySelector('.timeslot-box--selected');
                    if (selected) {
                        const jam = selected.getAttribute('data-label');
                        const url = `${BOOKING_BASE}?lapang=Lapang ${lapangNum}&tanggal=${selectedDate}&jam=${encodeURIComponent(jam)}`;
                        btnLink.href = url;
                        btnWrap.style.display = 'block';
                        btnWrap.style.animation = 'slideUp 0.35s cubic-bezier(0.22, 1, 0.36, 1) both';
                    } else {
                        btnWrap.style.display = 'none';
                    }
                });
            });
        }

        // Show Lapang cards section with timeslots
        function showLapangCards(ds) {
            // Update date label
            const parts = ds.split('-');
            const dt = new Date(+parts[0], +parts[1] - 1, +parts[2]);
            lapangDateLabel.innerHTML = `<span class="material-symbols-outlined" style="font-size:.95rem;vertical-align:-3px;">today</span> ${DAY_NAMES[dt.getDay()]}, ${dt.getDate()} ${MONTH_NAMES[dt.getMonth()]} ${dt.getFullYear()}`;

            // Render timeslots for each lapang
            for (let i = 1; i <= 3; i++) {
                const grid = document.getElementById(`timeslots-lapang-${i}`);
                if (grid) renderTimeslots(grid, i);
            }

            // Show section with animation
            lapangSection.style.display = 'block';
            lapangSection.style.animation = 'slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both';

            // Smooth scroll to Lapang cards
            setTimeout(() => {
                lapangSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }

        function render() {
            calLabel.textContent = `${MONTH_NAMES[currentMonth]} ${currentYear}`;

            let firstDay = new Date(currentYear, currentMonth, 1).getDay();
            firstDay = (firstDay + 6) % 7;

            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            let html = '';

            for (let i = 0; i < firstDay; i++) {
                html += '<span class="cal-cell cal-cell--empty"></span>';
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const ds = dateStr(currentYear, currentMonth, d);
                const isToday = ds === todayStr;
                const isSelected = ds === selectedDate;

                let cls = 'cal-cell';
                if (isToday) cls += ' cal-cell--today';
                if (isSelected) cls += ' cal-cell--selected';

                html += `<span class="${cls}" data-date="${ds}" role="button" tabindex="0">
                            <span class="cal-cell__num">${d}</span>
                         </span>`;
            }

            calDates.innerHTML = html;

            calDates.querySelectorAll('.cal-cell:not(.cal-cell--empty)').forEach(cell => {
                cell.addEventListener('click', () => selectDate(cell.dataset.date));
                cell.addEventListener('keydown', e => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        selectDate(cell.dataset.date);
                    }
                });
            });
        }

        function selectDate(ds) {
            selectedDate = ds;
            if (dateInput) dateInput.value = ds;
            render();
            showLapangCards(ds);
        }

        btnPrev.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) { currentMonth = 11; currentYear--; }
            render();
        });

        btnNext.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            render();
        });

        // Initial render
        render();
    })();
</script>

<?= $this->endSection() ?>