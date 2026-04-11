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

        /* ===== SCHEDULE SECTION ===== */
        .schedule-section {
            padding-top: 8rem;
            padding-bottom: 5rem;
            min-height: 100vh;
        }

        /* Section Chip */
        .section-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            background: var(--primary-fixed);
            color: var(--on-primary-fixed-variant);
            font-family: 'Public Sans', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
        }

        .schedule-heading {
            font-size: clamp(2rem, 4vw + 0.5rem, 3rem);
            font-weight: 800;
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.03em;
            line-height: 1.15;
            color: var(--on-surface);
        }

        .schedule-subheading {
            font-size: 1.05rem;
            color: var(--on-surface-variant);
            max-width: 36rem;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        /* ===== FILTER CARD ===== */
        .filter-card {
            max-width: 820px;
            background: var(--surface-container-lowest);
            border: 1px solid var(--outline-variant);
            border-radius: 1.25rem;
            padding: 1.75rem 2rem;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.04),
                0 8px 24px -4px rgba(0, 0, 0, 0.06);
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
            animation-delay: 0.1s;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .filter-label {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--on-surface-variant);
            margin-bottom: 0.5rem;
        }

        .filter-label-icon {
            font-size: 1rem;
            color: var(--primary);
        }

        .filter-input-wrap {
            position: relative;
        }

        .filter-input {
            display: block;
            width: 100%;
            padding: 0.7rem 1rem;
            padding-right: 2.25rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--on-surface);
            background-color: var(--surface-container-low);
            border: 1.5px solid transparent;
            border-radius: 0.75rem;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23727787' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .filter-input-date {
            background-image: none;
            padding-right: 1rem;
        }

        .filter-input:hover {
            background-color: var(--surface-container);
        }

        .filter-input:focus {
            outline: none;
            background-color: var(--surface-container-lowest);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 87, 205, 0.08);
        }

        /* ===== CALENDAR ===== */
        .cal-card {
            max-width: 820px;
            background: var(--surface-container-lowest);
            border: 1px solid var(--outline-variant);
            border-radius: 1.25rem;
            padding: 1.75rem 2rem;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.04),
                0 8px 24px -4px rgba(0, 0, 0, 0.06);
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
            animation-delay: 0.18s;
        }

        .cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .cal-month-label {
            font-family: 'Inter', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            color: var(--on-surface);
        }

        .cal-nav-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.625rem;
            border: 1.5px solid var(--outline-variant);
            background: transparent;
            color: var(--on-surface-variant);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .cal-nav-btn:hover {
            background: var(--surface-container-low);
            border-color: var(--primary-fixed-dim);
            color: var(--primary);
        }

        .cal-nav-btn:active {
            transform: scale(0.92);
        }

        .cal-nav-btn .material-symbols-outlined {
            font-size: 1.25rem;
        }

        /* Grid */
        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0;
        }

        .cal-dow {
            margin-bottom: 0.25rem;
        }

        .cal-dow span {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--on-surface-variant);
        }

        /* Cells */
        .cal-cell {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.2rem;
            padding: 0.45rem 0;
            border-radius: 0.625rem;
            cursor: pointer;
            transition: all 0.15s ease;
            position: relative;
        }

        .cal-cell--empty {
            cursor: default;
        }

        .cal-cell:not(.cal-cell--empty):hover {
            background: var(--surface-container-low);
            transform: scale(1.08);
        }

        .cal-cell__num {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--on-surface);
            line-height: 1;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.15s ease;
        }

        /* Today */
        .cal-cell--today .cal-cell__num {
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 700;
        }

        /* Selected */
        .cal-cell--selected .cal-cell__num {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 87, 205, 0.25);
        }

        /* Availability dots */
        .cal-dot {
            display: block;
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .cal-dot--available {
            background: var(--tertiary);
        }

        .cal-dot--full {
            background: var(--error);
        }

        /* Legend */
        .cal-legend {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1.25rem;
            padding-top: 1rem;
            border-top: 1px solid var(--outline-variant);
        }

        .cal-legend-item {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--on-surface-variant);
        }

        .cal-legend-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .cal-legend-dot--available {
            background: var(--tertiary);
        }

        .cal-legend-dot--full {
            background: var(--error);
        }

        .cal-legend-dot--today {
            border: 2px solid var(--primary);
            width: 10px;
            height: 10px;
            box-sizing: border-box;
        }

        @media (max-width: 767.98px) {
            .cal-card {
                padding: 1.25rem 1rem;
                border-radius: 1rem;
            }

            .cal-cell__num {
                width: 1.75rem;
                height: 1.75rem;
                font-size: 0.75rem;
            }
        }

        /* ===== RESULTS HEADER ===== */
        .results-title {
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.02em;
            color: var(--on-surface);
        }

        .results-subtitle {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.85rem;
            color: var(--on-surface-variant);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .results-count {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--on-surface-variant);
            background: var(--surface-container-low);
            padding: 0.4rem 1rem;
            border-radius: 9999px;
        }

        .results-count-number {
            background: var(--primary);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== SCHEDULE CARDS ===== */
        .schedule-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .schedule-card {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            background: var(--surface-container-lowest);
            border: 1.5px solid var(--outline-variant);
            border-radius: 1rem;
            transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
            animation: slideUp 0.45s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .schedule-card:nth-child(1) {
            animation-delay: 0.15s;
        }

        .schedule-card:nth-child(2) {
            animation-delay: 0.22s;
        }

        .schedule-card:nth-child(3) {
            animation-delay: 0.29s;
        }

        .schedule-card:nth-child(4) {
            animation-delay: 0.36s;
        }

        .schedule-card--available {
            cursor: pointer;
        }

        .schedule-card--available:hover {
            border-color: var(--primary-fixed-dim);
            box-shadow: 0 4px 20px -4px rgba(0, 87, 205, 0.1);
            transform: translateY(-2px);
        }

        .schedule-card--available:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        .schedule-card--booked {
            opacity: 0.55;
            background: var(--surface-container-low);
            border-color: transparent;
        }

        .schedule-card__left {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .schedule-card__time {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 3.5rem;
        }

        .schedule-card__hour {
            font-family: 'Public Sans', sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--on-surface);
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .schedule-card__period {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--on-surface-variant);
            margin-top: 0.15rem;
        }

        .schedule-card__divider {
            width: 1px;
            height: 2.5rem;
            background: var(--outline-variant);
        }

        @media (max-width: 575.98px) {
            .schedule-card__divider {
                display: none;
            }
        }

        .schedule-card__info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .schedule-card__name {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--on-surface);
        }

        .schedule-card__detail {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.75rem;
            color: var(--on-surface-variant);
        }

        .schedule-card__dot {
            display: inline-block;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--outline);
            margin: 0 0.15rem;
        }

        .schedule-card__right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .schedule-card__arrow {
            color: var(--primary);
            opacity: 0;
            transform: translateX(-4px);
            transition: all 0.25s ease;
        }

        .schedule-card--available:hover .schedule-card__arrow {
            opacity: 1;
            transform: translateX(0);
        }

        /* Status Pills */
        .status-pill {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.3rem 0.85rem;
            border-radius: 9999px;
            white-space: nowrap;
        }

        .status-pill--available {
            background: var(--tertiary-fixed);
            color: var(--on-tertiary-fixed);
        }

        .status-pill--booked {
            background: var(--secondary-container);
            color: var(--on-secondary-fixed-variant);
        }

        /* ===== LAPANG CARDS ===== */
        .lapang-card {
            background: var(--surface-container-lowest);
            border: 1.5px solid var(--outline-variant);
            border-radius: 1.25rem;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.04),
                0 8px 24px -4px rgba(0, 0, 0, 0.06);
        }

        .lapang-card:nth-child(1) .lapang-card {
            animation-delay: 0.1s;
        }

        .lapang-card:nth-child(2) .lapang-card {
            animation-delay: 0.2s;
        }

        .lapang-card:nth-child(3) .lapang-card {
            animation-delay: 0.3s;
        }

        .lapang-card:hover {
            border-color: var(--primary-fixed-dim);
            box-shadow: 0 8px 32px -8px rgba(0, 87, 205, 0.12);
            transform: translateY(-3px);
        }

        .lapang-card__header {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 1.15rem 1.25rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-container) 100%);
            color: var(--on-primary);
        }

        .lapang-card__icon {
            font-size: 1.35rem;
            opacity: 0.9;
        }

        .lapang-card__title {
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .lapang-card__body {
            padding: 1rem;
        }

        /* ===== TIMESLOT GRID (2 columns) ===== */
        .timeslot-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .timeslot-box {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.6rem 0.65rem;
            border-radius: 0.625rem;
            border: 1.5px solid var(--outline-variant);
            background: var(--surface-container-low);
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.22, 1, 0.36, 1);
            animation: fadeSlotIn 0.35s cubic-bezier(0.22, 1, 0.36, 1) both;
            user-select: none;
        }

        @keyframes fadeSlotIn {
            from {
                opacity: 0;
                transform: scale(0.92);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .timeslot-box:hover {
            border-color: var(--primary-fixed-dim);
            background: var(--surface-container-lowest);
            box-shadow: 0 2px 8px -2px rgba(0, 87, 205, 0.1);
            transform: translateY(-1px);
        }

        .timeslot-box:active {
            transform: scale(0.96);
        }

        .timeslot-box--selected {
            border-color: var(--primary) !important;
            background: var(--primary-fixed) !important;
            box-shadow: 0 2px 12px -2px rgba(0, 87, 205, 0.18);
        }

        .timeslot-box--selected .timeslot-box__icon {
            color: var(--primary);
        }

        .timeslot-box--selected .timeslot-box__label {
            color: var(--on-primary-fixed);
            font-weight: 700;
        }

        .timeslot-box--booked {
            opacity: 0.45;
            cursor: not-allowed;
            background: var(--surface-container);
            border-color: transparent;
        }

        .timeslot-box--booked:hover {
            transform: none;
            box-shadow: none;
            border-color: transparent;
        }

        .timeslot-box__icon {
            font-size: 0.9rem;
            color: var(--on-surface-variant);
            flex-shrink: 0;
            transition: color 0.2s;
        }

        .timeslot-box__label {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--on-surface);
            white-space: nowrap;
            letter-spacing: 0.01em;
            transition: all 0.2s;
        }

        @media (max-width: 767.98px) {
            .lapang-card__body {
                padding: 0.75rem;
            }

            .timeslot-grid {
                gap: 0.375rem;
            }

            .timeslot-box {
                padding: 0.5rem 0.5rem;
                gap: 0.3rem;
            }

            .timeslot-box__label {
                font-size: 0.65rem;
            }

            .timeslot-box__icon {
                font-size: 0.8rem;
            }
        }

        /* ===== LAPANG BOOKING BUTTON ===== */
        .lapang-booking-btn-wrap {
            padding-top: 0.75rem;
            margin-top: 0.75rem;
            border-top: 1px solid var(--outline-variant);
        }

        .lapang-booking-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.7rem 1rem;
            background: linear-gradient(135deg, var(--tertiary) 0%, var(--tertiary-container) 100%);
            color: #fff;
            border: none;
            border-radius: 0.75rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px -2px rgba(0, 108, 64, 0.3);
        }

        .lapang-booking-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px -4px rgba(0, 108, 64, 0.4);
            color: #fff;
        }

        .lapang-booking-btn:active {
            transform: scale(0.97);
        }

        /* ===== BOOKING FORM PAGE ===== */
        .bf-summary-card,
        .bf-form-card {
            background: var(--surface-container-lowest);
            border: 1.5px solid var(--outline-variant);
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.04),
                0 8px 24px -4px rgba(0, 0, 0, 0.06);
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .bf-summary-card {
            animation-delay: 0.1s;
        }

        .bf-form-card {
            animation-delay: 0.18s;
        }

        .bf-summary-header,
        .bf-form-header {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 1.15rem 1.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-container) 100%);
            color: var(--on-primary);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .bf-summary-body,
        .bf-form-body {
            padding: 1.5rem;
        }

        /* Summary Items */
        .bf-summary-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.625rem 0;
        }

        .bf-summary-item+.bf-summary-item {
            border-top: 1px solid rgba(194, 198, 216, 0.2);
        }

        .bf-summary-icon {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.625rem;
            background: var(--primary-fixed);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .bf-summary-icon .material-symbols-outlined {
            font-size: 1.1rem;
        }

        .bf-summary-label {
            display: block;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--on-surface-variant);
        }

        .bf-summary-value {
            display: block;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--on-surface);
            margin-top: 0.1rem;
        }

        .bf-summary-price {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            color: var(--on-surface-variant);
            font-size: 0.9rem;
        }

        .bf-summary-price-value {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* Info Alert */
        .bf-info-alert {
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            padding: 1rem 1.25rem;
            background: var(--primary-fixed);
            color: var(--on-primary-fixed);
            border-radius: 0.875rem;
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
            animation-delay: 0.25s;
        }

        .bf-info-alert strong {
            font-family: 'Inter', sans-serif;
            font-size: 0.82rem;
        }

        /* Form Fields */
        .bf-field {
            margin-bottom: 1rem;
        }

        .bf-field-label {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--on-surface-variant);
            margin-bottom: 0.5rem;
        }

        .bf-field-label-icon {
            font-size: 1rem;
            color: var(--primary);
        }

        .bf-input-wrap {
            display: flex;
            align-items: center;
            background: var(--surface-container-low);
            border: 1.5px solid transparent;
            border-radius: 0.75rem;
            padding: 0 1rem;
            transition: all 0.2s ease;
        }

        .bf-input-wrap:focus-within {
            background: var(--surface-container-lowest);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 87, 205, 0.08);
        }

        .bf-input-wrap--textarea {
            align-items: flex-start;
            padding-top: 0.75rem;
        }

        .bf-input-icon {
            color: var(--on-surface-variant);
            font-size: 1.15rem;
            margin-right: 0.5rem;
            flex-shrink: 0;
            transition: color 0.2s;
        }

        .bf-input-wrap:focus-within .bf-input-icon {
            color: var(--primary);
        }

        .bf-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 0.75rem 0;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--on-surface);
            outline: none;
        }

        .bf-input::placeholder {
            font-weight: 400;
            color: var(--outline);
        }

        .bf-select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23727787' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0 center;
            background-size: 1rem;
            padding-right: 1.5rem;
            cursor: pointer;
        }

        .bf-input-date {
            cursor: pointer;
        }

        .bf-textarea {
            resize: vertical;
            min-height: 4rem;
        }

        .bf-submit-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.85rem 1.5rem;
            margin-top: 1.5rem;
            background: linear-gradient(135deg, var(--tertiary) 0%, var(--tertiary-container) 100%);
            color: #fff;
            border: none;
            border-radius: 0.75rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px -2px rgba(0, 108, 64, 0.3);
        }

        .bf-submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px -4px rgba(0, 108, 64, 0.4);
        }

        .bf-submit-btn:active {
            transform: scale(0.97);
        }

        .bf-terms {
            text-align: center;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.72rem;
            color: var(--on-surface-variant);
            margin-top: 1rem;
            margin-bottom: 0;
        }

        .bf-terms a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .bf-terms a:hover {
            text-decoration: underline;
        }

        @media (max-width: 767.98px) {

            .bf-summary-body,
            .bf-form-body {
                padding: 1.25rem;
            }
        }

        /* ===== MEMBERSHIP — BENEFIT CARDS ===== */
        .ms-benefit-card {
            background: var(--surface-container-lowest);
            border: 1.5px solid var(--outline-variant);
            border-radius: 1.25rem;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
            height: 100%;
        }

        .ms-benefit-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .ms-benefit-card:nth-child(2) {
            animation-delay: 0.18s;
        }

        .ms-benefit-card:nth-child(3) {
            animation-delay: 0.26s;
        }

        .ms-benefit-card:hover {
            border-color: var(--primary-fixed-dim);
            box-shadow: 0 8px 32px -8px rgba(0, 87, 205, 0.1);
            transform: translateY(-4px);
        }

        .ms-benefit-icon {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }

        .ms-benefit-icon .material-symbols-outlined {
            font-size: 1.6rem;
        }

        .ms-benefit-icon--primary {
            background: var(--primary-fixed);
            color: var(--primary);
        }

        .ms-benefit-icon--tertiary {
            background: var(--tertiary-fixed);
            color: var(--tertiary);
        }

        .ms-benefit-icon--secondary {
            background: var(--secondary-fixed);
            color: var(--secondary);
        }

        .ms-benefit-title {
            font-family: 'Inter', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--on-surface);
            margin-bottom: 0.5rem;
            letter-spacing: -0.01em;
        }

        .ms-benefit-desc {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.82rem;
            color: var(--on-surface-variant);
            line-height: 1.6;
            margin-bottom: 0;
        }

        /* ===== MEMBERSHIP — PRICING CARDS ===== */
        .ms-pricing-card {
            background: var(--surface-container-lowest);
            border: 1.5px solid var(--outline-variant);
            border-radius: 1.25rem;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .ms-pricing-card:hover {
            border-color: var(--primary-fixed-dim);
            box-shadow: 0 8px 32px -8px rgba(0, 87, 205, 0.12);
            transform: translateY(-4px);
        }

        .ms-pricing-card--popular {
            border-color: var(--primary);
            box-shadow: 0 8px 32px -8px rgba(0, 87, 205, 0.15);
        }

        .ms-pricing-card--popular:hover {
            box-shadow: 0 12px 40px -8px rgba(0, 87, 205, 0.22);
        }

        .ms-popular-ribbon {
            position: absolute;
            top: 14px;
            right: -32px;
            background: linear-gradient(135deg, var(--tertiary) 0%, var(--tertiary-container) 100%);
            color: #fff;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            padding: 0.3rem 2.5rem;
            transform: rotate(45deg);
            z-index: 2;
        }

        .ms-pricing-header {
            text-align: center;
            padding: 2rem 1.5rem 1.5rem;
            background: var(--surface-container-low);
            border-bottom: 1px solid var(--outline-variant);
        }

        .ms-pricing-header--popular {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-container) 100%);
            border-bottom-color: transparent;
        }

        .ms-pricing-header--popular .ms-pricing-badge,
        .ms-pricing-header--popular .ms-pricing-currency,
        .ms-pricing-header--popular .ms-pricing-amount,
        .ms-pricing-header--popular .ms-pricing-period {
            color: #fff;
        }

        .ms-pricing-header--popular .ms-pricing-badge--popular {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .ms-pricing-badge {
            display: inline-block;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0.3rem 0.85rem;
            border-radius: 9999px;
            background: var(--primary-fixed);
            color: var(--on-primary-fixed-variant);
            margin-bottom: 0.75rem;
        }

        .ms-pricing-price {
            display: flex;
            align-items: baseline;
            justify-content: center;
            gap: 0.15rem;
        }

        .ms-pricing-currency {
            font-family: 'Public Sans', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--on-surface-variant);
        }

        .ms-pricing-amount {
            font-family: 'Inter', sans-serif;
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--on-surface);
            line-height: 1;
        }

        .ms-pricing-period {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.78rem;
            color: var(--on-surface-variant);
            margin-top: 0.25rem;
        }

        .ms-pricing-save {
            display: inline-block;
            margin-top: 0.5rem;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--tertiary);
            background: var(--tertiary-fixed);
            padding: 0.2rem 0.65rem;
            border-radius: 9999px;
        }

        .ms-pricing-header--popular .ms-pricing-save {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .ms-pricing-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .ms-pricing-features {
            list-style: none;
            padding: 0;
            margin: 0 0 1.5rem;
            flex: 1;
        }

        .ms-pricing-features li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--on-surface);
            border-bottom: 1px solid rgba(194, 198, 216, 0.15);
        }

        .ms-pricing-features li:last-child {
            border-bottom: none;
        }

        .ms-check {
            font-size: 1.1rem;
            color: var(--tertiary);
            flex-shrink: 0;
        }

        .ms-feature-disabled {
            opacity: 0.4;
        }

        .ms-feature-disabled .material-symbols-outlined {
            color: var(--outline);
        }

        .ms-pricing-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .ms-pricing-btn--outline {
            background: transparent;
            border: 1.5px solid var(--outline-variant);
            color: var(--on-surface);
        }

        .ms-pricing-btn--outline:hover {
            background: var(--surface-container-low);
            border-color: var(--primary-fixed-dim);
            color: var(--primary);
            transform: translateY(-1px);
        }

        .ms-pricing-btn--primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-container) 100%);
            border: none;
            color: #fff;
            box-shadow: 0 4px 12px -2px rgba(0, 87, 205, 0.3);
        }

        .ms-pricing-btn--primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px -4px rgba(0, 87, 205, 0.4);
            color: #fff;
        }

        .ms-pricing-btn:active {
            transform: scale(0.97);
        }

        /* ===== MEMBERSHIP — FAQ ===== */
        .ms-faq-card {
            max-width: 720px;
            background: var(--surface-container-lowest);
            border: 1.5px solid var(--outline-variant);
            border-radius: 1.25rem;
            padding: 2rem;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.04),
                0 8px 24px -4px rgba(0, 0, 0, 0.06);
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
            animation-delay: 0.2s;
        }

        .ms-faq-item {
            border-bottom: 1px solid var(--outline-variant);
        }

        .ms-faq-item:last-child {
            border-bottom: none;
        }

        .ms-faq-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 1rem 0;
            background: transparent;
            border: none;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--on-surface);
            cursor: pointer;
            text-align: left;
            gap: 1rem;
        }

        .ms-faq-btn:hover {
            color: var(--primary);
        }

        .ms-faq-arrow {
            transition: transform 0.3s ease;
            color: var(--on-surface-variant);
            flex-shrink: 0;
        }

        .ms-faq-btn:not(.collapsed) .ms-faq-arrow {
            transform: rotate(180deg);
            color: var(--primary);
        }

        .ms-faq-answer {
            padding: 0 0 1rem;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.82rem;
            color: var(--on-surface-variant);
            line-height: 1.7;
        }

        @media (max-width: 767.98px) {
            .ms-pricing-amount {
                font-size: 1.75rem;
            }

            .ms-faq-card {
                padding: 1.25rem;
            }
        }

        /* ===== RESPONSIVE ADJUSTMENTS ===== */
        @media (max-width: 767.98px) {
            .filter-card {
                padding: 1.25rem 1.25rem;
                border-radius: 1rem;
            }

            .schedule-card {
                padding: 1rem 1.25rem;
            }

            .schedule-card__left {
                gap: 0.75rem;
            }

            .schedule-card__hour {
                font-size: 1.1rem;
            }
        }

        /* ===== BOOKING / UBAH JADWAL ===== */
        .booking-card,
        .booking-result-card,
        .booking-success-card {
            max-width: 560px;
            background: var(--surface-container-lowest);
            border: 1px solid var(--outline-variant);
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.04),
                0 8px 24px -4px rgba(0, 0, 0, 0.06);
            text-align: center;
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
            animation-delay: 0.1s;
        }

        /* Icon wrap */
        .booking-card__icon-wrap,
        .booking-success-icon-wrap {
            margin-bottom: 1.5rem;
        }

        .booking-card__icon,
        .booking-success-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 1.25rem;
            background: var(--primary-fixed);
        }

        .booking-card__icon .material-symbols-outlined {
            font-size: 2.25rem;
            color: var(--primary);
        }

        .booking-success-icon {
            background: var(--tertiary-fixed);
        }

        .booking-success-icon .material-symbols-outlined {
            font-size: 2.25rem;
            color: var(--tertiary);
        }

        .booking-card__title {
            font-family: 'Inter', sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--on-surface);
            margin-bottom: 0.5rem;
        }

        .booking-card__desc {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.875rem;
            color: var(--on-surface-variant);
            line-height: 1.6;
            max-width: 28rem;
            margin: 0 auto 1.75rem;
        }

        /* Input group */
        .booking-form {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-width: 22rem;
            margin: 0 auto;
        }

        .booking-input-group {
            display: flex;
            align-items: center;
            background: var(--surface-container-low);
            border: 1.5px solid transparent;
            border-radius: 0.75rem;
            padding: 0 1rem;
            transition: all 0.2s ease;
        }

        .booking-input-group:focus-within {
            background: var(--surface-container-lowest);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 87, 205, 0.08);
        }

        .booking-input-icon {
            color: var(--on-surface-variant);
            font-size: 1.25rem;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }

        .booking-input-group:focus-within .booking-input-icon {
            color: var(--primary);
        }

        .booking-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 0.75rem 0;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            color: var(--on-surface);
            outline: none;
        }

        .booking-input::placeholder {
            font-weight: 400;
            letter-spacing: 0;
            color: var(--outline);
        }

        .booking-submit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #0057cd 0%, #0d6efd 100%);
            color: #fff;
            border: none;
            border-radius: 0.75rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px -2px rgba(0, 87, 205, 0.3);
        }

        .booking-submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px -4px rgba(0, 87, 205, 0.4);
            color: #fff;
        }

        .booking-submit-btn:active {
            transform: scale(0.97);
        }

        .booking-submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .booking-outline-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: transparent;
            color: var(--on-surface);
            border: 1.5px solid var(--outline-variant);
            border-radius: 0.75rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .booking-outline-btn:hover {
            background: var(--surface-container-low);
            border-color: var(--primary-fixed-dim);
            color: var(--on-surface);
        }

        /* Alert */
        .booking-alert {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            text-align: left;
            margin-top: 1.25rem;
            max-width: 22rem;
            margin-left: auto;
            margin-right: auto;
        }

        .booking-alert--error {
            background: var(--error-container);
            color: var(--on-error-container);
        }

        .booking-alert--error .material-symbols-outlined {
            color: var(--error);
            flex-shrink: 0;
            margin-top: 0.1rem;
        }

        .booking-alert--error strong {
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
        }

        .booking-alert--error p {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.75rem;
            line-height: 1.4;
            margin-top: 0.2rem;
        }

        @keyframes shakeX {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-4px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(4px);
            }
        }

        /* Help */
        .booking-help {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            margin-top: 1.5rem;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.78rem;
            color: var(--on-surface-variant);
        }

        .booking-help-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .booking-help-link:hover {
            text-decoration: underline;
        }

        /* Back Button */
        .booking-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            background: transparent;
            border: none;
            color: var(--on-surface-variant);
            font-family: 'Public Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0.25rem 0;
            margin-bottom: 1.5rem;
            transition: color 0.2s;
        }

        .booking-back-btn:hover {
            color: var(--primary);
        }

        /* Result card specifics */
        .booking-result-card {
            max-width: 620px;
            text-align: left;
        }

        .booking-result__header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .booking-result__status {
            margin-bottom: 0.75rem;
        }

        .booking-result__title {
            font-family: 'Inter', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--on-surface);
            margin-bottom: 0.25rem;
        }

        .booking-result__code {
            font-family: 'Public Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            color: var(--on-surface-variant);
            margin-bottom: 0;
        }

        .booking-result__details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.75rem;
            background: var(--surface-container-low);
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
        }

        .booking-detail-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        @media (max-width: 575.98px) {
            .booking-detail-row {
                grid-template-columns: 1fr;
            }
        }

        .booking-detail-item {
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
        }

        .booking-detail-icon {
            color: var(--primary);
            font-size: 1.2rem;
            margin-top: 0.1rem;
            flex-shrink: 0;
        }

        .booking-detail-label {
            display: block;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--on-surface-variant);
            margin-bottom: 0.1rem;
        }

        .booking-detail-value {
            display: block;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--on-surface);
        }

        /* Reschedule */
        .booking-reschedule {
            border-top: 1px solid var(--outline-variant);
            padding-top: 1.5rem;
        }

        .booking-reschedule__title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--on-surface);
            margin-bottom: 1.25rem;
        }

        .booking-confirm-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.85rem 1.5rem;
            background: linear-gradient(135deg, var(--tertiary) 0%, var(--tertiary-container) 100%);
            color: #fff;
            border: none;
            border-radius: 0.75rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px -2px rgba(0, 108, 64, 0.3);
        }

        .booking-confirm-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px -4px rgba(0, 108, 64, 0.4);
        }

        .booking-confirm-btn:active {
            transform: scale(0.97);
        }

        @media (max-width: 767.98px) {

            .booking-card,
            .booking-result-card,
            .booking-success-card {
                padding: 2rem 1.5rem;
                border-radius: 1.25rem;
            }

            .booking-result__details {
                padding: 1rem;
            }
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