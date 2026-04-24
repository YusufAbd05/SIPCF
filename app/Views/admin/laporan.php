<?= $this->extend('template/admin/base') ?>
<?= $this->section('title') ?>Laporan Keuangan<?= $this->endSection() ?>
<?= $this->section('content') ?>
<main class="flex-grow-1 p-3 p-md-5" style="background:var(--admin-surface);">

    <!-- Page Header -->
    <div class="page-header animate-in">
        <div>
            <h2 class="page-header__title">Laporan Keuangan</h2>
            <p class="page-header__subtitle">Rekapitulasi pesanan dan pendapatan lapangan operasional</p>
        </div>
        <div class="action-group d-flex gap-2 flex-wrap">
            <button class="btn-export btn-export--excel" id="btnExportExcel" onclick="exportExcel()">
                <span class="material-symbols-outlined">table_view</span> Export Excel
            </button>
            <button class="btn-export btn-export--pdf" id="btnExportPdf" onclick="exportPDF()">
                <span class="material-symbols-outlined">picture_as_pdf</span> Export PDF
            </button>
        </div>
    </div>

    <!-- Filter Controls -->
    <div class="laporan-filter-card animate-in" style="animation-delay:.06s;">
        <form method="get" action="<?= base_url('/admin/laporan') ?>" id="filterForm">
            <div class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="form-label-custom">
                        <span class="material-symbols-outlined">calendar_month</span> Tgl. Mulai
                    </label>
                    <input type="date" class="form-control laporan-input" name="tgl_mulai"
                        id="filterTglMulai" value="<?= esc($tglMulai) ?>" />
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">
                        <span class="material-symbols-outlined">event</span> Tgl. Selesai
                    </label>
                    <input type="date" class="form-control laporan-input" name="tgl_selesai"
                        id="filterTglSelesai" value="<?= esc($tglSelesai) ?>" />
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">
                        <span class="material-symbols-outlined">stadium</span> Pilih Lapangan
                    </label>
                    <select class="form-select laporan-input" name="id_lapang" id="filterLapang">
                        <option value="all" <?= $idLapang === 'all' ? 'selected' : '' ?>>Semua Lapangan</option>
                        <?php foreach ($lapangs as $l): ?>
                            <option value="<?= $l['id_lapang'] ?>" <?= $idLapang == $l['id_lapang'] ? 'selected' : '' ?>>
                                <?= esc($l['nama_lapangan']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 text-md-end">
                    <button type="submit" class="btn-filter-apply w-100" id="btnApplyFilter">
                        <span class="material-symbols-outlined">filter_alt</span>
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="stats-row animate-in" style="animation-delay:.12s;">
        <div class="stat-chip stat-chip--elevated">
            <div class="stat-chip__icon green">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="stat-chip__label">Total Pesanan Selesai</p>
                <p class="stat-chip__value"><?= number_format($totalPesanan) ?> <span class="stat-chip__unit">Sesi</span></p>
            </div>
        </div>
        <div class="stat-chip stat-chip--elevated">
            <div class="stat-chip__icon blue">
                <span class="material-symbols-outlined">payments</span>
            </div>
            <div>
                <p class="stat-chip__label">Omset Terfilter</p>
                <p class="stat-chip__value">Rp <?= number_format($totalOmset, 0, ',', '.') ?></p>
            </div>
        </div>
        <div class="stat-chip stat-chip--elevated">
            <div class="stat-chip__icon amber">
                <span class="material-symbols-outlined">stadium</span>
            </div>
            <div>
                <p class="stat-chip__label">Lapangan Terlaris</p>
                <p class="stat-chip__value" style="font-size:0.9rem;"><?= esc($lapangTerlaris) ?></p>
            </div>
        </div>
        <div class="stat-chip stat-chip--elevated">
            <div class="stat-chip__icon indigo">
                <span class="material-symbols-outlined">avg_pace</span>
            </div>
            <div>
                <p class="stat-chip__label">Rata-rata / Sesi</p>
                <p class="stat-chip__value">Rp <?= $totalPesanan > 0 ? number_format(round($totalOmset / $totalPesanan), 0, ',', '.') : '0' ?></p>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4 animate-in" style="animation-delay:.18s;">
        <!-- Revenue Trend Chart -->
        <div class="col-12 col-lg-8">
            <div class="content-card h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
                    <div>
                        <h4 class="content-card__title">Tren Pendapatan</h4>
                        <p class="content-card__subtitle mb-0">Grafik pendapatan harian dalam periode filter</p>
                    </div>
                    <div class="chart-legend">
                        <span class="chart-legend__dot" style="background: var(--admin-primary);"></span>
                        <span class="chart-legend__text">Pendapatan</span>
                    </div>
                </div>
                <div class="chart-container" id="revenueChartContainer">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Payment Method Distribution -->
        <div class="col-12 col-lg-4">
            <div class="content-card h-100 d-flex flex-column">
                <h4 class="content-card__title">Distribusi Metode Bayar</h4>
                <p class="content-card__subtitle mb-3">Proporsi metode pembayaran yang digunakan</p>
                <div class="chart-container-donut flex-grow-1 d-flex align-items-center justify-content-center">
                    <canvas id="metodeChart"></canvas>
                </div>
                <div class="metode-legend mt-3" id="metodeLegend"></div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-card table-responsive animate-in" style="animation-delay:.24s;">
        <div class="table-toolbar">
            <div class="d-flex align-items-center gap-2">
                <h5 style="font-size:0.9rem; font-weight:700; margin:0; color:var(--admin-on-surface);">
                    <span class="material-symbols-outlined" style="font-size:1.1rem; vertical-align:middle; margin-right:4px; color:var(--admin-primary);">receipt_long</span>
                    Detail Transaksi
                </h5>
                <span class="badge-count"><?= number_format($totalPesanan) ?> data</span>
            </div>
            <div class="table-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" placeholder="Cari nama penyewa, kode..." id="searchInput" oninput="filterTable()" />
            </div>
        </div>
        <table class="booking-table" id="laporanTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Sewa</th>
                    <th>Tanggal</th>
                    <th>Nama Penyewa</th>
                    <th>Lapangan</th>
                    <th>Jam Main</th>
                    <th>Durasi</th>
                    <th>Total Bayar</th>
                    <th>Dibayar</th>
                    <th>Metode</th>
                    <th>Tipe</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="12" class="text-center py-5">
                            <span class="material-symbols-outlined d-block mx-auto mb-2" style="font-size:3rem; color:var(--admin-outline-variant);">inbox</span>
                            <p style="color:var(--admin-secondary); font-weight:500;">Tidak ada data untuk periode yang dipilih</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($bookings as $b): ?>
                        <tr>
                            <td class="td-secondary"><?= $no++ ?></td>
                            <td class="td-code"><?= esc($b['kode_sewa'] ?? '-') ?></td>
                            <td class="fw-bold"><?= date('d M Y', strtotime($b['tanggal_main'])) ?></td>
                            <td class="td-name"><?= esc($b['nama_penyewa'] ?? '-') ?></td>
                            <td><?= esc($b['nama_lapangan'] ?? '-') ?></td>
                            <td>
                                <span class="badge text-bg-light border" style="font-size:0.7rem;">
                                    <?= substr($b['jam_mulai'], 0, 5) ?> - <?= substr($b['jam_selesai'], 0, 5) ?>
                                </span>
                            </td>
                            <td class="td-secondary"><?= esc($b['durasi_jam'] ?? '-') ?> Jam</td>
                            <td class="td-currency">Rp <?= number_format($b['total_bayar'] ?? 0, 0, ',', '.') ?></td>
                            <td class="td-currency <?= ($b['jumlah_bayar'] ?? 0) >= ($b['total_bayar'] ?? 0) ? 'green' : '' ?>">
                                Rp <?= number_format($b['jumlah_bayar'] ?? 0, 0, ',', '.') ?>
                            </td>
                            <td>
                                <?php
                                    $metode = $b['metode_pembayaran'] ?? 'Cash';
                                    $metodeClass = 'cash';
                                    if (stripos($metode, 'Transfer') !== false) $metodeClass = 'transfer';
                                    elseif (stripos($metode, 'E-Wallet') !== false || stripos($metode, 'Ewallet') !== false) $metodeClass = 'ewallet';
                                    elseif (stripos($metode, 'QRIS') !== false) $metodeClass = 'qris';
                                ?>
                                <span class="badge-method <?= $metodeClass ?>"><?= esc($metode) ?></span>
                            </td>
                            <td>
                                <?php
                                    $tipe = $b['tipe_pesanan'] ?? 'Walk-in';
                                    $tipeClass = $tipe === 'Online' ? 'online' : 'walkin';
                                ?>
                                <span class="badge-tipe <?= $tipeClass ?>"><?= esc($tipe) ?></span>
                            </td>
                            <td>
                                <?php
                                    $status = $b['status_pesanan'] ?? '-';
                                    $statusClass = 'dikonfirmasi';
                                    if ($status === 'Selesai') $statusClass = 'selesai';
                                ?>
                                <span class="badge-pill <?= $statusClass ?>"><?= esc($status) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="table-footer border-top">
            <span class="table-footer__info">
                Menampilkan <strong id="displayCount"><?= count($bookings) ?></strong> dari <strong><?= count($bookings) ?></strong> data
            </span>
            <div class="table-footer__period">
                <span class="material-symbols-outlined" style="font-size:0.9rem; vertical-align:middle; color:var(--admin-primary);">date_range</span>
                <span style="font-size:0.72rem; color:var(--admin-secondary); font-weight:600;">
                    Periode: <?= date('d M Y', strtotime($tglMulai)) ?> — <?= date('d M Y', strtotime($tglSelesai)) ?>
                </span>
            </div>
        </div>
    </div>

</main>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
    // ===== DATA FROM PHP =====
    const chartLabels = <?= json_encode($chartData['labels']) ?>;
    const chartValues = <?= json_encode($chartData['values']) ?>;
    const metodeData  = <?= json_encode($metodeDistribusi) ?>;

    // ===== REVENUE TREND CHART =====
    const rCtx = document.getElementById('revenueChart').getContext('2d');

    const gradient = rCtx.createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(0, 87, 205, 0.18)');
    gradient.addColorStop(1, 'rgba(0, 87, 205, 0.01)');

    new Chart(rCtx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: chartValues,
                borderColor: '#0057cd',
                backgroundColor: gradient,
                borderWidth: 2.5,
                pointBackgroundColor: '#0057cd',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { family: 'Inter', weight: '600' },
                    bodyFont: { family: 'Inter' },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(ctx) {
                            return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Inter', size: 11, weight: '600' },
                        color: '#94a3b8'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(148,163,184,0.08)' },
                    ticks: {
                        font: { family: 'Inter', size: 11 },
                        color: '#94a3b8',
                        callback: function(val) {
                            if (val >= 1000000) return 'Rp ' + (val/1000000).toFixed(1) + 'jt';
                            if (val >= 1000) return 'Rp ' + (val/1000) + 'rb';
                            return 'Rp ' + val;
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // ===== METODE PEMBAYARAN DONUT CHART =====
    const metodeColors = {
        'Cash': '#059669',
        'Transfer Bank': '#2563eb',
        'E-Wallet': '#7c3aed',
        'QRIS': '#ea580c',
    };

    const metodeLabels = metodeData.map(m => m.metode || 'Cash');
    const metodeValues = metodeData.map(m => parseInt(m.total) || 0);
    const metodeBg = metodeLabels.map(l => metodeColors[l] || '#94a3b8');

    const mCtx = document.getElementById('metodeChart').getContext('2d');
    new Chart(mCtx, {
        type: 'doughnut',
        data: {
            labels: metodeLabels,
            datasets: [{
                data: metodeValues,
                backgroundColor: metodeBg,
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { family: 'Inter', weight: '600' },
                    bodyFont: { family: 'Inter' },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(ctx) {
                            return ctx.label + ': Rp ' + ctx.parsed.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Render custom legend
    const legendEl = document.getElementById('metodeLegend');
    metodeData.forEach(m => {
        const color = metodeColors[m.metode] || '#94a3b8';
        legendEl.innerHTML += `
            <div class="metode-legend__item">
                <span class="metode-legend__dot" style="background:${color};"></span>
                <span class="metode-legend__label">${m.metode || 'Cash'}</span>
                <span class="metode-legend__value">Rp ${parseInt(m.total || 0).toLocaleString('id-ID')}</span>
            </div>
        `;
    });

    // ===== TABLE SEARCH / FILTER =====
    function filterTable() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#laporanTable tbody tr');
        let visible = 0;
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const show = text.includes(q);
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        document.getElementById('displayCount').textContent = visible;
    }

    // ===== EXPORT FUNCTIONS =====
    function getFilterParams() {
        const tglMulai = document.getElementById('filterTglMulai').value;
        const tglSelesai = document.getElementById('filterTglSelesai').value;
        const idLapang = document.getElementById('filterLapang').value;
        return { tgl_mulai: tglMulai, tgl_selesai: tglSelesai, id_lapang: idLapang };
    }

    function exportExcel() {
        const btn = document.getElementById('btnExportExcel');
        btn.classList.add('loading');
        btn.disabled = true;

        const params = getFilterParams();
        const url = `<?= base_url('/admin/laporan/exportData') ?>?tgl_mulai=${params.tgl_mulai}&tgl_selesai=${params.tgl_selesai}&id_lapang=${params.id_lapang}`;

        fetch(url)
            .then(r => r.json())
            .then(json => {
                // Build CSV
                let csv = 'No,Kode Sewa,Tanggal,Nama Penyewa,Lapangan,Jam Mulai,Jam Selesai,Durasi,Total Bayar,Dibayar,Metode,Tipe,Status\n';
                json.data.forEach((d, i) => {
                    csv += `${i+1},"${d.kode_sewa}","${d.tanggal_main}","${d.nama_penyewa}","${d.nama_lapangan}","${d.jam_mulai}","${d.jam_selesai}","${d.durasi_jam}","${d.total_bayar}","${d.jumlah_bayar}","${d.metode_pembayaran}","${d.tipe_pesanan}","${d.status_pesanan}"\n`;
                });

                const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `Laporan_Keuangan_${params.tgl_mulai}_${params.tgl_selesai}.csv`;
                link.click();
                URL.revokeObjectURL(link.href);
            })
            .catch(err => {
                alert('Gagal export: ' + err.message);
            })
            .finally(() => {
                btn.classList.remove('loading');
                btn.disabled = false;
            });
    }

    function exportPDF() {
        const btn = document.getElementById('btnExportPdf');
        btn.classList.add('loading');
        btn.disabled = true;

        // Print the table area
        const printContent = document.getElementById('laporanTable').outerHTML;
        const params = getFilterParams();
        const win = window.open('', '_blank');
        win.document.write(`
            <!DOCTYPE html>
            <html><head>
            <title>Laporan Keuangan SIPCF</title>
            <style>
                body { font-family: 'Segoe UI', Arial, sans-serif; padding: 2rem; color: #1e293b; }
                h1 { font-size: 1.3rem; margin-bottom: 0.25rem; }
                .periode { font-size: 0.85rem; color: #64748b; margin-bottom: 1.5rem; }
                table { width: 100%; border-collapse: collapse; font-size: 0.78rem; }
                th { background: #f1f5f9; padding: 8px 10px; text-align: left; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.05em; color: #475569; border-bottom: 2px solid #e2e8f0; }
                td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; }
                tr:nth-child(even) { background: #fafbfc; }
                @media print { body { padding: 0; } }
            </style>
            </head><body>
                <h1>Laporan Keuangan — SIPCF</h1>
                <p class="periode">Periode: ${params.tgl_mulai} s/d ${params.tgl_selesai}</p>
                ${printContent}
                <script>window.print(); window.close();<\/script>
            </body></html>
        `);
        win.document.close();

        btn.classList.remove('loading');
        btn.disabled = false;
    }
</script>

<?= $this->endSection() ?>