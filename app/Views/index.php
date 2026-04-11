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
                <p class="schedule-subheading mt-3">Gunakan filter di bawah untuk mencari jadwal yang paling sesuai dengan kebutuhan Anda</p>
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

            <!-- Results Header -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h3 class="results-title mb-1">Jadwal Tersedia</h3>
                    <p class="results-subtitle mb-0">
                        <span class="material-symbols-outlined" style="font-size:.95rem;vertical-align:-3px;">today</span>
                        Kamis, 12 Oktober 2024
                    </p>
                </div>
                <div class="results-count">
                    <span class="results-count-number">4</span>
                    <span>Jadwal ditemukan</span>
                </div>
            </div>

            <!-- Schedule Cards -->
            <div class="schedule-list">
                <!-- Slot 1 — Available -->
                <div class="schedule-card schedule-card--available" tabindex="0">
                    <div class="schedule-card__left">
                        <div class="schedule-card__time">
                            <span class="schedule-card__hour">09:00</span>
                            <span class="schedule-card__period">WIB</span>
                        </div>
                        <div class="schedule-card__divider"></div>
                        <div class="schedule-card__info">
                            <div class="schedule-card__name">Konsultasi Strategis</div>
                            <div class="schedule-card__detail">
                                <span class="material-symbols-outlined" style="font-size:.875rem;">timer</span>
                                60 Menit
                                <span class="schedule-card__dot"></span>
                                <span class="material-symbols-outlined" style="font-size:.875rem;">videocam</span>
                                Daring
                            </div>
                        </div>
                    </div>
                    <div class="schedule-card__right">
                        <span class="status-pill status-pill--available">Tersedia</span>
                        <span class="material-symbols-outlined schedule-card__arrow">arrow_forward</span>
                    </div>
                </div>

                <!-- Slot 2 — Booked -->
                <div class="schedule-card schedule-card--booked">
                    <div class="schedule-card__left">
                        <div class="schedule-card__time">
                            <span class="schedule-card__hour">10:30</span>
                            <span class="schedule-card__period">WIB</span>
                        </div>
                        <div class="schedule-card__divider"></div>
                        <div class="schedule-card__info">
                            <div class="schedule-card__name">Audit Arsitektur</div>
                            <div class="schedule-card__detail">
                                <span class="material-symbols-outlined" style="font-size:.875rem;">timer</span>
                                90 Menit
                                <span class="schedule-card__dot"></span>
                                <span class="material-symbols-outlined" style="font-size:.875rem;">groups</span>
                                Tatap Muka
                            </div>
                        </div>
                    </div>
                    <div class="schedule-card__right">
                        <span class="status-pill status-pill--booked">Terisi</span>
                    </div>
                </div>

                <!-- Slot 3 — Available -->
                <div class="schedule-card schedule-card--available" tabindex="0">
                    <div class="schedule-card__left">
                        <div class="schedule-card__time">
                            <span class="schedule-card__hour">13:00</span>
                            <span class="schedule-card__period">WIB</span>
                        </div>
                        <div class="schedule-card__divider"></div>
                        <div class="schedule-card__info">
                            <div class="schedule-card__name">Sesi Roadmap Proyek</div>
                            <div class="schedule-card__detail">
                                <span class="material-symbols-outlined" style="font-size:.875rem;">timer</span>
                                45 Menit
                                <span class="schedule-card__dot"></span>
                                <span class="material-symbols-outlined" style="font-size:.875rem;">videocam</span>
                                Daring
                            </div>
                        </div>
                    </div>
                    <div class="schedule-card__right">
                        <span class="status-pill status-pill--available">Tersedia</span>
                        <span class="material-symbols-outlined schedule-card__arrow">arrow_forward</span>
                    </div>
                </div>

                <!-- Slot 4 — Available -->
                <div class="schedule-card schedule-card--available" tabindex="0">
                    <div class="schedule-card__left">
                        <div class="schedule-card__time">
                            <span class="schedule-card__hour">14:30</span>
                            <span class="schedule-card__period">WIB</span>
                        </div>
                        <div class="schedule-card__divider"></div>
                        <div class="schedule-card__info">
                            <div class="schedule-card__name">Review Dokumen</div>
                            <div class="schedule-card__detail">
                                <span class="material-symbols-outlined" style="font-size:.875rem;">timer</span>
                                30 Menit
                                <span class="schedule-card__dot"></span>
                                <span class="material-symbols-outlined" style="font-size:.875rem;">videocam</span>
                                Daring
                            </div>
                        </div>
                    </div>
                    <div class="schedule-card__right">
                        <span class="status-pill status-pill--available">Tersedia</span>
                        <span class="material-symbols-outlined schedule-card__arrow">arrow_forward</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
    (function() {
        const MONTH_NAMES = [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];
        const DAY_NAMES = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

        // Simulated availability data (dates with available slots)
        // In production, replace with real data from the server
        const availableDates = new Set([
            '2024-10-01','2024-10-03','2024-10-07','2024-10-08','2024-10-10',
            '2024-10-12','2024-10-14','2024-10-15','2024-10-17','2024-10-21',
            '2024-10-22','2024-10-24','2024-10-28','2024-10-29','2024-10-31'
        ]);
        const fullDates = new Set([
            '2024-10-02','2024-10-09','2024-10-16','2024-10-23','2024-10-30'
        ]);

        let currentYear = 2024;
        let currentMonth = 9; // 0-indexed (9 = Oktober)
        let selectedDate = null;

        const calDates   = document.getElementById('calDates');
        const calLabel   = document.getElementById('calMonthLabel');
        const btnPrev    = document.getElementById('calPrev');
        const btnNext    = document.getElementById('calNext');
        const dateInput  = document.getElementById('filterTanggal');

        const today = new Date();
        const todayStr = `${today.getFullYear()}-${String(today.getMonth()+1).padStart(2,'0')}-${String(today.getDate()).padStart(2,'0')}`;

        function pad(n) { return String(n).padStart(2, '0'); }

        function dateStr(y, m, d) {
            return `${y}-${pad(m+1)}-${pad(d)}`;
        }

        function render() {
            calLabel.textContent = `${MONTH_NAMES[currentMonth]} ${currentYear}`;

            // First day of month (0=Sun … 6=Sat), convert to Mon-start (0=Mon … 6=Sun)
            let firstDay = new Date(currentYear, currentMonth, 1).getDay();
            firstDay = (firstDay + 6) % 7; // shift so Monday = 0

            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            let html = '';

            // Empty cells before first day
            for (let i = 0; i < firstDay; i++) {
                html += '<span class="cal-cell cal-cell--empty"></span>';
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const ds = dateStr(currentYear, currentMonth, d);
                const isToday    = ds === todayStr;
                const isSelected = ds === selectedDate;
                const hasSlots   = availableDates.has(ds);
                const isFull     = fullDates.has(ds);

                let cls = 'cal-cell';
                if (isToday)    cls += ' cal-cell--today';
                if (isSelected) cls += ' cal-cell--selected';

                let dot = '';
                if (hasSlots) dot = '<span class="cal-dot cal-dot--available"></span>';
                else if (isFull) dot = '<span class="cal-dot cal-dot--full"></span>';

                html += `<span class="${cls}" data-date="${ds}" role="button" tabindex="0">
                            <span class="cal-cell__num">${d}</span>
                            ${dot}
                         </span>`;
            }

            calDates.innerHTML = html;

            // Attach click handlers
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

            // Update date input
            if (dateInput) dateInput.value = ds;

            // Update results subtitle
            const parts = ds.split('-');
            const dt = new Date(+parts[0], +parts[1]-1, +parts[2]);
            const sub = document.querySelector('.results-subtitle');
            if (sub) {
                sub.innerHTML = `<span class="material-symbols-outlined" style="font-size:.95rem;vertical-align:-3px;">today</span> ${DAY_NAMES[dt.getDay()]}, ${dt.getDate()} ${MONTH_NAMES[dt.getMonth()]} ${dt.getFullYear()}`;
            }

            render();
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