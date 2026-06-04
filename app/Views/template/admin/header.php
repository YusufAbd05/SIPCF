<header class="admin-header">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div class="d-flex align-items-center gap-4">
            <!-- Mobile brand -->
            <span class="fw-bold fs-5 d-md-none" style="letter-spacing:-0.03em;">Digital Atrium</span>
            <!-- Search bar -->
            <div class="header-search d-none d-md-flex">
                <strong>Carrera Futsal</strong>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="header-icon-btn">
                <span class="material-symbols-outlined">notifications</span>
            </button>
            <div class="header-divider"></div>
            <!-- User dropdown -->
            <div class="dropdown">
                <button class="d-flex align-items-center gap-2 border-0 bg-transparent p-0" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                    <div style="width:2rem;height:2rem;border-radius:50%;background:linear-gradient(135deg,#0057cd,#0d6efd);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.7rem;font-weight:700;">
                        <?= strtoupper(substr(session()->get('nama') ?? 'A', 0, 1)) ?>
                    </div>
                    <span class="d-none d-md-inline" style="font-size:0.8rem;font-weight:600;color:#0f172a;">
                        <?= esc(session()->get('nama') ?? 'Admin') ?>
                    </span>
                    <span class="material-symbols-outlined d-none d-md-inline" style="font-size:1rem;color:#94a3b8;">expand_more</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="min-width:200px;border:none;border-radius:0.75rem;box-shadow:0 10px 25px -5px rgba(0,0,0,0.12);padding:0.5rem;">
                    <li>
                        <div class="px-3 py-2">
                            <p style="font-size:0.82rem;font-weight:700;margin:0;color:#0f172a;"><?= esc(session()->get('nama') ?? 'Admin') ?></p>
                            <p style="font-size:0.68rem;color:#94a3b8;margin:0;"><?= esc(session()->get('email') ?? '') ?></p>
                            <span style="display:inline-block;margin-top:0.35rem;padding:0.15rem 0.6rem;font-size:0.62rem;font-weight:700;border-radius:999px;background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#1d4ed8;letter-spacing:0.03em;"><?= esc(session()->get('role') ?? 'User') ?></span>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider" style="margin:0.25rem 0;"></li>
                    <li>
                        <a href="#" class="dropdown-item d-flex align-items-center gap-2" style="font-size:0.8rem;font-weight:500;padding:0.5rem 1rem;border-radius:0.5rem;color:#64748b;">
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">person</span>
                            Profil Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" style="margin:0.25rem 0;"></li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center gap-2" style="font-size:0.8rem;font-weight:600;padding:0.5rem 1rem;border-radius:0.5rem;color:#dc2626;"
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <span class="material-symbols-outlined" style="font-size:1.1rem;">logout</span>
                            Logout
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<!-- ===== MODAL: KONFIRMASI LOGOUT ===== -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border:none;border-radius:1rem;overflow:hidden;">
            <div class="modal-body" style="text-align:center;padding:2rem 1.5rem 1.5rem;">
                <div style="width:3.5rem;height:3.5rem;border-radius:50%;background:linear-gradient(135deg,#fef2f2,#fff1f2);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <span class="material-symbols-outlined" style="font-size:1.75rem;color:#dc2626;">logout</span>
                </div>
                <h6 style="font-weight:700;font-size:1rem;margin-bottom:0.35rem;color:#0f172a;">Logout dari sistem?</h6>
                <p style="font-size:0.78rem;color:#64748b;margin-bottom:0;">Anda harus login kembali untuk mengakses panel admin.</p>
            </div>
            <div class="modal-footer" style="justify-content:center;border-top:1px solid #f1f5f9;padding:0.85rem 1.5rem;gap:0.75rem;">
                <button type="button" class="btn" data-bs-dismiss="modal"
                    style="padding:0.5rem 1.25rem;font-size:0.8rem;font-weight:600;border:1.5px solid #c2c6d8;border-radius:0.5rem;color:#424655;background:transparent;">
                    Batal
                </button>
                <a href="<?= base_url('/logout') ?>" class="btn d-flex align-items-center gap-1"
                    style="padding:0.5rem 1.25rem;font-size:0.8rem;font-weight:600;border-radius:0.5rem;background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;border:none;box-shadow:0 4px 12px -2px rgba(220,38,38,0.3);text-decoration:none;">
                    <span class="material-symbols-outlined" style="font-size:1rem;">logout</span>
                    Ya, Logout
                </a>
            </div>
        </div>
    </div>
</div>