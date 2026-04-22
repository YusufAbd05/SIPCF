<?= $this->extend('template/admin/base') ?>
<?= $this->section('title') ?>Kelola Lapang<?= $this->endSection() ?>
<?= $this->section('content') ?>

<main class="flex-grow-1 p-3 p-md-5" style="background:var(--admin-surface);">

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
                <p class="stat-chip__value">6</p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon green"><span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="stat-chip__label">Dapat Digunakan</p>
                <p class="stat-chip__value">5</p>
            </div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip__icon amber"><span class="material-symbols-outlined">build</span></div>
            <div>
                <p class="stat-chip__label">Perbaikan</p>
                <p class="stat-chip__value">1</p>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card animate-in" style="animation-delay:.12s;">
        <div class="table-toolbar">
            <div class="table-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" placeholder="Cari nama lapang..." />
            </div>
            <div class="d-flex gap-2">
                <button class="table-filter-btn">
                    <span class="material-symbols-outlined">filter_list</span> Filter Status
                </button>
                <button class="table-filter-btn">
                    <span class="material-symbols-outlined">download</span> Export
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="lapang-table">
                <thead>
                    <tr>
                        <th>Nama Lapang / Spesifikasi</th>
                        <th>Jam Operasional Default</th>
                        <th>Status</th>
                        <th style="text-align:center;">Manajemen</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="td-name text-dark fw-bold">Lapang Futsal A</div>
                            <div class="td-secondary mt-1">Karpet Rumput Sintetis</div>
                        </td>
                        <td>
                            <div class="td-hours">
                                <div class="td-hours-item"><span class="day">Sen-Jum</span> <span class="time">08:00 —
                                        22:00</span></div>
                                <div class="td-hours-item"><span class="day">Sab-Min</span> <span class="time">07:00 —
                                        23:00</span></div>
                            </div>
                        </td>
                        <td><span class="badge-pill dapat-digunakan"><span class="dot"></span>Tersedia</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-2 justify-content-center">
                                <button class="action-btn edit" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editLapangModal">
                                    <span class="material-symbols-outlined">edit</span> Edit Lapangan
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="td-name text-dark fw-bold">Lapang Badminton 1</div>
                            <div class="td-secondary mt-1">Karpet Vinyl (Interlock)</div>
                        </td>
                        <td>
                            <div class="td-hours">
                                <div class="td-hours-item"><span class="day">Sen-Min</span> <span class="time">08:00 —
                                        22:00</span></div>
                            </div>
                        </td>
                        <td><span class="badge-pill dapat-digunakan"><span class="dot"></span>Tersedia</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-2 justify-content-center">
                                <button class="action-btn edit" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editLapangModal">
                                    <span class="material-symbols-outlined">edit</span> Edit Lapangan
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="td-name text-dark fw-bold">Lapang Basket Indoor</div>
                            <div class="td-secondary mt-1">Lantai Beton / Plester</div>
                        </td>
                        <td>
                            <div class="td-hours">
                                <div class="td-hours-item"><span class="day">Sen-Jum</span> <span class="time">08:00 —
                                        22:00</span></div>
                                <div class="td-hours-item"><span class="day">Sab-Min</span> <span class="time">07:00 —
                                        23:00</span></div>
                            </div>
                        </td>
                        <td><span class="badge-pill perbaikan"><span class="dot"></span>Perbaikan</span></td>
                        <td style="text-align:center;">
                            <div class="d-flex gap-2 justify-content-center">
                                <button class="action-btn edit" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editLapangModal">
                                    <span class="material-symbols-outlined">edit</span> Edit Lapangan
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span class="table-footer__info">Menampilkan 1-6 dari 6 data</span>
            <div class="pagination-custom">
                <button class="page-btn"><span class="material-symbols-outlined">chevron_left</span></button>
                <button class="page-btn active">1</button>
                <button class="page-btn"><span class="material-symbols-outlined">chevron_right</span></button>
            </div>
        </div>
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
            <div class="modal-body">
                <form id="formAddLapang">
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
                            <input type="text" class="form-control-custom" placeholder="Contoh: Lapang Futsal A"
                                required />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">layers</span> Spesifikasi Karpet
                            </label>
                            <select class="form-control-custom" required>
                                <option value="" disabled selected>Pilih spesifikasi...</option>
                                <option value="sintetis">Rumput Sintetis</option>
                                <option value="vinyl">Vinyl / Interlock</option>
                                <option value="beton">Beton / Plester</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">flag</span> Status Lapangan
                            </label>
                            <select class="form-control-custom" required>
                                <option value="dapat_digunakan">Tersedia</option>
                                <option value="perbaikan">Perbaikan</option>
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
                            <input type="time" class="hours-input" value="08:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="22:00">
                        </div>
                        <div class="hours-row">
                            <span class="day-label">Sabtu</span>
                            <input type="time" class="hours-input" value="07:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="23:00">
                        </div>
                        <div class="hours-row">
                            <span class="day-label">Minggu</span>
                            <input type="time" class="hours-input" value="07:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="21:00">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-modal-save">
                    <span class="material-symbols-outlined">save</span> Simpan Lapang
                </button>
            </div>
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
            <div class="modal-body">
                <form id="formEditLapang">
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
                            <input type="text" class="form-control-custom" value="Lapang Futsal A" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">layers</span> Spesifikasi Karpet
                            </label>
                            <select class="form-control-custom" required>
                                <option value="" disabled>Pilih spesifikasi...</option>
                                <option value="sintetis" selected>Rumput Sintetis</option>
                                <option value="vinyl">Vinyl / Interlock</option>
                                <option value="beton">Beton / Plester</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">
                                <span class="material-symbols-outlined">flag</span> Status Lapangan
                            </label>
                            <select class="form-control-custom" required>
                                <option value="dapat_digunakan" selected>Tersedia</option>
                                <option value="perbaikan">Perbaikan</option>
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
                            <input type="time" class="hours-input" value="08:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="22:00">
                        </div>
                        <div class="hours-row">
                            <span class="day-label">Sabtu</span>
                            <input type="time" class="hours-input" value="07:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="23:00">
                        </div>
                        <div class="hours-row">
                            <span class="day-label">Minggu</span>
                            <input type="time" class="hours-input" value="07:00">
                            <span class="hours-sep">—</span>
                            <input type="time" class="hours-input" value="21:00">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-modal-save">
                    <span class="material-symbols-outlined">save</span> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>