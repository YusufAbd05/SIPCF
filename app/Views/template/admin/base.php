<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $this->renderSection('title') ?> — Atrium Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <style>
        /* ===== DESIGN TOKENS ===== */
        :root {
            --admin-primary: #0057cd;
            --admin-primary-container: #0d6efd;
            --admin-primary-fixed: #dae2ff;
            --admin-primary-fixed-dim: #b1c5ff;
            --admin-on-primary: #ffffff;

            --admin-surface: #f7f9fb;
            --admin-surface-low: #f2f4f6;
            --admin-surface-container: #eceef0;
            --admin-surface-high: #e6e8ea;
            --admin-surface-highest: #e0e3e5;
            --admin-surface-lowest: #ffffff;

            --admin-on-surface: #191c1e;
            --admin-on-surface-variant: #424655;
            --admin-secondary: #515f74;
            --admin-outline: #727787;
            --admin-outline-variant: #c2c6d8;

            --admin-error: #ba1a1a;
            --admin-error-container: #ffdad6;

            --admin-sidebar-width: 260px;
        }

        /* ===== BASE ===== */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-surface);
            color: var(--admin-on-surface);
        }

        ::selection {
            background-color: var(--admin-primary-fixed);
            color: #001946;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* ===== LAYOUT ===== */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        /* ===== SIDEBAR ===== */
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            position: sticky;
            top: 0;
            height: 100vh;
            background: #f8fafc;
            border-right: none;
            padding: 1.25rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            overflow-y: auto;
            flex-shrink: 0;
            z-index: 1040;
        }

        .sidebar-brand {
            padding: 0 1rem;
            margin-bottom: 2rem;
        }

        .sidebar-brand h1 {
            font-size: 1.125rem;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 0;
        }

        .sidebar-brand p {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #94a3b8;
            font-weight: 500;
            margin-bottom: 0;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            color: #64748b;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            color: #0f172a;
            background: rgba(148, 163, 184, 0.12);
        }

        .sidebar-link.active {
            background: #ffffff;
            color: var(--admin-primary-container);
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .sidebar-link .material-symbols-outlined {
            font-size: 1.3rem;
        }

        /* ===== TOP HEADER ===== */
        .admin-header {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            padding: 0.75rem 1.5rem;
        }

        .header-search {
            display: flex;
            align-items: center;
            background: var(--admin-surface-low);
            border-radius: 9999px;
            padding: 0.375rem 1rem;
            border: 1px solid rgba(194, 198, 216, 0.1);
        }

        .header-search input {
            border: none;
            background: transparent;
            font-size: 0.875rem;
            width: 16rem;
            outline: none;
        }

        .header-search input::placeholder {
            color: rgba(81, 95, 116, 0.5);
        }

        .header-search .material-symbols-outlined {
            font-size: 1.1rem;
            color: var(--admin-secondary);
            margin-right: 0.5rem;
        }

        .header-icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            transition: background 0.2s;
        }

        .header-icon-btn:hover {
            background: #f1f5f9;
        }

        .header-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            object-fit: cover;
        }

        .header-divider {
            height: 1.5rem;
            width: 1px;
            background: rgba(194, 198, 216, 0.2);
            margin: 0 0.5rem;
        }

        /* ===== WELCOME BANNER ===== */
        .welcome-banner {
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-container) 100%);
            border-radius: 0.75rem;
            padding: 2rem;
            color: var(--admin-on-primary);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 87, 205, 0.15);
        }

        .welcome-banner h2 {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .welcome-banner p {
            color: rgba(218, 226, 255, 0.8);
            font-weight: 500;
            line-height: 1.6;
            max-width: 36rem;
        }

        .welcome-banner .glow {
            position: absolute;
            right: -50px;
            top: -50px;
            width: 16rem;
            height: 16rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(48px);
        }

        .btn-welcome-primary {
            background: var(--admin-surface-lowest);
            color: var(--admin-primary);
            font-weight: 700;
            font-size: 0.875rem;
            padding: 0.625rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.15s;
        }

        .btn-welcome-primary:hover {
            color: var(--admin-primary);
        }

        .btn-welcome-primary:active {
            transform: scale(0.95);
        }

        .btn-welcome-ghost {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.625rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            backdrop-filter: blur(8px);
            transition: background 0.2s;
        }

        .btn-welcome-ghost:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        /* ===== METRIC CARDS ===== */
        .metric-card {
            background: var(--admin-surface-lowest);
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 1px solid rgba(194, 198, 216, 0.05);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            transition: box-shadow 0.25s ease;
        }

        .metric-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        }

        .metric-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
        }

        .metric-card:hover .metric-icon {
            transform: scale(1.1);
        }

        .metric-icon.blue { background: #eff6ff; color: #2563eb; }
        .metric-icon.green { background: #ecfdf5; color: #059669; }
        .metric-icon.amber { background: #fffbeb; color: #d97706; }
        .metric-icon.indigo { background: #eef2ff; color: #4f46e5; }

        .metric-badge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.2rem 0.625rem;
            border-radius: 9999px;
        }

        .metric-badge.up { background: #ecfdf5; color: #059669; }
        .metric-badge.down { background: #fffbeb; color: #d97706; }

        .metric-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.12em;
            color: var(--admin-secondary);
            margin-bottom: 0.2rem;
        }

        .metric-value {
            font-size: 1.75rem;
            font-weight: 900;
            color: var(--admin-on-surface);
            line-height: 1.1;
        }

        /* ===== CONTENT CARDS ===== */
        .content-card {
            background: var(--admin-surface-lowest);
            border-radius: 0.75rem;
            padding: 2rem;
            border: 1px solid rgba(194, 198, 216, 0.05);
        }

        .content-card__title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--admin-on-surface);
            margin-bottom: 0.25rem;
        }

        .content-card__subtitle {
            font-size: 0.875rem;
            color: var(--admin-secondary);
        }

        /* Tab pills */
        .tab-pills {
            display: flex;
            background: var(--admin-surface-low);
            padding: 0.25rem;
            border-radius: 0.5rem;
        }

        .tab-pill {
            padding: 0.375rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            border: none;
            border-radius: 0.375rem;
            background: transparent;
            color: var(--admin-secondary);
            cursor: pointer;
            transition: all 0.2s;
        }

        .tab-pill.active {
            background: #fff;
            color: var(--admin-primary);
            box-shadow: 0 1px 2px rgba(0,0,0,0.06);
        }

        /* Chart placeholder */
        .chart-placeholder {
            width: 100%;
            height: 20rem;
            background: #f8fafc;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .chart-bars {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 0 1rem 1rem;
            opacity: 0.1;
        }

        .chart-bar {
            width: 0.75rem;
            background: var(--admin-primary);
            border-radius: 0.125rem 0.125rem 0 0;
        }

        /* Activity rows */
        .activity-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .activity-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            object-fit: cover;
            background: var(--admin-surface-high);
            flex-shrink: 0;
        }

        .activity-name {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--admin-on-surface);
            margin-bottom: 0;
        }

        .activity-desc {
            font-size: 0.75rem;
            color: var(--admin-secondary);
            margin-bottom: 0;
        }

        .activity-time {
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--admin-secondary);
            white-space: nowrap;
        }

        .btn-view-all {
            width: 100%;
            padding: 0.625rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--admin-primary);
            background: rgba(0, 87, 205, 0.05);
            border: none;
            border-radius: 0.5rem;
            transition: background 0.2s;
            cursor: pointer;
        }

        .btn-view-all:hover {
            background: rgba(0, 87, 205, 0.1);
        }

        /* ===== ADMIN FOOTER ===== */
        .admin-footer {
            background: #fff;
            border-top: 1px solid #f1f5f9;
            padding: 1.5rem 2rem;
            margin-top: auto;
        }

        .admin-footer p,
        .admin-footer a {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
        }

        .admin-footer a {
            text-decoration: none;
            transition: color 0.2s;
        }

        .admin-footer a:hover {
            color: #475569;
            text-decoration: underline;
            text-decoration-color: var(--admin-primary-container);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 767.98px) {
            .admin-sidebar {
                display: none;
            }

            .admin-header .header-search {
                display: none;
            }

            .welcome-banner {
                padding: 1.5rem;
            }

            .welcome-banner h2 {
                font-size: 1.35rem;
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .animate-in {
            animation: fadeInUp 0.45s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
    </style>
</head>

<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <?= $this->include('template/admin/sidebar') ?>

        <!-- Main Content -->
        <div class="admin-content">
            <!-- Header -->
            <?= $this->include('template/admin/header') ?>

            <!-- Page Content -->
            <?= $this->renderSection('content') ?>

            <!-- Footer -->
            <?= $this->include('template/admin/footer') ?>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
