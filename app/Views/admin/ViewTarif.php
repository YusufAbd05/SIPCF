<?= $this->extend('template/admin/base') ?>
<?= $this->section('title') ?>Kelola Tarif<?= $this->endSection() ?>
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
            <h2 class="page-header__title">Kelola Tarif</h2>
            <p class="page-header__subtitle">Manajemen harga dinamis berdasar jam, hari, dan membership</p>
        </div>
        <button class="btn-add" onclick="openAddModal()">
            <span class="material-symbols-outlined">add_circle</span>
            Tambah
        </button>
    </div>

    <!-- Table Card -->
    <div class="table-card animate-in" style="animation-delay:.06s;">
        <div class="table-toolbar">
            <div class="table-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" id="searchInput" placeholder="Cari nama tarif..." oninput="searchTable()" />
            </div>
            <div class="d-flex gap-2">
                <button class="table-filter-btn" id="filterAll" onclick="filterHari('all')">
                    <span class="material-symbols-outlined">calendar_month</span> Semua
                </button>
                <button class="table-filter-btn" id="filterWeekday" onclick="filterHari('Weekday')">
                    <span class="material-symbols-outlined">work</span> Weekday
                </button>
                <button class="table-filter-btn" id="filterWeekend" onclick="filterHari('Weekend')">
                    <span class="material-symbols-outlined">weekend</span> Weekend
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="tarif-table" id="tarifTable">
                <thead>
                    <tr>
                        <th>Nama & Lapangan</th>
                        <th>Kategori Hari</th>
                        <th>Rentang Jam</th>
                        <th>Harga Umum</th>
                        <th>Harga Member</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tarifs)): ?>
                        <?php foreach ($tarifs as $tarif): ?>
                            <?php
                            // Badge class for hari
                            $hariClass = strtolower($tarif['hari']);
                            $hariLabel = match ($tarif['hari']) {
                                'Weekday' => 'Senin - Jumat',
                                'Weekend' => 'Sabtu - Minggu',
                                'Libur Nasional' => 'Libur Nasional',
                                default => $tarif['hari'],
                            };

                            // Format jam
                            $jamMulai = substr($tarif['jam_mulai'], 0, 5);
                            $jamSelesai = substr($tarif['jam_selesai'], 0, 5);

                            // Format harga
                            $hargaUmum = 'Rp ' . number_format($tarif['harga_umum'], 0, ',', '.');
                            $hargaMember = 'Rp ' . number_format($tarif['harga_member'], 0, ',', '.');
                            ?>
                            <tr data-hari="<?= esc($tarif['hari']) ?>">
                                <td>
                                    <div class="td-name"><?= esc($tarif['nama_tarif']) ?></div>
                                    <div class="td-lapangan"><?= esc($tarif['nama_lapangan']) ?></div>
                                </td>
                                <td><span class="badge-pill <?= $hariClass ?>"><?= $hariLabel ?></span></td>
                                <td style="font-size:0.8rem; font-weight:600;">
                                    <span class="material-symbols-outlined align-bottom"
                                        style="font-size:1rem; color:var(--admin-secondary);">schedule</span>
                                    <?= $jamMulai ?> - <?= $jamSelesai ?>
                                </td>
                                <td class="td-price"><?= $hargaUmum ?></td>
                                <td class="td-price" style="color:#059669;"><?= $hargaMember ?></td>
                                <td style="text-align:center;">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button class="action-btn edit" title="Edit"
                                            onclick="openEditModal(<?= $tarif['id_tarif'] ?>, '<?= esc($tarif['nama_tarif']) ?>', <?= $tarif['id_lapang'] ?>, '<?= esc($tarif['hari']) ?>', '<?= esc($tarif['jam_mulai']) ?>', '<?= esc($tarif['jam_selesai']) ?>', <?= $tarif['harga_umum'] ?>, <?= $tarif['harga_member'] ?>)">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                        <button class="action-btn delete" title="Hapus"
                                            onclick="openDeleteModal(<?= $tarif['id_tarif'] ?>, '<?= esc($tarif['nama_tarif']) ?>')">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align:center; padding:3rem 1rem;">
                                <span class="material-symbols-outlined"
                                    style="font-size:2.5rem; color:var(--admin-outline); display:block; margin-bottom:0.5rem;">payments</span>
                                <p style="color:var(--admin-secondary); font-size:0.85rem; margin:0;">Belum ada data
                                    tarif</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($tarifs)): ?>
            <div class="table-footer">
                <span class="table-footer__info">Menampilkan <?= count($tarifs) ?> data</span>
            </div>
        <?php endif; ?>
    </div>

</main>

<!-- ===== MODAL: TAMBAH / EDIT TARIF (shared modal) ===== -->
<div class="modal fade" id="tambahTarifModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tarifModalLabel">
                    <span class="material-symbols-outlined">payments</span> Setelan Harga Dinamis
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTarif" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_tarif" id="formIdTarif" />
                <div class="modal-body" style="background:#f8fafc;">
                    <div class="mb-3">
                        <label class="form-label-custom"><span class="material-symbols-outlined">title</span> Nama
                            Tarif</label>
                        <input type="text" name="nama_tarif" id="formNamaTarif" class="form-control-custom"
                            placeholder="Contoh: Pagi Weekday Futsal" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom"><span class="material-symbols-outlined">domain</span> Berlaku
                            Untuk (Lapangan)</label>
                        <select name="id_lapang" id="formIdLapang" class="form-control-custom" required>
                            <option value="" disabled selected>Pilih lapangan...</option>
                            <?php if (!empty($lapangs)): ?>
                                <?php foreach ($lapangs as $lapang): ?>
                                    <option value="<?= $lapang['id_lapang'] ?>"><?= esc($lapang['nama_lapangan']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-custom"><span
                                    class="material-symbols-outlined">calendar_month</span> Kategori Hari</label>
                            <select name="hari" id="formHari" class="form-control-custom" required>
                                <option value="Weekday">Senin - Jumat (Weekday)</option>
                                <option value="Weekend">Sabtu - Minggu (Weekend)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-custom" style="justify-content:center;"><span
                                    class="material-symbols-outlined">schedule</span> Jam Mulai</label>
                            <input type="time" name="jam_mulai" id="formJamMulai"
                                class="form-control-custom text-center" value="08:00" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-custom" style="justify-content:center;"><span
                                    class="material-symbols-outlined">schedule</span> Jam Selesai</label>
                            <input type="time" name="jam_selesai" id="formJamSelesai"
                                class="form-control-custom text-center" value="16:00" required>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-custom"><span class="material-symbols-outlined">sell</span> Harga
                                Umum / Jam</label>
                            <div class="price-input-wrap">
                                <span class="prefix">Rp</span>
                                <input type="number" name="harga_umum" id="formHargaUmum" class="form-control-custom"
                                    placeholder="Nominal angka" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom" style="color:#059669;">
                                <span class="material-symbols-outlined" style="color:#059669;">workspace_premium</span>
                                Harga Member / Jam
                            </label>
                            <div class="price-input-wrap">
                                <span class="prefix" style="color:#059669;">Rp</span>
                                <input type="number" name="harga_member" id="formHargaMember"
                                    class="form-control-custom" style="border-color:#a7f3d0; background:#f0fdf4;"
                                    placeholder="Nominal diskon" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background:#fff;">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">
                        <span class="material-symbols-outlined">save</span> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== MODAL: HAPUS TARIF ===== -->
<div class="modal fade" id="deleteTarifModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color:#fecaca;">
                <h5 class="modal-title">
                    <span class="material-symbols-outlined" style="color:#dc2626;">warning</span>
                    Hapus Tarif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/admin/tarif/delete') ?>" method="post" id="formDeleteTarif">
                <?= csrf_field() ?>
                <input type="hidden" name="id_tarif" id="deleteIdTarif" />
                <div class="modal-body" style="text-align:center; padding:1.5rem;">
                    <div
                        style="width:3.5rem;height:3.5rem;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <span class="material-symbols-outlined" style="font-size:1.75rem;color:#dc2626;">payments</span>
                    </div>
                    <p style="font-size:0.88rem;font-weight:600;color:var(--admin-on-surface);margin-bottom:0.35rem;">
                        Yakin ingin menghapus tarif ini?
                    </p>
                    <p id="deleteTarifName" style="font-size:0.78rem;color:var(--admin-secondary);margin-bottom:0;">
                    </p>
                    <p style="font-size:0.72rem;color:var(--admin-outline);margin-top:0.5rem;margin-bottom:0;">
                        Data yang dihapus tidak dapat dikembalikan.
                    </p>
                </div>
                <div class="modal-footer" style="justify-content:center;border-top-color:#fecaca;">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn-modal-save"
                        style="background:linear-gradient(135deg,#dc2626,#ef4444);box-shadow:0 4px 12px -2px rgba(220,38,38,0.3);">
                        <span class="material-symbols-outlined">delete</span> Ya
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const SAVE_URL = '<?= base_url("/admin/tarif/save") ?>';
    const UPDATE_URL = '<?= base_url("/admin/tarif/update") ?>';

    // Open modal for adding new tarif
    function openAddModal() {
        document.getElementById('tarifModalLabel').innerHTML =
            '<span class="material-symbols-outlined">payments</span> Tambah Tarif Baru';
        document.getElementById('formTarif').action = SAVE_URL;
        document.getElementById('formIdTarif').value = '';
        document.getElementById('formNamaTarif').value = '';
        document.getElementById('formIdLapang').value = '';
        document.getElementById('formHari').value = 'Weekday';
        document.getElementById('formJamMulai').value = '08:00';
        document.getElementById('formJamSelesai').value = '16:00';
        document.getElementById('formHargaUmum').value = '';
        document.getElementById('formHargaMember').value = '';
        new bootstrap.Modal(document.getElementById('tambahTarifModal')).show();
    }

    // Open modal for editing existing tarif
    function openEditModal(id, nama, idLapang, hari, jamMulai, jamSelesai, hargaUmum, hargaMember) {
        document.getElementById('tarifModalLabel').innerHTML =
            '<span class="material-symbols-outlined">edit</span> Edit Tarif';
        document.getElementById('formTarif').action = UPDATE_URL;
        document.getElementById('formIdTarif').value = id;
        document.getElementById('formNamaTarif').value = nama;
        document.getElementById('formIdLapang').value = idLapang;
        document.getElementById('formHari').value = hari;
        document.getElementById('formJamMulai').value = jamMulai.substring(0, 5);
        document.getElementById('formJamSelesai').value = jamSelesai.substring(0, 5);
        document.getElementById('formHargaUmum').value = Math.round(hargaUmum);
        document.getElementById('formHargaMember').value = Math.round(hargaMember);
        new bootstrap.Modal(document.getElementById('tambahTarifModal')).show();
    }

    // Open delete confirmation modal
    function openDeleteModal(id, nama) {
        document.getElementById('deleteIdTarif').value = id;
        document.getElementById('deleteTarifName').textContent = '"' + nama + '"';
        new bootstrap.Modal(document.getElementById('deleteTarifModal')).show();
    }

    // Search table
    function searchTable() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#tarifTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }

    // Filter by hari
    function filterHari(hari) {
        const rows = document.querySelectorAll('#tarifTable tbody tr');
        rows.forEach(row => {
            if (hari === 'all') {
                row.style.display = '';
            } else {
                row.style.display = row.dataset.hari === hari ? '' : 'none';
            }
        });

        // Update active button styling
        document.querySelectorAll('.table-filter-btn').forEach(btn => {
            btn.classList.remove('filter-active');
        });
        const activeBtn = hari === 'all' ? document.getElementById('filterAll') :
            hari === 'Weekday' ? document.getElementById('filterWeekday') :
                document.getElementById('filterWeekend');
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