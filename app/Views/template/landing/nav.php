<!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-md fixed-top navbar-glass py-3">
        <div class="container">
            <a class="navbar-brand fw-bold font-headline fs-5 text-dark" href="<?= base_url('/') ?>" style="letter-spacing:-0.04em;">
                Carrera Futsal
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto gap-4">
                    <li class="nav-item"><a class="nav-link nav-link-custom <?= uri_string() === '' ? 'active' : '' ?>" href="<?= base_url('/') ?>">Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom <?= uri_string() === 'ubah-jadwal' ? 'active' : '' ?>" href="<?= base_url('/ubah-jadwal') ?>">Ubah Jadwal</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
                    <a href="<?= base_url('/login') ?>" class="btn btn-primary-gradient px-4 py-2 rounded-3" style="font-size:.875rem;">Login</a>
                </div>
            </div>
        </div>
    </nav>