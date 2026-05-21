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

        <!-- Jenis Sewa Selector -->
        <div class="sewa-selector mx-auto mb-5">
            <label class="filter-label" style="margin-bottom:.75rem;">
                <span class="material-symbols-outlined filter-label-icon">category</span>
                Pilih Jenis Sewa
            </label>
            <div class="sewa-pills">
                <button type="button" class="sewa-pill sewa-pill--active" data-sewa="per-jam"
                    onclick="setSewa('per-jam')">
                    <span class="material-symbols-outlined">schedule</span>
                    <div>
                        <span class="sewa-pill__title">Per Jam</span>
                        <span class="sewa-pill__desc">Sewa lapangan per jam</span>
                    </div>
                </button>
                <button type="button" class="sewa-pill" data-sewa="per-hari" onclick="setSewa('per-hari')">
                    <span class="material-symbols-outlined">today</span>
                    <div>
                        <span class="sewa-pill__title">Per Hari</span>
                        <span class="sewa-pill__desc">Sewa full 1 hari</span>
                    </div>
                </button>
                <button type="button" class="sewa-pill" data-sewa="membership" onclick="setSewa('membership')">
                    <span class="material-symbols-outlined">card_membership</span>
                    <div>
                        <span class="sewa-pill__title">Membership</span>
                        <span class="sewa-pill__desc">Diskon 10%, 1 bulan</span>
                    </div>
                </button>
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
                    <span class="cal-legend-dot cal-legend-dot--partial"></span>
                    <span>Sebagian Terisi</span>
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

        <!-- Lapang Cards (hidden until date selected) — rendered dynamically -->
        <div id="lapangSection" style="display:none;">
            <!-- Results Header -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h3 class="results-title mb-1">Jadwal Tersedia</h3>
                    <p class="results-subtitle mb-0" id="lapangDateLabel">
                        <span class="material-symbols-outlined"
                            style="font-size:.95rem;vertical-align:-3px;">today</span>
                        Pilih tanggal di kalender
                    </p>
                </div>
                <div class="results-count" id="slotSummary" style="display:none;">
                    <span class="material-symbols-outlined" style="font-size:1rem;">check_circle</span>
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

            <!-- Empty state (if no lapang) -->
            <div id="lapangEmpty" class="text-center py-5" style="display:none;">
                <span class="material-symbols-outlined" style="font-size:3rem; color:var(--outline);">event_busy</span>
                <p class="mt-2" style="font-size:.9rem; color:var(--on-surface-variant); font-weight:500;">Tidak ada
                    lapangan tersedia saat ini.</p>
            </div>
        </div>

    </div>
</section>

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
                <!--     -->
            </div>
        </div>
    </div>
</div>

<!-- Timeslot Past Style -->
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
</style>

<script>
    (function () {
        // ─── Constants ───
        const MONTH_NAMES = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        const DAY_NAMES = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // ─── API URLs (relative to avoid baseURL mismatch) ───
        const API_LAPANGS = '/api/getLapangs';
        const API_BOOKED = '/api/getBookedSlots';
        const API_MONTH = '/api/getMonthBookings';
        const BOOKING_BASE = '/booking';

        // ─── State ───
        const today = new Date();
        let currentYear = today.getFullYear();
        let currentMonth = today.getMonth();
        let selectedDate = null;
        let sewaMode = 'per-jam'; // 'per-jam' | 'per-hari' | 'membership'
        let lapangsData = [];
        let bookedSlotsData = {};
        let monthBookingsData = {};

        // ─── DOM refs ───
        const calDates = document.getElementById('calDates');
        const calLabel = document.getElementById('calMonthLabel');
        const btnPrev = document.getElementById('calPrev');
        const btnNext = document.getElementById('calNext');
        const lapangSection = document.getElementById('lapangSection');
        const lapangDateLabel = document.getElementById('lapangDateLabel');
        const lapangCards = document.getElementById('lapangCards');
        const lapangLoading = document.getElementById('lapangLoading');
        const lapangEmpty = document.getElementById('lapangEmpty');
        const slotSummary = document.getElementById('slotSummary');
        const slotSummaryText = document.getElementById('slotSummaryText');

        // ─── Sewa Mode Switcher ───
        window.setSewa = function (mode) {
            sewaMode = mode;
            document.querySelectorAll('.sewa-pill').forEach(p => {
                p.classList.toggle('sewa-pill--active', p.dataset.sewa === mode);
            });
            if (mode === 'membership') {
                new bootstrap.Modal(document.getElementById('membershipModal')).show();
            }
            selectedDate = null;
            lapangSection.style.display = 'none';
            render();
        };

        const todayStr = `${today.getFullYear()}-${pad(today.getMonth() + 1)}-${pad(today.getDate())}`;

        // ─── Helpers ───
        function pad(n) { return String(n).padStart(2, '0'); }
        function dateStr(y, m, d) { return `${y}-${pad(m + 1)}-${pad(d)}`; }

        /**
         * Checks if a given hour slot is in the past (for today only).
         */
        function isPastSlot(ds, hour) {
            if (ds !== todayStr) return false;
            return hour <= today.getHours();
        }

        /**
         * Get the operating hours of a lapang based on the selected date.
         */
        function getOperatingHours(lapang, ds) {
            const dt = new Date(ds);
            const dow = dt.getDay(); // 0=Sunday, 6=Saturday
            const isWeekend = (dow === 0 || dow === 6);

            const jamBuka = parseInt(isWeekend ? lapang.jam_buka_weekend : lapang.jam_buka_weekday) || 0;
            let jamTutup = parseInt(isWeekend ? lapang.jam_tutup_weekend : lapang.jam_tutup_weekday) || 0;

            // Jika jam tutup = 0 (00:00 = tengah malam), artinya tutup jam 24
            if (jamTutup <= jamBuka) jamTutup = 24;

            return { jamBuka, jamTutup, isWeekend };
        }

        // ─── API Fetch Functions ───

        async function fetchLapangs() {
            try {
                const res = await fetch(API_LAPANGS);
                lapangsData = await res.json();
            } catch (err) {
                console.error('Failed to fetch lapangs:', err);
                lapangsData = [];
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

        // ─── Render Lapang Cards Dynamically ───

        function renderLapangCards() {
            const filteredLapangs = lapangsData;

            if (filteredLapangs.length === 0) {
                lapangCards.innerHTML = '';
                lapangEmpty.style.display = 'block';
                slotSummary.style.display = 'none';
                return;
            }

            lapangEmpty.style.display = 'none';
            let html = '';
            let totalAvailable = 0;
            let totalBooked = 0;

            filteredLapangs.forEach((lapang, idx) => {
                const { jamBuka, jamTutup, isWeekend } = getOperatingHours(lapang, selectedDate);
                const bookedSlots = bookedSlotsData[lapang.id_lapang] || [];

                let slotsHtml = '';
                let availCount = 0;
                let bookedCount = 0;

                for (let h = jamBuka; h < jamTutup; h++) {
                    const slotKey = pad(h) + ':00'; // format API (untuk pencocokan)
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
                        badge = '<span class="timeslot-badge timeslot-badge--lewat">Lewat</span>';
                    } else {
                        boxClass += ' timeslot-box--available';
                        availCount++;
                        badge = '<span class="timeslot-badge timeslot-badge--kosong">Kosong</span>';
                    }

                    slotsHtml += `<div class="${boxClass}" data-slot="${start}-${end}" data-label="${label}" ${canClick ? 'tabindex="0"' : ''} style="animation-delay:${0.03 * (h - jamBuka)}s">
                        <span class="material-symbols-outlined timeslot-box__icon">${icon}</span>
                        <span class="timeslot-box__label">${label}</span>
                        ${badge}
                    </div>`;
                }

                totalAvailable += availCount;
                totalBooked += bookedCount;

                const jamLabel = isWeekend ? 'Weekend' : 'Weekday';

                html += `<div class="col-12 col-md-4" style="animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both; animation-delay: ${0.1 * (idx + 1)}s;">
                    <div class="lapang-card">
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
                                ${bookedCount} terisi
                            </span>
                        </div>
                        <div class="lapang-card__body">
                            <div class="timeslot-grid" id="timeslots-lapang-${lapang.id_lapang}">${slotsHtml}</div>
                            <div class="lapang-booking-btn-wrap" id="bookingBtn-lapang-${lapang.id_lapang}" style="display:none;">
                                <a href="#" class="lapang-booking-btn" id="bookingLink-lapang-${lapang.id_lapang}">
                                    <span class="material-symbols-outlined" style="font-size:1.1rem;">event_available</span>
                                    Booking Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>`;
            });

            lapangCards.innerHTML = html;

            // Show summary
            slotSummary.style.display = 'flex';
            slotSummaryText.textContent = `${totalAvailable} slot tersedia · ${totalBooked} terisi`;

            // Attach click handlers to available timeslots
            attachSlotHandlers();
        }

        /**
         * Attach click/keyboard handlers to available timeslot boxes.
         */
        function attachSlotHandlers() {
            lapangsData.forEach(lapang => {
                const grid = document.getElementById(`timeslots-lapang-${lapang.id_lapang}`);
                if (!grid) return;

                const btnWrap = document.getElementById(`bookingBtn-lapang-${lapang.id_lapang}`);
                const btnLink = document.getElementById(`bookingLink-lapang-${lapang.id_lapang}`);

                grid.querySelectorAll('.timeslot-box--available').forEach(box => {
                    function handleSelect() {
                        // Deselect all in THIS grid
                        grid.querySelectorAll('.timeslot-box--selected').forEach(sel => {
                            if (sel !== box) sel.classList.remove('timeslot-box--selected');
                        });
                        box.classList.toggle('timeslot-box--selected');

                        const selected = grid.querySelector('.timeslot-box--selected');
                        if (selected) {
                            const jam = selected.getAttribute('data-label');
                            const url = `${BOOKING_BASE}?lapang=${encodeURIComponent(lapang.nama_lapangan)}&tanggal=${selectedDate}&jam=${encodeURIComponent(jam)}&sewa=${encodeURIComponent(sewaMode)}`;
                            btnLink.href = url;
                            btnWrap.style.display = 'block';
                            btnWrap.style.animation = 'slideUp 0.35s cubic-bezier(0.22, 1, 0.36, 1) both';
                        } else {
                            btnWrap.style.display = 'none';
                        }
                    }

                    box.addEventListener('click', handleSelect);
                    box.addEventListener('keydown', e => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            handleSelect();
                        }
                    });
                });
            });
        }

        // ─── Show Lapang Cards Section ───

        async function showLapangCards(ds) {
            // Update date label
            const parts = ds.split('-');
            const dt = new Date(+parts[0], +parts[1] - 1, +parts[2]);
            lapangDateLabel.innerHTML = `<span class="material-symbols-outlined" style="font-size:.95rem;vertical-align:-3px;">today</span> ${DAY_NAMES[dt.getDay()]}, ${dt.getDate()} ${MONTH_NAMES[dt.getMonth()]} ${dt.getFullYear()}`;

            // Show section + loading
            lapangSection.style.display = 'block';
            lapangLoading.style.display = 'block';
            lapangCards.innerHTML = '';
            lapangEmpty.style.display = 'none';
            slotSummary.style.display = 'none';

            // Fetch data in parallel
            await Promise.all([
                lapangsData.length === 0 ? fetchLapangs() : Promise.resolve(),
                fetchBookedSlots(ds)
            ]);

            // Hide loading
            lapangLoading.style.display = 'none';

            // Per Hari mode: show full-day available lapangan
            if (sewaMode === 'per-hari') {
                renderDailyCards(ds, dt);
            } else {
                renderLapangCards();
            }

            // Smooth scroll
            setTimeout(() => {
                lapangSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }

        // ─── Per Hari: Render Full-Day Available Lapangan ───
        function renderDailyCards(ds, dt) {
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
                const headerBg = isFullyAvailable
                    ? 'background:linear-gradient(135deg,#059669,#10b981);'
                    : 'background:linear-gradient(135deg,#d97706,#f59e0b);';

                html += `<div class="col-12 col-md-6 col-lg-4" style="animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both; animation-delay: ${0.1 * (idx + 1)}s;">
                    <div class="daily-card">
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
                            ${isFullyAvailable ? `<a href="${BOOKING_BASE}?lapang=${encodeURIComponent(lapang.nama_lapangan)}&tanggal=${ds}&sewa=per-hari" class="daily-card__btn">
                                <span class="material-symbols-outlined" style="font-size:1.1rem;">event_available</span>
                                Booking Full Day
                            </a>` : `<span style="font-size:.75rem;color:#94a3b8;">Tidak tersedia untuk sewa per hari</span>`}
                        </div>
                    </div>
                </div>`;

                if (isFullyAvailable) availableLapangs++;
            });

            if (lapangsData.length === 0) {
                lapangEmpty.style.display = 'block';
            } else {
                lapangEmpty.style.display = 'none';
                lapangCards.innerHTML = html;
                slotSummary.style.display = 'flex';
                slotSummaryText.textContent = `${availableLapangs} lapangan tersedia full day`;
            }
        }

        // ─── Calendar Rendering ───

        /**
         * Calculate total available slots for a given date across all lapangan.
         */
        function getTotalSlotsForDate(ds) {
            if (lapangsData.length === 0) return 0;
            let total = 0;
            lapangsData.forEach(lapang => {
                const { jamBuka, jamTutup } = getOperatingHours(lapang, ds);
                total += Math.max(0, jamTutup - jamBuka);
            });
            return total;
        }

        /**
         * Fetch monthly booking counts for the current calendar month.
         */
        async function fetchMonthBookings() {
            try {
                const res = await fetch(`${API_MONTH}?year=${currentYear}&month=${currentMonth + 1}`);
                monthBookingsData = await res.json();
            } catch (err) {
                console.error('Failed to fetch month bookings:', err);
                monthBookingsData = {};
            }
        }

        async function render() {
            calLabel.textContent = `${MONTH_NAMES[currentMonth]} ${currentYear}`;

            // Ensure lapangs data is loaded for slot calculation
            if (lapangsData.length === 0) await fetchLapangs();

            // Fetch monthly bookings
            await fetchMonthBookings();

            let firstDay = new Date(currentYear, currentMonth, 1).getDay();
            firstDay = (firstDay + 6) % 7; // Adjust so Monday = 0

            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            let html = '';

            // Empty cells before first day
            for (let i = 0; i < firstDay; i++) {
                html += '<span class="cal-cell cal-cell--empty"></span>';
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const ds = dateStr(currentYear, currentMonth, d);
                const isToday = ds === todayStr;
                const isSelected = ds === selectedDate;
                const isPastDate = ds < todayStr;

                // Calculate availability
                const totalSlots = getTotalSlotsForDate(ds);
                const bookedSlots = monthBookingsData[ds] || 0;
                const availableSlots = totalSlots - bookedSlots;

                let cls = 'cal-cell';
                if (isToday) cls += ' cal-cell--today';
                if (isSelected) cls += ' cal-cell--selected';
                if (isPastDate) cls += ' cal-cell--past';

                // Availability dot
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

            // Attach event listeners
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

        function selectDate(ds) {
            selectedDate = ds;
            render();
            showLapangCards(ds);
        }

        // Calendar navigation
        btnPrev.addEventListener('click', async () => {
            currentMonth--;
            if (currentMonth < 0) { currentMonth = 11; currentYear--; }
            await render();
        });

        btnNext.addEventListener('click', async () => {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            await render();
        });

        // ─── Initial render ───
        render();

        // Pre-fetch lapangs data on page load
        fetchLapangs();
    })();
</script>

<!-- Past date styling for calendar -->
<style>
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
        max-width: 720px;
    }

    .sewa-pills {
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
    }

    .sewa-pill {
        flex: 1;
        min-width: 160px;
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .85rem 1rem;
        border-radius: .85rem;
        border: 2px solid var(--outline-variant);
        background: var(--surface-container-lowest);
        cursor: pointer;
        transition: all .2s ease;
        text-align: left;
    }

    .sewa-pill .material-symbols-outlined {
        font-size: 1.5rem;
        color: var(--on-surface-variant);
        background: var(--surface-container);
        border-radius: .6rem;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all .2s;
    }

    .sewa-pill__title {
        display: block;
        font-family: 'Public Sans', sans-serif;
        font-size: .85rem;
        font-weight: 700;
        color: var(--on-surface);
    }

    .sewa-pill__desc {
        display: block;
        font-size: .68rem;
        color: var(--on-surface-variant);
        margin-top: .1rem;
    }

    .sewa-pill:hover {
        border-color: var(--primary);
        background: var(--primary-fixed);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px -4px rgba(0, 87, 205, .15);
    }

    .sewa-pill:hover .material-symbols-outlined {
        color: var(--primary);
    }

    .sewa-pill--active {
        border-color: var(--primary);
        background: var(--primary-fixed);
        box-shadow: 0 4px 16px -4px rgba(0, 87, 205, .2);
    }

    .sewa-pill--active .material-symbols-outlined {
        background: var(--primary);
        color: #fff;
    }

    /* Per Hari: full day available card */
    .daily-card {
        background: var(--surface-container-lowest);
        border: 1px solid var(--outline-variant);
        border-radius: 1rem;
        overflow: hidden;
        transition: all .2s;
    }

    .daily-card:hover {
        box-shadow: 0 4px 16px -4px rgba(0, 0, 0, .1);
    }

    .daily-card__header {
        background: linear-gradient(135deg, #059669, #10b981);
        padding: .85rem 1.15rem;
        display: flex;
        align-items: center;
        gap: .75rem;
        color: #fff;
    }

    .daily-card__header .material-symbols-outlined {
        font-size: 1.5rem;
        opacity: .85;
    }

    .daily-card__title {
        font-family: 'Public Sans', sans-serif;
        font-size: .95rem;
        font-weight: 700;
    }

    .daily-card__subtitle {
        font-size: .68rem;
        opacity: .8;
        margin-top: .1rem;
    }

    .daily-card__body {
        padding: 1rem 1.15rem;
    }

    .daily-card__info {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .82rem;
        color: var(--on-surface-variant);
        margin-bottom: .5rem;
    }

    .daily-card__info .material-symbols-outlined {
        font-size: 1rem;
        color: var(--primary);
    }

    .daily-card__btn {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .55rem 1.25rem;
        border-radius: .65rem;
        font-size: .82rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        background: linear-gradient(135deg, #059669, #10b981);
        color: #fff;
        text-decoration: none;
        margin-top: .5rem;
        transition: all .18s;
    }

    .daily-card__btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px -4px rgba(5, 150, 105, .35);
        color: #fff;
    }
</style>

<?= $this->endSection() ?>