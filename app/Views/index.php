<?= $this->extend('template/landing/base') ?>
<?= $this->section('title') ?>Jadwal Tersedia<?= $this->endSection() ?>
<?= $this->section('content') ?>

    <!-- ================= JADWAL TERSEDIA ================= -->
    <section class="preview-section" style="padding-top: 7rem;">
        <div class="container">
            <!-- Section Header -->
            <div class="text-center mb-5">
                <span class="section-label d-block mb-2">Jadwal Layanan</span>
                <h2 class="section-title">Jadwal yang Tersedia</h2>
                <p class="mt-2" style="color: var(--on-surface-variant);">Pilih jadwal yang sesuai untuk melakukan konsultasi</p>
            </div>

            <!-- Schedule Panel -->
            <div class="preview-container">
                <div class="row g-4">
                    <!-- Sidebar Calendar -->
                    <div class="col-md-4 col-lg-3">
                        <div class="preview-sidebar">
                            <!-- Mini Calendar -->
                            <div class="calendar-card mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="calendar-header">Oktober 2024</span>
                                    <div class="d-flex gap-1">
                                        <span class="material-symbols-outlined calendar-nav">chevron_left</span>
                                        <span class="material-symbols-outlined calendar-nav">chevron_right</span>
                                    </div>
                                </div>
                                <div class="calendar-grid">
                                    <span>M</span><span>S</span><span>S</span><span>R</span><span>K</span><span>J</span><span>S</span>
                                    <span class="calendar-day-muted">26</span>
                                    <span class="calendar-day-muted">27</span>
                                    <span class="calendar-day-muted">28</span>
                                    <span class="calendar-day-muted">29</span>
                                    <span class="calendar-day-muted">30</span>
                                    <span>1</span><span>2</span>
                                    <span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span>
                                    <span>10</span><span>11</span>
                                    <span><span class="calendar-day-active">12</span></span>
                                    <span>13</span><span>14</span><span>15</span><span>16</span>
                                </div>
                            </div>
                            <!-- Info Badge -->
                            <div class="info-badge">
                                <span class="material-symbols-outlined">info</span>
                                <span class="font-label fw-semibold" style="font-size:.75rem;">3 Jadwal Tersedia Hari Ini</span>
                            </div>
                        </div>
                    </div>

                    <!-- Main View - Slot List -->
                    <div class="col-md-8 col-lg-9">
                        <div class="preview-main h-100">
                            <div class="d-flex flex-wrap justify-content-between align-items-end mb-5 gap-3">
                                <div>
                                    <h3 class="slots-title mb-1">Jadwal Tersedia</h3>
                                    <p class="slots-date mb-0">Kamis, 12 Oktober 2024</p>
                                </div>
                                <button class="filter-btn">Filter Spesialis</button>
                            </div>

                            <div class="d-flex flex-column gap-3">
                                <!-- Slot 1 — Available -->
                                <div class="slot-card slot-card-available">
                                    <div class="d-flex align-items-center gap-4">
                                        <div class="slot-time">09:00 <span class="slot-time-suffix">WIB</span></div>
                                        <div class="slot-divider d-none d-md-block"></div>
                                        <div>
                                            <div class="slot-title">Konsultasi Strategis</div>
                                            <div class="slot-meta">60 Menit • Daring</div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge-available">Tersedia</span>
                                        <span class="material-symbols-outlined slot-arrow">arrow_forward</span>
                                    </div>
                                </div>

                                <!-- Slot 2 — Booked -->
                                <div class="slot-card slot-card-booked">
                                    <div class="d-flex align-items-center gap-4">
                                        <div class="slot-time">10:30 <span class="slot-time-suffix">WIB</span></div>
                                        <div class="slot-divider d-none d-md-block"></div>
                                        <div>
                                            <div class="slot-title">Audit Arsitektur</div>
                                            <div class="slot-meta">90 Menit • Tatap Muka</div>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge-booked">Terisi</span>
                                    </div>
                                </div>

                                <!-- Slot 3 — Available -->
                                <div class="slot-card slot-card-available">
                                    <div class="d-flex align-items-center gap-4">
                                        <div class="slot-time">13:00 <span class="slot-time-suffix">WIB</span></div>
                                        <div class="slot-divider d-none d-md-block"></div>
                                        <div>
                                            <div class="slot-title">Sesi Roadmap Proyek</div>
                                            <div class="slot-meta">45 Menit • Daring</div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge-available">Tersedia</span>
                                        <span class="material-symbols-outlined slot-arrow">arrow_forward</span>
                                    </div>
                                </div>

                                <!-- Slot 4 — Available -->
                                <div class="slot-card slot-card-available">
                                    <div class="d-flex align-items-center gap-4">
                                        <div class="slot-time">14:30 <span class="slot-time-suffix">WIB</span></div>
                                        <div class="slot-divider d-none d-md-block"></div>
                                        <div>
                                            <div class="slot-title">Review Dokumen</div>
                                            <div class="slot-meta">30 Menit • Daring</div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge-available">Tersedia</span>
                                        <span class="material-symbols-outlined slot-arrow">arrow_forward</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>