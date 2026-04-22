<?= $this->extend('template/admin/base') ?>
<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('content') ?>

<main class="flex-grow-1 p-3 p-md-5" style="background:var(--admin-surface);">

    <!-- Welcome Banner -->
    <section class="mb-4 animate-in">
        <div class="welcome-banner">
            <div class="position-relative" style="z-index:1;max-width:36rem;">
                <h2>Selamat Datang, Admin!</h2>
                <p>Sistem Digital Atrium Anda beroperasi dengan optimal hari ini. Terdapat <b>5 pesanan
                        booking</b> yang sedang menunggu verifikasi pembayaran dari Anda.</p>
                <div class="d-flex gap-3 mt-4">
                    <a href="laporan.html"
                        class="btn-welcome-primary text-decoration-none d-inline-flex align-items-center gap-2">
                        <span class="material-symbols-outlined" style="font-size:1.1rem;">print</span>
                        Ekspor Rekap Laporan
                    </a>
                    <button class="btn-welcome-ghost">Cek Log Sistem</button>
                </div>
            </div>
            <div class="glow"></div>
        </div>
    </section>

    <!-- Metrics Grid -->
    <section class="row g-3 mb-4">
        <!-- Sewa Hari Ini -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.08s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon blue">
                        <span class="material-symbols-outlined">event_available</span>
                    </div>
                    <span class="metric-badge up">+2 Sesi</span>
                </div>
                <p class="metric-label">Sewa Hari Ini</p>
                <h3 class="metric-value">12 <span
                        style="font-size:0.9rem; font-weight:600; color:var(--admin-secondary);">Sesi</span>
                </h3>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.14s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon amber">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                    <span class="metric-badge down" style="color:#d97706; background:#fffbeb;">Cek
                        Detail</span>
                </div>
                <p class="metric-label">Menunggu Verifikasi</p>
                <h3 class="metric-value">5 <span
                        style="font-size:0.9rem; font-weight:600; color:var(--admin-secondary);">Pesanan</span>
                </h3>
            </div>
        </div>

        <!-- Omset Bulan Ini -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.2s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon green">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <span class="metric-badge up">+15.2%</span>
                </div>
                <p class="metric-label">Omset Bulan Ini (Lunas)</p>
                <h3 class="metric-value" style="font-size:1.45rem;">Rp 8.450k</h3>
            </div>
        </div>

        <!-- Total Member -->
        <div class="col-12 col-md-6 col-lg-3 animate-in" style="animation-delay:.26s;">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="metric-icon indigo">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <span class="metric-badge up">+4 New</span>
                </div>
                <p class="metric-label">Total Member Aktif</p>
                <h3 class="metric-value">124</h3>
            </div>
        </div>
    </section>

    <!-- Dual View Section -->
    <section class="row g-4 animate-in" style="animation-delay:.32s;">
        <!-- Revenue Trend -->
        <div class="col-12 col-lg-8">
            <div class="content-card h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
                    <div>
                        <h4 class="content-card__title">Revenue Trend</h4>
                        <p class="content-card__subtitle mb-0">Historical growth over the last 30 days</p>
                    </div>
                    <div class="tab-pills">
                        <button class="tab-pill active">Monthly</button>
                        <button class="tab-pill">Weekly</button>
                    </div>
                </div>
                <div class="chart-placeholder">
                    <!-- Simulated chart bars -->
                    <div class="chart-bars">
                        <div class="chart-bar" style="height:25%"></div>
                        <div class="chart-bar" style="height:50%"></div>
                        <div class="chart-bar" style="height:33%"></div>
                        <div class="chart-bar" style="height:75%"></div>
                        <div class="chart-bar" style="height:66%"></div>
                        <div class="chart-bar" style="height:100%"></div>
                        <div class="chart-bar" style="height:80%"></div>
                        <div class="chart-bar" style="height:66%"></div>
                        <div class="chart-bar" style="height:75%"></div>
                        <div class="chart-bar" style="height:50%"></div>
                    </div>
                    <div class="text-center position-relative" style="z-index:1;">
                        <span class="material-symbols-outlined mb-3 d-block"
                            style="font-size:3rem;color:#bfdbfe;">monitoring</span>
                        <p class="mb-0" style="color:var(--admin-secondary);font-weight:500;">Real-time
                            revenue visualization</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-12 col-lg-4">
            <div class="content-card h-100 d-flex flex-column">
                <h4 class="content-card__title">Recent Activity</h4>
                <p class="content-card__subtitle mb-4">User interactions and log events</p>

                <div class="d-flex flex-column gap-4 flex-grow-1">
                    <!-- Row 1 -->
                    <div class="activity-row">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCp_qEaLDkwEEiPDrW9P7X-cNY5s4hqC2SNGfsjYsJ0EU47VzpGzq_byrXYqTUabmM14rGjz28fppBRz4jWS1jorj3oM1Xz3GKMmIsuEOrb78VvbDcQVg5yT_-YuFctVbcDlz0KxvTR1fEpbnaSZCxxMdbnYUYdcFv8fhnTa7LT_TjODC9j53SicHRz17Xxyl-IWp-IXEw-KNYnHOALTncC88fbjAyTEB77BVJ1ckq5_ZphxhTZmuaxJIcBOru9obuF2N1HoxnDO-o"
                            alt="Sarah Miller" class="activity-avatar" />
                        <div class="flex-grow-1 min-w-0">
                            <p class="activity-name">Sarah Miller</p>
                            <p class="activity-desc">Upgraded to Premium Plan</p>
                        </div>
                        <span class="activity-time">2m ago</span>
                    </div>

                    <!-- Row 2 -->
                    <div class="activity-row">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDM83U2g9TRdNrIvU2eKuMeR_1geEdE11Jz9Op8GTk5zo9Thm5wncRLtZgyNOsKa8dS1Ka9fSk9HokcfSMhLlIBUQSmGQu9vSAXqWlyQBGGnIS3mHIzu0jTpL8XJ_G0z9Ab4QbcvR4vkimcp4Y0pocjUOnUr27HBed11DKIax3HOmyOqPfp_PKtzhLoCEezqtvVuuG75QLZv2urToCjoxbCTER7QkaHnrts17pMXISceHq1VcLzyl7BPPFcL4hIO1tB8--yeMlPuxE"
                            alt="David Chen" class="activity-avatar" />
                        <div class="flex-grow-1 min-w-0">
                            <p class="activity-name">David Chen</p>
                            <p class="activity-desc">Logged in from San Francisco</p>
                        </div>
                        <span class="activity-time">15m ago</span>
                    </div>

                    <!-- Row 3 -->
                    <div class="activity-row">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDr4GIlsAqXNYheh1JPtWIHgkqQIZuQC5SNyCyRCUAJC4klRxOlm6o4ODBHwY_r-ZePyuMIcXyWAom2EOPhxvEhQ7shqtrtBlM9_rV6KokJ8BSwSC56A6CViqgEXIQas2WVMrdcnKnzSNhdP6J-vhJkHjHl7rTo1fWXXH5w9m0zoxcNjL19xpBERCa_L2IcLyVXzMsl00__uVWk0yclQ_HI4-KFe-glVqjR9FufsDRSEwGkFE4Vv3xoZx5N3A-abzk7EY6aENoXD0g"
                            alt="Elena Rodriguez" class="activity-avatar" />
                        <div class="flex-grow-1 min-w-0">
                            <p class="activity-name">Elena Rodriguez</p>
                            <p class="activity-desc">Purchased "Enterprise Pack"</p>
                        </div>
                        <span class="activity-time">1h ago</span>
                    </div>

                    <!-- Row 4 -->
                    <div class="activity-row">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDLTt7KlOblGObp1YgyXKKUUDiPJtrzPuJi3YvFntFzpRhsVAocHpOEz_9NJvoq3IKqcoMhN5cjJ3zPDZCqqU7KeK1nFBCUpj8TL5hT-PjRAGudeD3adT-PbknPJ37j9vrrj0wpMmJabI1rrmHq7SIQlw5Byktr2Hy9LxGpWivrQcNXF_KhV4oL7UD_ZCTxq3nkTfoz6XPty0a3ZtH1BPQwt8-zoZ5oxE1Hh7s1Wfr64lB8rNnRSemyVNAHTBk-bTUhllrOBM7fcbw"
                            alt="Mark Thompson" class="activity-avatar" />
                        <div class="flex-grow-1 min-w-0">
                            <p class="activity-name">Mark Thompson</p>
                            <p class="activity-desc">Support ticket resolved</p>
                        </div>
                        <span class="activity-time">3h ago</span>
                    </div>
                </div>

                <button class="btn-view-all mt-4">View All Activities</button>
            </div>
        </div>
    </section>

</main>
<?= $this->endSection() ?>