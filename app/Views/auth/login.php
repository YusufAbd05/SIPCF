<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login — Atrium Admin</title>
    <meta name="description" content="Login ke panel admin Atrium untuk mengelola booking dan lapangan." />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #0057cd;
            --primary-light: #0d6efd;
            --surface: #f7f9fb;
            --on-surface: #191c1e;
            --secondary: #515f74;
            --outline: #727787;
            --outline-variant: #c2c6d8;
            --error: #dc2626;
            --error-bg: #fef2f2;
            --success: #059669;
            --success-bg: #ecfdf5;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--surface);
            color: var(--on-surface);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* ===== LEFT PANEL (Decorative) ===== */
        .login-hero {
            flex: 0 0 45%;
            max-width: 45%;
            background: linear-gradient(145deg, #0f172a 0%, #1e3a5f 40%, var(--primary) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .login-hero::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,0.03);
            top: -100px;
            right: -150px;
        }

        .login-hero::after {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -80px;
            left: -100px;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 22rem;
        }

        .hero-logo {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 1.25rem;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.75rem;
            border: 1px solid rgba(255,255,255,0.12);
        }

        .hero-logo .material-symbols-outlined {
            font-size: 2.25rem;
            color: #facc15;
        }

        .hero-content h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.03em;
            line-height: 1.2;
            margin-bottom: 0.75rem;
        }

        .hero-content p {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.55);
            line-height: 1.6;
            font-weight: 400;
        }

        .hero-features {
            list-style: none;
            margin-top: 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .hero-features li {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.82rem;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
        }

        .hero-features li .material-symbols-outlined {
            font-size: 1.1rem;
            color: #facc15;
        }

        /* ===== RIGHT PANEL (Form) ===== */
        .login-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
        }

        .login-card__header {
            margin-bottom: 2rem;
        }

        .login-card__header h2 {
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--on-surface);
            margin-bottom: 0.35rem;
        }

        .login-card__header p {
            font-size: 0.85rem;
            color: var(--secondary);
        }

        /* Alert */
        .login-alert {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.75rem 1rem;
            border-radius: 0.625rem;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            animation: fadeIn 0.35s ease;
        }

        .login-alert .material-symbols-outlined { font-size: 1.15rem; }

        .login-alert.error {
            background: var(--error-bg);
            color: var(--error);
            border: 1px solid #fecaca;
        }

        .login-alert.success {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid #a7f3d0;
        }

        /* Form fields */
        .login-field {
            margin-bottom: 1.25rem;
        }

        .login-field label {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--secondary);
            margin-bottom: 0.4rem;
        }

        .login-field label .material-symbols-outlined {
            font-size: 0.9rem;
            color: var(--primary);
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap input {
            width: 100%;
            padding: 0.7rem 0.9rem;
            padding-left: 2.75rem;
            border: 1.5px solid var(--outline-variant);
            border-radius: 0.625rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            color: var(--on-surface);
            background: #fff;
            outline: none;
            transition: all 0.2s;
        }

        .input-wrap input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 87, 205, 0.08);
        }

        .input-wrap input::placeholder {
            color: var(--outline);
        }

        .input-wrap .input-icon {
            position: absolute;
            left: 0.85rem;
            font-size: 1.15rem;
            color: var(--outline);
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-wrap:focus-within .input-icon {
            color: var(--primary);
        }

        .input-wrap .toggle-pw {
            position: absolute;
            right: 0.6rem;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--outline);
            padding: 0.15rem;
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }

        .input-wrap .toggle-pw:hover { color: var(--primary); }
        .input-wrap .toggle-pw .material-symbols-outlined { font-size: 1.15rem; }

        /* Submit */
        .login-btn {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #fff;
            border: none;
            border-radius: 0.625rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 16px -4px rgba(0, 87, 205, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px -6px rgba(0, 87, 205, 0.45);
        }

        .login-btn:active { transform: scale(0.98); }
        .login-btn .material-symbols-outlined { font-size: 1.15rem; }

        /* Footer */
        .login-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.72rem;
            color: var(--outline);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-in {
            animation: fadeIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .login-hero { display: none; }
            .login-form-panel { padding: 1.5rem; }
        }
    </style>
</head>

<body>

    <!-- Left Decorative Panel -->
    <div class="login-hero">
        <div class="hero-content">
            <div class="hero-logo">
                <span class="material-symbols-outlined">stadium</span>
            </div>
            <h1>Atrium Admin</h1>
            <p>Sistem manajemen booking lapangan olahraga terintegrasi untuk pengelolaan yang lebih efisien.</p>
            <ul class="hero-features">
                <li>
                    <span class="material-symbols-outlined">check_circle</span>
                    Kelola booking real-time
                </li>
                <li>
                    <span class="material-symbols-outlined">check_circle</span>
                    Verifikasi pembayaran cepat
                </li>
                <li>
                    <span class="material-symbols-outlined">check_circle</span>
                    Manajemen lapangan terpusat
                </li>
                <li>
                    <span class="material-symbols-outlined">check_circle</span>
                    Laporan & analitik lengkap
                </li>
            </ul>
        </div>
    </div>

    <!-- Right Form Panel -->
    <div class="login-form-panel">
        <div class="login-card animate-in">
            <div class="login-card__header">
                <h2>Masuk ke Admin</h2>
                <p>Masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            <!-- Error Alert -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="login-alert error">
                    <span class="material-symbols-outlined">error</span>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Success Alert -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="login-alert success">
                    <span class="material-symbols-outlined">check_circle</span>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/login') ?>" method="post" id="loginForm">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="login-field">
                    <label for="loginEmail">
                        <span class="material-symbols-outlined">mail</span> Email
                    </label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined input-icon">alternate_email</span>
                        <input type="email" id="loginEmail" name="email" placeholder="admin@atrium.com"
                            value="<?= old('email') ?>" required autofocus />
                    </div>
                </div>

                <!-- Password -->
                <div class="login-field">
                    <label for="loginPassword">
                        <span class="material-symbols-outlined">lock</span> Password
                    </label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined input-icon">key</span>
                        <input type="password" id="loginPassword" name="password" placeholder="Masukkan password" required />
                        <button type="button" class="toggle-pw" onclick="togglePassword()">
                            <span class="material-symbols-outlined" id="pwIcon">visibility_off</span>
                        </button>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="login-btn">
                    <span class="material-symbols-outlined">login</span>
                    Masuk
                </button>
            </form>

            <div class="login-footer">
                © 2026 Digital Atrium. All rights reserved.
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('loginPassword');
            const icon = document.getElementById('pwIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }
    </script>

</body>
</html>
