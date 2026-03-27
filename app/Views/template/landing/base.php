<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $this->renderSection('title') ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <style>
        /* ===== CSS VARIABLES / DESIGN TOKENS ===== */
        :root {
            --primary: #0057cd;
            --primary-container: #0d6efd;
            --primary-fixed: #dae2ff;
            --primary-fixed-dim: #b1c5ff;
            --on-primary: #ffffff;
            --on-primary-fixed: #001946;
            --on-primary-fixed-variant: #00419e;

            --secondary: #575f67;
            --secondary-container: #d8e1ea;
            --secondary-fixed: #dbe4ed;
            --secondary-fixed-dim: #bfc8d0;
            --on-secondary: #ffffff;
            --on-secondary-container: #5b646b;
            --on-secondary-fixed: #141d23;
            --on-secondary-fixed-variant: #3f484f;

            --tertiary: #006c40;
            --tertiary-container: #198754;
            --tertiary-fixed: #93f7ba;
            --tertiary-fixed-dim: #77da9f;
            --on-tertiary: #ffffff;
            --on-tertiary-container: #ffffff;
            --on-tertiary-fixed: #002110;
            --on-tertiary-fixed-variant: #00522f;

            --error: #ba1a1a;
            --error-container: #ffdad6;
            --on-error: #ffffff;
            --on-error-container: #93000a;

            --background: #f8f9fa;
            --surface: #f8f9fa;
            --surface-dim: #d9dadb;
            --surface-bright: #f8f9fa;
            --surface-container-lowest: #ffffff;
            --surface-container-low: #f3f4f5;
            --surface-container: #edeeef;
            --surface-container-high: #e7e8e9;
            --surface-container-highest: #e1e3e4;
            --surface-variant: #e1e3e4;
            --surface-tint: #0057ce;

            --on-background: #191c1d;
            --on-surface: #191c1d;
            --on-surface-variant: #424655;

            --outline: #727787;
            --outline-variant: #c2c6d8;

            --inverse-surface: #2e3132;
            --inverse-on-surface: #f0f1f2;
            --inverse-primary: #b1c5ff;
        }

        /* ===== BASE STYLES ===== */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--on-surface);
        }

        ::selection {
            background-color: var(--primary-fixed);
            color: var(--on-primary-fixed);
        }

        .font-headline {
            font-family: 'Inter', sans-serif;
        }

        .font-label {
            font-family: 'Public Sans', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* ===== GRADIENTS & EFFECTS ===== */
        .bg-primary-gradient {
            background: linear-gradient(135deg, #0057cd 0%, #0d6efd 100%);
        }

        .btn-primary-gradient {
            background: linear-gradient(135deg, #0057cd 0%, #0d6efd 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary-gradient:hover {
            opacity: 0.9;
            color: #fff;
        }

        .btn-primary-gradient:active {
            transform: scale(0.95);
        }

        .btn-outline-custom {
            border: 1px solid rgba(194, 198, 216, 0.3);
            color: var(--on-surface);
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-outline-custom:hover {
            background-color: var(--surface-container-low);
        }

        .btn-outline-custom:active {
            transform: scale(0.95);
        }

        /* ===== NAVBAR ===== */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }

        .nav-link-custom {
            color: #475569;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 0.875rem;
            letter-spacing: -0.01em;
            transition: color 0.2s ease;
            padding: 0.25rem 0 !important;
        }

        .nav-link-custom:hover {
            color: #2563eb;
        }

        .nav-link-custom.active {
            color: #1d4ed8;
            font-weight: 600;
            border-bottom: 2px solid #1d4ed8;
        }

        /* ===== HERO ===== */
        .hero-section {
            padding-top: 8rem;
            padding-bottom: 5rem;
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw + 1rem, 4.5rem);
            font-weight: 800;
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.04em;
            line-height: 1.1;
            color: var(--on-surface);
        }

        .hero-title .text-primary-custom {
            color: var(--primary);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--on-surface-variant);
            line-height: 1.7;
            max-width: 32rem;
        }

        .hero-image-wrapper {
            position: relative;
        }

        .hero-image-glow {
            position: absolute;
            inset: -1rem;
            background: rgba(218, 226, 255, 0.3);
            border-radius: 2rem;
            filter: blur(40px);
            transition: background 0.3s ease;
        }

        .hero-image-wrapper:hover .hero-image-glow {
            background: rgba(218, 226, 255, 0.4);
        }

        .hero-image-card {
            position: relative;
            overflow: hidden;
            border-radius: 2rem;
            aspect-ratio: 4 / 3;
            background: var(--surface-container);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .hero-image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ===== FEATURES ===== */
        .features-section {
            background-color: var(--surface-container-low);
            padding: 6rem 0;
        }

        .feature-card {
            background: var(--surface-container-lowest);
            border-radius: 1rem;
            padding: 2rem;
            transition: all 0.3s ease;
            border: none;
        }

        .feature-card:hover {
            box-shadow: 0 0 32px 0 rgba(25, 28, 29, 0.06);
        }

        .feature-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-icon.primary {
            background-color: var(--primary-fixed);
            color: var(--primary);
        }

        .feature-icon.tertiary {
            background-color: var(--tertiary-fixed);
            color: var(--tertiary);
        }

        .feature-icon.secondary {
            background-color: var(--secondary-fixed);
            color: var(--secondary);
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: var(--on-surface);
        }

        .feature-desc {
            color: var(--on-surface-variant);
            line-height: 1.7;
        }

        /* ===== INTERACTIVE PREVIEW ===== */
        .preview-section {
            padding: 8rem 0;
        }

        .section-label {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--primary);
            font-weight: 600;
        }

        .section-title {
            font-size: 2.25rem;
            font-weight: 800;
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.02em;
            color: var(--on-surface);
        }

        .preview-container {
            background: var(--surface-container);
            border-radius: 2rem;
            padding: 2rem;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        @media (min-width: 768px) {
            .preview-container {
                padding: 2rem;
            }
        }

        /* Sidebar */
        .preview-sidebar {
            min-width: 280px;
        }

        .calendar-card {
            background: var(--surface-container-lowest);
            border-radius: 1rem;
            padding: 1.5rem;
        }

        .calendar-header {
            font-weight: 700;
            font-size: 1.125rem;
            font-family: 'Inter', sans-serif;
        }

        .calendar-nav {
            cursor: pointer;
            color: var(--on-surface-variant);
            transition: color 0.2s;
        }

        .calendar-nav:hover {
            color: var(--primary);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.75rem 0;
            text-align: center;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.625rem;
            font-weight: 700;
            color: var(--on-surface-variant);
        }

        .calendar-day-active {
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .calendar-day-muted {
            color: var(--outline);
        }

        .info-badge {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: var(--surface-container-highest);
            border-radius: 0.75rem;
        }

        .info-badge .material-symbols-outlined {
            color: var(--primary);
        }

        .info-badge span:last-child {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Main View */
        .preview-main {
            background: var(--surface-container-lowest);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .slots-title {
            font-size: 1.875rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.02em;
        }

        .slots-date {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.875rem;
            color: var(--on-surface-variant);
        }

        .filter-btn {
            border: 1px solid rgba(194, 198, 216, 0.4);
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 700;
            background: transparent;
            transition: background 0.2s;
        }

        .filter-btn:hover {
            background: var(--surface-container);
        }

        /* Slot Cards */
        .slot-card {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            gap: 1rem;
        }

        .slot-card-available {
            background: var(--surface-container-low);
            cursor: pointer;
        }

        .slot-card-available:hover {
            background: var(--surface-container-lowest);
            box-shadow: 0 0 32px 0 rgba(25, 28, 29, 0.06);
        }

        .slot-card-booked {
            background: var(--surface-container-highest);
            opacity: 0.6;
        }

        .slot-time {
            font-family: 'Public Sans', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--on-surface);
        }

        .slot-time-suffix {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--on-surface-variant);
        }

        .slot-divider {
            height: 2.5rem;
            width: 1px;
            background: rgba(194, 198, 216, 0.3);
        }

        .slot-title {
            font-weight: 700;
            font-family: 'Inter', sans-serif;
        }

        .slot-meta {
            font-size: 0.75rem;
            color: var(--on-surface-variant);
            font-family: 'Public Sans', sans-serif;
        }

        .badge-available {
            background: var(--tertiary-fixed);
            color: var(--on-tertiary-fixed);
            font-family: 'Public Sans', sans-serif;
            font-size: 0.625rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
        }

        .badge-booked {
            background: var(--secondary-container);
            color: var(--on-secondary-fixed-variant);
            font-family: 'Public Sans', sans-serif;
            font-size: 0.625rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
        }

        .slot-arrow {
            color: var(--on-surface-variant);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .slot-card-available:hover .slot-arrow {
            opacity: 1;
        }

        /* ===== CTA SECTION ===== */
        .cta-section {
            padding: 6rem 0;
        }

        .cta-card {
            border-radius: 2.5rem;
            background: #0f172a;
            overflow: hidden;
            position: relative;
            padding: 3rem;
            text-align: center;
        }

        @media (min-width: 768px) {
            .cta-card {
                padding: 6rem;
            }
        }

        .cta-bg {
            position: absolute;
            inset: 0;
            opacity: 0.2;
            background-size: cover;
            background-position: center;
        }

        .cta-title {
            font-size: clamp(2rem, 4vw + 0.5rem, 3.75rem);
            font-weight: 800;
            font-family: 'Inter', sans-serif;
            color: #fff;
            letter-spacing: -0.04em;
        }

        .cta-subtitle {
            color: #94a3b8;
            font-size: 1.25rem;
            max-width: 40rem;
            margin: 0 auto;
        }

        .cta-btn {
            background: linear-gradient(135deg, #0057cd, #0d6efd);
            color: #fff;
            border: none;
            padding: 1.25rem 3rem;
            border-radius: 0.75rem;
            font-size: 1.125rem;
            font-weight: 700;
            box-shadow: 0 25px 50px -12px rgba(0, 87, 205, 0.4);
            transition: all 0.2s ease;
        }

        .cta-btn:hover {
            transform: scale(1.05);
            color: #fff;
        }

        .cta-btn:active {
            transform: scale(0.95);
        }

        /* ===== FOOTER ===== */
        .footer-custom {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 3rem 0;
            margin-top: 5rem;
        }

        .footer-brand {
            font-size: 1.125rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: #0f172a;
        }

        .footer-copy {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
        }

        .footer-links a {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            text-decoration: underline;
            text-decoration-color: rgba(59, 130, 246, 0.3);
            text-underline-offset: 4px;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: #0f172a;
        }

        /* ===== UTILITIES ===== */
        .rounded-2xl {
            border-radius: 1rem;
        }

        .rounded-3xl {
            border-radius: 1.5rem;
        }

        /* Shadow on button */
        .shadow-primary {
            box-shadow: 0 10px 40px -10px rgba(0, 87, 205, 0.2);
        }
    </style>
</head>

<body>

    <!-- Nav -->
    <?= $this->include('template/landing/nav'); ?>

    <!-- Content -->
    <?= $this->renderSection('content') ?>

    <!-- Footer -->
    <?= $this->include('template/landing/foot') ?>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>