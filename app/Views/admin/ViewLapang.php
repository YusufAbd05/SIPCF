<?= $this->extend('template/admin/base') ?>
<?= $this->section('title') ?>Kelola Lapang<?= $this->endSection() ?>
<?= $this->section('content') ?>

<main class="flex-grow-1 p-3 p-md-5" style="background:var(--admin-surface);">

    <!-- Flash Message Toast -->
    <?php if (session()->getFlashdata('success')): ?>
        <div id="alertToast" class="alert-toast">
            <span class="material-symbols-outlined">check_circle</span>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header animate-in">
        <div>
            <h2 class="page-header__title">Kelola Lapang</h2>
            <p class="page-header__subtitle">Manajemen data lapangan olahraga</p>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addLapangModal">
            <span class="material-symbols-outlined">add_circle</span>
            Tambah Lapang
        </button>
    </div>

    <!-- Stats -->
    <div class="stats-row animate-in" style="animation-delay:.06s;">
        <div class="stat-chip">
            <div class="stat-chip__icon blue"><span class="material-symbols-outlined">stadium</span></div>
            <div>
                <p class="stat-chip__label">Total Lapang</p>
                <p class="stat-chip__value"><?= $totalLapang ?></p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon green"><span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="stat-chip__label">Dapat Digunakan</p>
                <p class="stat-chip__value"><?= $totalTersedia ?></p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon amber"><span class="material-symbols-outlined">build</span></div>
            <div>
                <p class="stat-chip__label">Perbaikan</p>
                <p class="stat-chip__value"><?= $totalPerbaikan ?></p>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card animate-in" style="animation-delay:.12s;">
        <div class="table-toolbar">
            <div class="table-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" id="searchInput" placeholder="Cari nama lapang..." oninput="searchTable()" />
            </div>
            <div class="d-flex gap-2">
                <button class="table-filter-btn" id="filterAll" onclick="filterStatus('all')">
                    <span class="material-symbols-outlined">stadium</span> Semua
                </button>
                <button class="table-filter-btn" id="filterTersedia" onclick="filterStatus('Tersedia')">
                    <span class="material-symbols-outlined">check_circle</span> Tersedia
                </button>
                <button class="table-filter-btn" id="filterPerbaikan" onclick="filterStatus('Perbaikan')">
                    <span class="material-symbols-outlined">build</span> Perbaikan
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="lapang-table" id="lapangTable">
                <thead>
                    <tr>
                        <th>Nama Lapang / Spesifikasi</th>
                        <th>Jam Operasional</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lapangs)): ?>
                        <?php foreach ($lapangs as $lapang): ?>
                            <?php
                            $statusClass = $lapang['status_lapang'] === 'Tersedia' ? 'dapat-digunakan' : 'perbaikan';

                            // Map spesifikasi value to display label
                            $spekLabels = [
                                'Rumput Sintetis' => 'Karpet Rumput Sintetis',
                                'Vinyl / Interlock' => 'Karpet Vinyl (Interlock)',
                                'Beton / Plester' => 'Lantai Beton / Plester',
                            ];
                            $spekDisplay = $spekLabels[$lapang['spesifikasi_lapang']] ?? esc($lapang['spesifikasi_lapang']);

                            // Format jam operasional
                            $bukaWd = substr($lapang['jam_buka_weekday'], 0, 5);
                            $tutupWd = substr($lapang['jam_tutup_weekday'], 0, 5);
                            $bukaWe = substr($lapang['jam_buka_weekend'], 0, 5);
                            $tutupWe = substr($lapang['jam_tutup_weekend'], 0, 5);
                            ?>
                            <tr data-status="<?= esc($lapang['status_lapang']) ?>">
                                <td>
                                    <div class="td-name text-dark fw-bold"><?= esc($lapang['nama_lapangan']) ?></div>
                                    <div class="td-secondary mt-1"><?= $spekDisplay ?></div>
                                </td>
                                <td>
                                    <div class="td-hours">
                                        <div class="td-hours-item"><span class="day">Sen-Jum</span> <span
                                                class="time"><?= $bukaWd ?> — <?= $tutupWd ?></span></div>
                                        <div class="td-hours-item"><span class="day">Sab-Min</span> <span
                                                class="time"><?= $bukaWe ?> — <?= $tutupWe ?></span></div>
                                    </div>
                                </td>
                                <td><span class="badge-pill <?= $statusClass ?>"><span
                                            class="dot"></span><?= esc($lapang['status_lapang']) ?></span></td>
                                <td style="text-align:center;">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button class="action-btn edit" title="Edit"
                                            onclick="openEditModal(<?= $lapang['id_lapang'] ?>, '<?= esc($lapang['nama_lapangan']) ?>', '<?= esc($lapang['spesifikasi_lapang']) ?>', '<?= esc($lapang['status_lapang']) ?>', '<?= esc($lapang['jam_buka_weekday']) ?>', '<?= esc($lapang['jam_tutup_weekday']) ?>', '<?= esc($lapang['jam_buka_weekend']) ?>', '<?= esc($lapang['jam_tutup_weekend']) ?>')">
                                            <span class="material-symbols-outlined">edit</span> Edit Lapangan
                                        </button>
                                        <button class="action-btn delete" title="Hapus"
                                            onclick="openDeleteModal(<?= $lapang['id_lapang'] ?>, '<?= esc($lapang['nama_lapangan']) ?>')">
                                            <span class="material-symbols-outlined">delete</span> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align:center; padding:3rem 1rem;">
                                <span class="material-symbols-outlined"
                                    style="font-size:2.5rem; color:var(--admin-outline); display:block; margin-bottom:0.5rem;">stadium</span>
                                <p style="color:var(--admin-secondary); font-size:0.85rem; margin:0;">Belum ada data lapang
                                </p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($lapangs)): ?>
            <div class="table-footer">
                <span class="table-footer__info">Menampilkan <?= count($lapangs) ?> data</span>
            </div>
        <?php endif; ?>
    </div>

</main>

<!-- ===== MODAL: TAMBAH LAPANG ===== -->
<div class="modal fade" id="addLapangModal" tabindex="-1" aria-labelledby="addLapangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLapangLabel">
                    <span class="material-symbols-outlined">add_circle</span>
                    Tambah Lapang Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/admin/lapang/save') ?>" method="post" id="formAddLapang">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <!-- Section: Informasi Lapang -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">info</span>
                        Informasi Lapang
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">stadium</span> Nama Lapang
                            </label>
                            <input type="text" name="nama_lapangan" class="form-control-custom"
                                placeholder="Contoh: Lapang Futsal A" required />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">layers</span> Spesifikasi Karpet
                            </label>
                            <select name="spesifikasi_lapang" class="form-control-custom" required>
                                <option value="" disabled selected>Pilih spesifikasi...</option>
                                <option value="Rumput Sintetis">Rumput Sintetis</option>
                                <option value="Vinyl / Interlock">Vinyl / Interlock</option>
                                <option value="Beton / Plester">Beton / Plester</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">flag</span> Status Lapangan
                            </label>
                            <select name="status_lapang" class="form-control-custom" required>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Perbaikan">Perbaikan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section: Jam Operasional -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">schedule</span>
                        Jam Operasional
                    </div>
                    <div class="mb-3">
                        <div class="hours-row">
                            <span class="day-label">Sen-Jum</span>
                            <input type="time" name="jam_buka_weekday" class="hours-input" value="08:00">
                            <span class="hours-sep">—</span>
                            <input type="time" name="jam_tutup_weekday" class="hours-input" value="24:00">
                        </div>
                        <div class="hours-row">
                            <span class="day-label">Sab-Min</span>
                            <input type="time" name="jam_buka_weekend" class="hours-input" value="08:00">
                            <span class="hours-sep">—</span>
                            <input type="time" name="jam_tutup_weekend" class="hours-input" value="23:00">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">
                        <span class="material-symbols-outlined">save</span> Simpan Lapang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== MODAL: EDIT LAPANG ===== -->
<div class="modal fade" id="editLapangModal" tabindex="-1" aria-labelledby="editLapangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLapangLabel">
                    <span class="material-symbols-outlined">edit</span>
                    Edit Lapang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/admin/lapang/update') ?>" method="post" id="formEditLapang">
                <?= csrf_field() ?>
                <input type="hidden" name="id_lapang" id="editIdLapang" />
                <div class="modal-body">
                    <!-- Section: Informasi Lapang -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">info</span>
                        Informasi Lapang
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">stadium</span> Nama Lapang
                            </label>
                            <input type="text" name="nama_lapangan" id="editNamaLapangan" class="form-control-custom"
                                required />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">layers</span> Spesifikasi Karpet
                            </label>
                            <select name="spesifikasi_lapang" id="editSpesifikasi" class="form-control-custom" required>
                                <option value="" disabled>Pilih spesifikasi...</option>
                                <option value="Rumput Sintetis">Rumput Sintetis</option>
                                <option value="Vinyl / Interlock">Vinyl / Interlock</option>
                                <option value="Beton / Plester">Beton / Plester</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">flag</span> Status Lapangan
                            </label>
                            <select name="status_lapang" id="editStatus" class="form-control-custom" required>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Perbaikan">Perbaikan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section: Jam Operasional -->
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">schedule</span>
                        Jam Operasional
                    </div>
                    <div class="mb-3">
                        <div class="hours-row">
                            <span class="day-label">Sen-Jum</span>
                            <input type="time" name="jam_buka_weekday" id="editBukaWeekday" class="hours-input">
                            <span class="hours-sep">—</span>
                            <input type="time" name="jam_tutup_weekday" id="editTutupWeekday" class="hours-input">
                        </div>
                        <div class="hours-row">
                            <span class="day-label">Sab-Min</span>
                            <input type="time" name="jam_buka_weekend" id="editBukaWeekend" class="hours-input">
                            <span class="hours-sep">—</span>
                            <input type="time" name="jam_tutup_weekend" id="editTutupWeekend" class="hours-input">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">
                        <span class="material-symbols-outlined">save</span> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== MODAL: HAPUS LAPANG ===== -->
<div class="modal fade" id="deleteLapangModal" tabindex="-1" aria-labelledby="deleteLapangLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color:#fecaca;">
                <h5 class="modal-title" id="deleteLapangLabel">
                    <span class="material-symbols-outlined" style="color:#dc2626;">warning</span>
                    Hapus Lapang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/admin/lapang/delete') ?>" method="post" id="formDeleteLapang">
                <?= csrf_field() ?>
                <input type="hidden" name="id_lapang" id="deleteIdLapang" />
                <div class="modal-body" style="text-align:center; padding:1.5rem;">
                    <div
                        style="width:3.5rem;height:3.5rem;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <span class="material-symbols-outlined" style="font-size:1.75rem;color:#dc2626;">stadium</span>
                    </div>
                    <p style="font-size:0.88rem;font-weight:600;color:var(--admin-on-surface);margin-bottom:0.35rem;">
                        Yakin ingin menghapus lapang ini?
                    </p>
                    <p id="deleteLapangName" style="font-size:0.78rem;color:var(--admin-secondary);margin-bottom:0;">
                    </p>
                    <p style="font-size:0.72rem;color:var(--admin-outline);margin-top:0.5rem;margin-bottom:0;">
                        Data yang dihapus tidak dapat dikembalikan.
                    </p>
                </div>
                <div class="modal-footer" style="justify-content:center;border-top-color:#fecaca;">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save"
                        style="background:linear-gradient(135deg,#dc2626,#ef4444);box-shadow:0 4px 12px -2px rgba(220,38,38,0.3);">
                        <span class="material-symbols-outlined">delete</span> Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Open Edit Modal with data
    function openEditModal(id, nama, spesifikasi, status, bukaWd, tutupWd, bukaWe, tutupWe) {
        document.getElementById('editIdLapang').value = id;
        document.getElementById('editNamaLapangan').value = nama;
        document.getElementById('editSpesifikasi').value = spesifikasi;
        document.getElementById('editStatus').value = status;
        document.getElementById('editBukaWeekday').value = bukaWd.substring(0, 5);
        document.getElementById('editTutupWeekday').value = tutupWd.substring(0, 5);
        document.getElementById('editBukaWeekend').value = bukaWe.substring(0, 5);
        document.getElementById('editTutupWeekend').value = tutupWe.substring(0, 5);
        new bootstrap.Modal(document.getElementById('editLapangModal')).show();
    }

    // Open Delete Modal with data
    function openDeleteModal(id, nama) {
        document.getElementById('deleteIdLapang').value = id;
        document.getElementById('deleteLapangName').textContent = '"' + nama + '"';
        new bootstrap.Modal(document.getElementById('deleteLapangModal')).show();
    }

    // Search table
    function searchTable() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#lapangTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }

    // Filter by status
    function filterStatus(status) {
        const rows = document.querySelectorAll('#lapangTable tbody tr');
        rows.forEach(row => {
            if (status === 'all') {
                row.style.display = '';
            } else {
                row.style.display = row.dataset.status === status ? '' : 'none';
            }
        });

        // Update active button styling
        document.querySelectorAll('.table-filter-btn').forEach(btn => {
            btn.classList.remove('filter-active');
        });
        const activeBtn = status === 'all' ? document.getElementById('filterAll') :
            status === 'Tersedia' ? document.getElementById('filterTersedia') :
                document.getElementById('filterPerbaikan');
        if (activeBtn) {
            activeBtn.classList.add('filter-active');
        }
    }

    // Auto-dismiss flash message
    document.addEventListener('DOMContentLoaded', function () {
        const toast = document.getElementById('alertToast');
        if (toast) {
            setTimeout(() => {
                toast.style.transition = 'opacity 0.5s, transform 0.5s';
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        // Set "Semua" filter as active by default
        document.getElementById('filterAll').classList.add('filter-active');
    });
</script>

<?= $this->endSection() ?>