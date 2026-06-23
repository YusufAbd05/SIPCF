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
                        <th style="text-align:center;">Jenis Sewa</th>
                        <th>Harga</th>
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
                            $isHarian = ($tarif['harga_harian'] > 0);
                            $jenisSewa = $isHarian ? 'Harian' : 'Umum';
                            $harga = $isHarian ? ($tarif['harga_harian'] ?? 0) : $tarif['harga_umum'];
                            $hargaFormat = 'Rp ' . number_format($harga, 0, ',', '.');
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
                                <td style="text-align:center;">
                                    <span class="badge-pill" style="background:var(--admin-surface); border:1px solid var(--admin-outline); color:var(--admin-on-surface);"><?= $jenisSewa ?></span>
                                </td>
                                <td class="td-price" <?= $isHarian ? 'style="color:#059669;"' : '' ?>><?= $hargaFormat ?></td>
                                <td style="text-align:center;">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button class="action-btn edit" title="Edit"
                                            onclick="openEditModal(<?= $tarif['id_tarif'] ?>, '<?= esc($tarif['nama_tarif']) ?>', <?= $tarif['id_lapang'] ?>, '<?= esc($tarif['hari']) ?>', '<?= esc($tarif['jam_mulai']) ?>', '<?= esc($tarif['jam_selesai']) ?>', '<?= $jenisSewa ?>', <?= $harga ?>)">
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
                                    <option value="<?= $lapang['id_lapang'] ?>"
                                        data-buka-weekday="<?= esc($lapang['jam_buka_weekday'] ?? '08:00') ?>"
                                        data-tutup-weekday="<?= esc($lapang['jam_tutup_weekday'] ?? '22:00') ?>"
                                        data-buka-weekend="<?= esc($lapang['jam_buka_weekend'] ?? '08:00') ?>"
                                        data-tutup-weekend="<?= esc($lapang['jam_tutup_weekend'] ?? '22:00') ?>">
                                        <?= esc($lapang['nama_lapangan']) ?>
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
                            <label class="form-label-custom"><span class="material-symbols-outlined">category</span> Jenis Sewa</label>
                            <select name="jenis_sewa" id="formJenisSewa" class="form-control-custom" required>
                                <option value="Umum">Umum (Per Jam)</option>
                                <option value="Harian">Harian (Per Hari)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom"><span class="material-symbols-outlined">sell</span> Harga</label>
                            <div class="price-input-wrap">
                                <span class="prefix">Rp</span>
                                <input type="number" name="harga" id="formHarga" class="form-control-custom"
                                    placeholder="Nominal harga" required>
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
        document.getElementById('formJenisSewa').value = 'Umum';
        document.getElementById('formHarga').value = '';
        applyJamHarian();
        new bootstrap.Modal(document.getElementById('tambahTarifModal')).show();
    }

    // Open modal for editing existing tarif
    function openEditModal(id, nama, idLapang, hari, jamMulai, jamSelesai, jenisSewa, harga) {
        document.getElementById('tarifModalLabel').innerHTML =
            '<span class="material-symbols-outlined">edit</span> Edit Tarif';
        document.getElementById('formTarif').action = UPDATE_URL;
        document.getElementById('formIdTarif').value = id;
        document.getElementById('formNamaTarif').value = nama;
        document.getElementById('formIdLapang').value = idLapang;
        document.getElementById('formHari').value = hari;
        document.getElementById('formJamMulai').value = jamMulai.substring(0, 5);
        document.getElementById('formJamSelesai').value = jamSelesai.substring(0, 5);
        document.getElementById('formJenisSewa').value = jenisSewa;
        document.getElementById('formHarga').value = Math.round(harga);
        applyJamHarian();
        new bootstrap.Modal(document.getElementById('tambahTarifModal')).show();
    }

    // Open delete confirmation modal
    function openDeleteModal(id, nama) {
        document.getElementById('deleteIdTarif').value = id;
        document.getElementById('deleteTarifName').textContent = '"' + nama + '"';
        new bootstrap.Modal(document.getElementById('deleteTarifModal')).show();
    }

    let tarifPaginator;
    let currentHariFilter = 'all';

    function runFilters() {
        if(!tarifPaginator) return;
        const query = document.getElementById('searchInput').value.toLowerCase();
        tarifPaginator.applyFilter((row) => {
            const text = row.textContent.toLowerCase();
            const matchesSearch = text.includes(query);
            const matchesHari = (currentHariFilter === 'all') || (row.dataset.hari === currentHariFilter);
            return matchesSearch && matchesHari;
        });
    }

    // Search table
    function searchTable() {
        runFilters();
    }

    // Filter by hari
    function filterHari(hari) {
        currentHariFilter = hari;

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

        runFilters();
    }

    // Handle auto fill jam untuk jenis sewa harian
    function applyJamHarian() {
        const jenisSewa = document.getElementById('formJenisSewa').value;
        const jamMulai = document.getElementById('formJamMulai');
        const jamSelesai = document.getElementById('formJamSelesai');
        
        if (jenisSewa === 'Harian') {
            const lapangSelect = document.getElementById('formIdLapang');
            const hariSelect = document.getElementById('formHari');
            const selectedOption = lapangSelect.options[lapangSelect.selectedIndex];
            
            if (selectedOption && selectedOption.value) {
                const isWeekend = (hariSelect.value === 'Weekend');
                const buka = isWeekend ? selectedOption.getAttribute('data-buka-weekend') : selectedOption.getAttribute('data-buka-weekday');
                const tutup = isWeekend ? selectedOption.getAttribute('data-tutup-weekend') : selectedOption.getAttribute('data-tutup-weekday');
                
                if (buka) jamMulai.value = buka.substring(0, 5);
                if (tutup) jamSelesai.value = tutup.substring(0, 5);
            }
            
            jamMulai.setAttribute('readonly', 'true');
            jamSelesai.setAttribute('readonly', 'true');
        } else {
            jamMulai.removeAttribute('readonly');
            jamSelesai.removeAttribute('readonly');
        }
    }

    // Auto-dismiss flash message and set event listeners
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('formJenisSewa').addEventListener('change', applyJamHarian);
        document.getElementById('formIdLapang').addEventListener('change', applyJamHarian);
        document.getElementById('formHari').addEventListener('change', applyJamHarian);

        const toast = document.getElementById('alertToast');
        if (toast) {
            setTimeout(() => {
                toast.style.transition = 'opacity 0.5s, transform 0.5s';
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        // Initialize Custom Paginator
        if (typeof CustomPaginator !== 'undefined') {
            tarifPaginator = new CustomPaginator('#tarifTable tbody', 10);
        }

        // Set "Semua" filter as active by default
        document.getElementById('filterAll').classList.add('filter-active');
    });
</script>

<?= $this->endSection() ?>