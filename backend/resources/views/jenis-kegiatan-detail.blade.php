<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0f172a">
    <title>Detail Jenis Kegiatan</title>
    <title>Detail Jenis Kegiatan - e-Kinerja</title>
    @include('partials.pwa-head')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background: linear-gradient(145deg, #0f172a 0%, #312e81 52%, #172554 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #f8fafc;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(30, 41, 59, 0.82);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 16px 40px rgba(2, 6, 23, 0.35);
        }

        /* ====================================================
           EXECUTIVE MODERN APP HEADER BAR (RESPONSIVE & SLIM)
           ==================================================== */
        .app-header-bar {
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 12px 32px -4px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.12);
            padding: 10px 16px;
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
        }

        .app-header-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #10b981, #06b6d4, #6366f1);
            opacity: 0.8;
        }

        .header-nav-btn {
            width: 36px;
            height: 36px;
            min-width: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: #cbd5e1;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            padding: 0;
        }

        .header-nav-btn:hover {
            background: rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.45);
            color: #34d399;
            transform: translateX(-2px);
            box-shadow: 0 0 14px rgba(16, 185, 129, 0.3);
        }

        .header-nav-btn:active {
            transform: scale(0.94);
        }

        .header-micro-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #34d399;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            padding: 1px 7px;
            border-radius: 9999px;
            width: fit-content;
        }

        .header-title-text {
            font-size: 0.95rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.01em;
            line-height: 1.25;
            margin: 0;
        }

        .header-subtitle-text {
            font-size: 0.72rem;
            color: #94a3b8;
            margin: 0;
            line-height: 1.2;
        }

        /* Live Pill Status Badge with Glowing Dot */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 11px;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            white-space: nowrap;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .status-badge::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-draft {
            background: rgba(245, 158, 11, 0.14);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.35);
        }
        .status-draft::before {
            background: #fbbf24;
            box-shadow: 0 0 7px #f59e0b;
        }

        .status-submitted {
            background: rgba(6, 182, 212, 0.14);
            color: #38bdf8;
            border: 1px solid rgba(6, 182, 212, 0.35);
        }
        .status-submitted::before {
            background: #38bdf8;
            box-shadow: 0 0 7px #06b6d4;
        }

        .status-approved {
            background: rgba(16, 185, 129, 0.14);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }
        .status-approved::before {
            background: #34d399;
            box-shadow: 0 0 7px #10b981;
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.14);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.35);
        }
        .status-rejected::before {
            background: #f87171;
            box-shadow: 0 0 7px #ef4444;
        }

        @media (max-width: 576px) {
            .app-header-bar {
                padding: 7px 12px;
                border-radius: 13px;
            }
            .header-nav-btn {
                width: 32px;
                height: 32px;
                min-width: 32px;
                border-radius: 8px;
            }
            .header-title-text {
                font-size: 0.82rem;
            }
            .header-subtitle-text {
                font-size: 0.67rem;
            }
            .status-badge {
                padding: 3px 8px;
                font-size: 0.67rem;
                gap: 4px;
            }
            .status-badge::before {
                width: 5px;
                height: 5px;
            }
        }
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 10px;
            background: rgba(15, 23, 42, 0.92) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
            border-radius: 12px;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
            background: rgba(15, 23, 42, 0.98) !important;
            border-color: #10b981 !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25) !important;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
            color: rgba(148, 163, 184, 0.8) !important;
        }
        .form-control[readonly] {
            background: rgba(15, 23, 42, 0.6) !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
            color: #cbd5e1 !important;
        }
        .form-select option {
            background: #0f172a;
            color: #ffffff;
        }
        .form-label {
            color: white;
            color: #e2e8f0;
            font-weight: 600;
        }
        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%) !important;
            border: none !important;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35);
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #059669 0%, #0f766e 100%) !important;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
            transform: translateY(-1px);
            color: #ffffff !important;
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
            color: #f1f5f9 !important;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.16) !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .status-draft { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); }
        .status-submitted { background: rgba(6, 182, 212, 0.2); color: #38bdf8; border: 1px solid rgba(6, 182, 212, 0.35); }
        .status-approved { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); }
        .status-rejected { background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.35); }
        
        /* ====================================================
           PROFESSIONAL MOBILE CAMERA & DOKUMENTASI SYSTEM
           ==================================================== */
        .documentation-section {
            background: rgba(15, 23, 42, 0.65);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
        }

        /* Viewfinder Viewport */
        .camera-container {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 3;
            min-height: 320px;
            max-height: 480px;
            background: #020617;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.16);
            box-shadow: 0 16px 36px -8px rgba(0, 0, 0, 0.7), inset 0 0 0 1px rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 640px) {
            .camera-container {
                aspect-ratio: 3 / 4;
                min-height: 380px;
                max-height: 460px;
            }
        }

        .media-section {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #000000;
        }

        #cameraVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(1);
            transition: transform 0.3s ease;
        }

        #cameraVideo.mirror-mode {
            transform: scaleX(-1);
        }

        .photo-preview-full {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* White tactile flash on capture */
        .shutter-flash {
            position: absolute;
            inset: 0;
            background: #ffffff;
            opacity: 0;
            pointer-events: none;
            z-index: 60;
            transition: opacity 0.18s ease-out;
        }
        .shutter-flash.active {
            opacity: 0.92;
            transition: none;
        }

        /* Pro Camera Viewfinder Reticles Overlay */
        .viewfinder-overlay {
            position: absolute;
            inset: 16px;
            pointer-events: none;
            z-index: 15;
        }

        .vf-corner {
            position: absolute;
            width: 22px;
            height: 22px;
            border-color: rgba(255, 255, 255, 0.85);
            border-style: solid;
        }
        .vf-top-left { top: 0; left: 0; border-width: 2.5px 0 0 2.5px; border-top-left-radius: 4px; }
        .vf-top-right { top: 0; right: 0; border-width: 2.5px 2.5px 0 0; border-top-right-radius: 4px; }
        .vf-bottom-left { bottom: 0; left: 0; border-width: 0 0 2.5px 2.5px; border-bottom-left-radius: 4px; }
        .vf-bottom-right { bottom: 0; right: 0; border-width: 0 2.5px 2.5px 0; border-bottom-right-radius: 4px; }

        .vf-center-target {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 1.5px dashed rgba(16, 185, 129, 0.6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            animation: vfTargetPulse 2.5s infinite ease-in-out;
        }
        .vf-center-target::after {
            content: '';
            width: 6px;
            height: 6px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 8px #10b981;
        }
        @keyframes vfTargetPulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.7; }
            50% { transform: translate(-50%, -50%) scale(1.12); opacity: 0.35; }
        }

        /* Top HUD Bar */
        .camera-top-hud {
            position: absolute;
            top: 14px;
            left: 14px;
            right: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 25;
            pointer-events: auto;
        }

        .cam-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 9999px;
            color: #f1f5f9;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .cam-pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.7);
            animation: dotPulse 1.6s infinite;
        }
        @keyframes dotPulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 7px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .cam-hud-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cam-hud-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .cam-hud-btn:hover, .cam-hud-btn:active {
            background: rgba(30, 41, 59, 0.95);
            color: #ffffff;
            transform: scale(1.08);
        }
        .cam-hud-btn-danger:hover {
            background: rgba(239, 68, 68, 0.8) !important;
            border-color: #ef4444 !important;
        }

        /* Camera Standby Placeholder (Pro Card) */
        .camera-placeholder-pro {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 24px 16px;
            width: 100%;
            height: 100%;
            z-index: 5;
        }

        .cam-lens-graphic {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(6, 78, 59, 0.4));
            border: 2px dashed rgba(16, 185, 129, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            box-shadow: 0 0 24px rgba(16, 185, 129, 0.25);
            animation: floatLens 4s ease-in-out infinite;
        }
        @keyframes floatLens {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .cam-lens-inner {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .btn-emerald-pro {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%) !important;
            color: #ffffff !important;
            border: none !important;
            font-weight: 600;
            font-size: 13px;
            padding: 10px 18px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35);
            transition: all 0.2s ease;
        }
        .btn-emerald-pro:hover, .btn-emerald-pro:active {
            background: linear-gradient(135deg, #059669 0%, #0f766e 100%) !important;
            transform: translateY(-1px);
        }

        .btn-galeri-pro {
            background: rgba(255, 255, 255, 0.08) !important;
            color: #f1f5f9 !important;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
            font-weight: 600;
            font-size: 13px;
            padding: 10px 18px;
            border-radius: 12px;
            transition: all 0.2s ease;
        }
        .btn-galeri-pro:hover, .btn-galeri-pro:active {
            background: rgba(255, 255, 255, 0.16) !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.35) !important;
        }

        .cam-guide-pill {
            display: inline-flex;
            align-items: center;
            font-size: 11px;
            color: #94a3b8;
            background: rgba(15, 23, 42, 0.5);
            padding: 4px 10px;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        /* Floating Bottom Camera Deck (Shutter Bar) */
        .camera-bottom-deck {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 16px 24px 20px;
            background: linear-gradient(to top, rgba(2, 6, 23, 0.94) 0%, rgba(2, 6, 23, 0.55) 65%, transparent 100%);
            display: flex;
            align-items: center;
            justify-content: space-around;
            z-index: 30;
            pointer-events: auto;
        }

        .cam-deck-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(30, 41, 59, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .cam-deck-btn:hover {
            background: rgba(51, 65, 85, 0.9);
            transform: scale(1.08);
            border-color: rgba(255, 255, 255, 0.4);
        }
        .cam-deck-btn:active {
            transform: scale(0.94);
        }

        /* Pro Shutter Trigger */
        .shutter-trigger {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 3.5px solid #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.45);
            padding: 0;
        }
        .shutter-trigger:hover {
            transform: scale(1.06);
            border-color: #6ee7b7;
        }
        .shutter-trigger:active {
            transform: scale(0.92);
        }
        .shutter-core {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.3), 0 2px 8px rgba(16, 185, 129, 0.4);
            transition: transform 0.15s ease, background 0.15s ease;
        }
        .shutter-trigger:active .shutter-core {
            transform: scale(0.88);
            background: #059669;
        }

        /* Post-Capture Review Deck */
        .camera-review-deck {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 16px 20px 20px;
            background: linear-gradient(to top, rgba(2, 6, 23, 0.95) 0%, rgba(2, 6, 23, 0.65) 75%, transparent 100%);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 35;
        }

        .btn-review-retake {
            flex: 1;
            padding: 12px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.12) !important;
            border: 1px solid rgba(255, 255, 255, 0.22) !important;
            color: #f1f5f9 !important;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .btn-review-retake:hover {
            background: rgba(255, 255, 255, 0.2) !important;
        }

        .btn-review-accept {
            flex: 1;
            padding: 12px;
            border-radius: 12px;
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%) !important;
            border: none !important;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35);
            transition: all 0.2s ease;
        }
        .btn-review-accept:hover {
            background: linear-gradient(135deg, #059669 0%, #0f766e 100%) !important;
            transform: translateY(-1px);
        }

        /* Gallery / Attached Photo Grid */
        .attached-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 12px;
        }
        @media (max-width: 480px) {
            .attached-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
        }

        .photo-card-pro {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.12);
            aspect-ratio: 1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            cursor: pointer;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }
        .photo-card-pro:hover {
            transform: translateY(-2px);
            border-color: #10b981;
        }
        .photo-card-pro img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .photo-card-pro:hover img {
            transform: scale(1.05);
        }

        .photo-card-source {
            position: absolute;
            top: 7px;
            left: 7px;
            padding: 2px 7px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.2px;
            z-index: 5;
            backdrop-filter: blur(8px);
        }
        .photo-card-source.source-camera {
            background: rgba(16, 185, 129, 0.85);
            color: #ffffff;
        }
        .photo-card-source.source-upload {
            background: rgba(59, 130, 246, 0.85);
            color: #ffffff;
        }
        .photo-card-source.source-existing {
            background: rgba(168, 85, 247, 0.85);
            color: #ffffff;
        }

        .photo-card-delete {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: rgba(220, 38, 38, 0.9);
            color: #ffffff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            cursor: pointer;
            z-index: 10;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
            transition: transform 0.15s ease, background 0.15s ease;
        }
        .photo-card-delete:hover {
            background: #ef4444;
            transform: scale(1.15);
        }

        .photo-card-time {
            position: absolute;
            bottom: 6px;
            left: 6px;
            right: 6px;
            padding: 2px 6px;
            border-radius: 4px;
            background: rgba(2, 6, 23, 0.7);
            backdrop-filter: blur(6px);
            font-size: 9px;
            color: #cbd5e1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Lightbox Fullscreen Preview */
        .photo-lightbox-modal {
            position: fixed;
            inset: 0;
            background: rgba(2, 6, 23, 0.92);
            backdrop-filter: blur(14px);
            z-index: 10000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 16px;
            box-sizing: border-box;
            animation: lbFadeIn 0.25s ease-out;
        }
        @keyframes lbFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .photo-lightbox-content {
            position: relative;
            max-width: 92vw;
            max-height: 82vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .photo-lightbox-content img {
            max-width: 100%;
            max-height: 75vh;
            border-radius: 14px;
            object-fit: contain;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .photo-lightbox-close {
            position: absolute;
            top: -48px;
            right: 0;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .photo-lightbox-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        /* Single Date Picker Dark Styling */
        input[type="datetime-local"] {
            color-scheme: dark;
        /* Signature Styles */
        .signature-section {
            background: rgba(15, 23, 42, 0.6);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Professional Signature Styles */
        .signature-section,
        .signature-section-pro {
            background: rgba(15, 23, 42, 0.7);
            border-radius: 18px;
            padding: 22px;
            margin-bottom: 24px;
        .signature-box {
            background: rgba(30, 41, 59, 0.6);
            border-radius: 12px;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(12px);
        }
        .signature-box,
        .signature-box-pro {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.75) 0%, rgba(15, 23, 42, 0.85) 100%);
            border-radius: 14px;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .signature-box-pro:hover {
            border-color: rgba(16, 185, 129, 0.35);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }
        .signature-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            gap: 8px;
        }
        .sign-avatar-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .signature-role-title {
        .signature-label {
            color: #f8fafc;
            font-weight: 600;
            font-size: 13.5px;
            margin: 0;
            line-height: 1.2;
            font-size: 14px;
            margin-bottom: 10px;
            display: block;
        }
        .signature-pad-surface {
            background: rgba(15, 23, 42, 0.8);
        .signature-area {
            background: rgba(15, 23, 42, 0.7);
            border-radius: 10px;
            min-height: 90px;
            max-height: 110px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s ease;
            border: 1.5px dashed rgba(255, 255, 255, 0.18);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px dashed rgba(255, 255, 255, 0.2);
        }
        .signature-pad-surface:hover {
            background: rgba(15, 23, 42, 0.95);
        .signature-area:hover {
            background: rgba(15, 23, 42, 0.85);
            border-color: #10b981;
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.15);
        }
        .signature-placeholder-pro {
        .signature-placeholder {
            text-align: center;
            color: #94a3b8;
            padding: 8px;
            pointer-events: none;
        }
        .pen-icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 6px;
            color: #34d399;
            font-size: 16px;
            transition: transform 0.2s ease;
        .signature-placeholder i {
            opacity: 0.8;
            color: #10b981;
        }
        .signature-pad-surface:hover .pen-icon-circle {
            transform: scale(1.1);
        .signature-placeholder p {
            font-size: 12px;
            margin: 0;
            color: #cbd5e1;
        }
        .signature-freetyping-box {
            margin-top: 12px;
        .signature-info {
            background: rgba(15, 23, 42, 0.5);
            border-radius: 8px;
            padding: 8px 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .signature-freetyping-box label {
            font-size: 11.5px;
            color: #cbd5e1;
            font-weight: 500;
            margin-bottom: 5px;
        .signature-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .freetyping-tag {
            background: rgba(51, 65, 85, 0.6);
            border: 1px solid rgba(100, 116, 139, 0.4);
            color: #94a3b8;
            font-size: 10px;
            padding: 1px 6px;
            border-radius: 4px;
            font-family: ui-monospace, monospace;
        }
        .freetyping-input {
            background: rgba(15, 23, 42, 0.92) !important;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            font-size: 12.5px !important;
            padding: 7px 11px !important;
            transition: all 0.2s ease !important;
        }
        .freetyping-input:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
            background: rgba(15, 23, 42, 1) !important;
        }
        .signature-badge-signed {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.4);
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .signature-badge-pending {
            background: rgba(100, 116, 139, 0.2);
            color: #94a3b8;
            border: 1px solid rgba(100, 116, 139, 0.3);
            font-size: 11px;
            font-weight: 500;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-emerald-outline {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: #6ee7b7;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-emerald-outline:hover {
            background: #10b981;
            border-color: #10b981;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        .signature-signed-canvas-wrap {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border-radius: 8px;
            padding: 4px;
        }
        .signature-signed-canvas-wrap img {
            max-height: 85px;
            max-width: 100%;
            object-fit: contain;
            user-select: none;
        }
        .signature-canvas {
            width: 100%;
            height: 100%;
            min-height: 90px;
            max-height: 110px;
            border-radius: 8px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            object-fit: contain;
            padding: 4px;
            position: relative;
        }
        .signature-signed {
            background: rgba(16, 185, 129, 0.12);
            border-color: rgba(16, 185, 129, 0.45);
        }
        
        /* Signature Modal */
        .signature-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
            box-sizing: border-box;
        }
        .signature-modal-content {
            background: #1e293b;
            border-radius: 18px;
            padding: 24px;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.6);
            animation: modalSlideIn 0.3s ease-out;
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        .signature-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            flex-wrap: wrap;
            gap: 12px;
        }
        .signature-modal-header h5 {
            margin: 0;
            color: #f8fafc;
            font-size: 18px;
            font-weight: 600;
            flex: 1;
            min-width: 200px;
        }
        .btn-close {
            background: rgba(255, 255, 255, 0.08);
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: #94a3b8;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }
        .btn-close:hover {
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
        }
        
        .signature-modal-body {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        #signatureCanvas {
            width: 100%;
            height: auto;
            min-height: 200px;
            max-height: 300px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            background: #ffffff;
            cursor: crosshair;
            touch-action: none;
        }
        
        .signature-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        
        .signature-modal-actions .btn {
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
            min-width: 100px;
        }
        
        .signature-modal-actions .btn-secondary {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #e2e8f0 !important;
        }
        
        .signature-modal-actions .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        
        .signature-modal-actions .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%) !important;
            border: none !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35);
        }
        
        .signature-modal-actions .btn-primary:hover {
            background: linear-gradient(135deg, #059669 0%, #0f766e 100%) !important;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
            transform: translateY(-1px);
        }
        
        .signature-modal-actions .btn-outline-secondary {
            background: transparent !important;
            color: #cbd5e1 !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
        }
        
        .signature-modal-actions .btn-outline-secondary:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .signature-modal {
                padding: 16px;
            }
            
            .signature-modal-content {
                padding: 20px;
                max-height: 95vh;
            }
            
            .signature-modal-header {
                margin-bottom: 20px;
                padding-bottom: 12px;
            }
            
            .signature-modal-header h5 {
                font-size: 16px;
                min-width: auto;
            }
            
            #signatureCanvas {
                min-height: 180px;
                max-height: 250px;
            }
            
            .signature-modal-actions {
                gap: 8px;
            }
            
            .signature-modal-actions .btn {
                padding: 10px 16px;
                font-size: 14px;
                min-width: 80px;
                flex: 1;
            }
        }
        
        @media (max-width: 480px) {
            .signature-modal {
                padding: 12px;
            }
            
            .signature-modal-content {
                padding: 16px;
            }
            
            .signature-modal-header h5 {
                font-size: 15px;
            }
            
            #signatureCanvas {
                min-height: 160px;
                max-height: 200px;
            }
            
            .signature-modal-actions {
                flex-direction: column;
                gap: 8px;
            }
            
            .signature-modal-actions .btn {
                width: 100%;
                min-width: auto;
            }
        }
        
        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .btn-close {
                width: 44px;
                height: 44px;
                font-size: 20px;
            }
            
            .signature-modal-actions .btn {
                padding: 14px 20px;
                min-height: 44px;
            }
        }
    </style>
    @include('partials.mobile-ux')
</head>
<body>
    <div class="container-fluid py-2 py-sm-3 py-md-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header (Executive Slim & Professional) -->
                <div class="app-header-bar mb-3">
                    <div class="d-flex align-items-center justify-content-between gap-2.5" style="width: 100%;">
                        <div class="d-flex align-items-center min-w-0 gap-2 gap-sm-2.5" style="flex: 1;">
                            <button onclick="goBack()" class="header-nav-btn flex-shrink-0" title="Kembali ke Laporan">
                                <i class="fas fa-arrow-left text-xs"></i>
                            </button>
                            <div class="min-w-0 d-flex flex-column justify-content-center">
                                <div class="d-flex align-items-center gap-1.5 mb-0.5">
                                    <span class="header-micro-tag">
                                        <i class="fas fa-file-pen" style="font-size: 8px;"></i>
                                        <span>Logbook</span>
                                    </span>
                                </div>
                                <h5 class="header-title-text text-truncate mb-0" id="pageTitle">Detail Jenis Kegiatan</h5>
                                <p class="header-subtitle-text text-truncate mb-0" id="pageSubtitle">Kelola detail kegiatan Anda</p>
                            </div>
                        </div>
                        <div id="statusBadge" class="status-badge status-draft flex-shrink-0">
                            Draft
                        </div>
                    </div>
                </div>

                <!-- Edit Mode Notice (Active when editing existing report) -->
                <div id="editModeNotice" class="alert alert-warning bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs rounded-xl p-3 mb-4 d-none align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-inline-flex align-items-center justify-content-center w-7 h-7 rounded-circle bg-amber-500/20 text-amber-400 font-bold" style="width: 28px; height: 28px; border-radius: 50%;">
                            <i class="fas fa-edit"></i>
                        </span>
                        <div>
                            <strong class="d-block text-amber-200">Mode Edit Laporan</strong>
                            <span class="text-amber-300/80">Anda sedang memperbarui rekaman kegiatan. Silakan periksa data, tanda tangan, foto, lalu simpan perubahan.</span>
                        </div>
                    </div>
                    <span id="editIdBadge" class="badge bg-amber-500/20 text-amber-300 border border-amber-500/40 px-2 py-1">ID: -</span>
                </div>

                <!-- Form -->
                <div class="glass-card p-4">
                    <form id="detailKegiatanForm">
                        <div class="row">
                            <!-- Jenis Kegiatan -->
                            <div class="col-md-6 mb-3">
                                <label for="jenisKegiatan" class="form-label">
                                    <i class="fas fa-tasks me-2"></i>Jenis Kegiatan
                                </label>
                                <input type="text" class="form-control" id="jenisKegiatan" name="jenis_kegiatan" readonly>
                            </div>

                            <!-- NIP -->
                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label">
                                    <i class="fas fa-id-card me-2"></i>NIP
                                </label>
                                <input type="text" class="form-control" id="nip" name="nip" readonly>
                            </div>

                            <!-- Unit -->
                            <div class="col-md-6 mb-3">
                                <label for="unit" class="form-label">
                                    <i class="fas fa-building me-2"></i>Unit
                                </label>
                                <select class="form-select" id="unit" name="unit" required>
                                    <option value="">Memuat unit...</option>
                                    <!-- Options akan dimuat dari API berdasarkan NIP -->
                                </select>
                                <div class="invalid-feedback">
                                    Silakan pilih unit yang tersedia untuk NIP Anda
                                </div>
                            </div>

                            <!-- Tanggal Kegiatan (Satu Tanggal Utama Untuk Seluruh Laporan) -->
                            <div class="col-md-6 mb-3">
                                <label for="tanggalDibuat" class="form-label d-flex align-items-center justify-content-between mb-1.5">
                                    <span class="text-white"><i class="fas fa-calendar-day text-emerald-400 me-2"></i>Tanggal Kegiatan</span>
                                    <span class="badge bg-emerald-500/15 text-emerald-300 border border-emerald-500/25 px-2 py-0.5" style="font-size: 10.5px; font-weight: 500;">
                                        <i class="fas fa-circle-check text-emerald-400 me-1"></i>Tanggal Utama
                                    </span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-slate-900/90 border-slate-700/80 text-emerald-400">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                    <input type="datetime-local" class="form-control" id="tanggalDibuat" name="tanggal_dibuat" required style="color-scheme: dark;">
                                </div>
                                <small class="text-slate-400 mt-1 d-block" style="font-size: 11px;">
                                    <i class="fas fa-info-circle text-emerald-400/80 me-1"></i>Satu tanggal berlaku untuk seluruh laporan kegiatan dan lembar tanda tangan.
                                </small>
                            </div>

                            <!-- Hasil Temuan -->
                            <div class="col-12 mb-3">
                                <label for="hasilTemuan" class="form-label">
                                    <i class="fas fa-search me-2"></i>Hasil Temuan / Kegiatan
                                </label>
                                <textarea class="form-control" id="hasilTemuan" name="hasil_temuan" rows="4" placeholder="Deskripsikan hasil temuan atau kegiatan yang dilakukan..."></textarea>
                            </div>

                            <!-- Dokumentasi Section -->
                            <div class="col-12 mb-4">
                                <div class="documentation-section">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="d-inline-flex align-items-center justify-content-center w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 border border-emerald-500/30" style="width: 32px; height: 32px; border-radius: 8px;">
                                                <i class="fas fa-camera text-sm"></i>
                                            </span>
                                            <div>
                                                <h6 class="text-white mb-0 font-semibold">Dokumentasi & Bukti</h6>
                                                <small class="text-white-50" style="font-size: 11px;">Foto langsung atau unggah dari memori</small>
                                            </div>
                                        </div>
                                        <span id="photoCountBadge" class="badge rounded-pill bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-2.5 py-1" style="font-size: 11px;">
                                            0 Lampiran
                                        </span>
                                    </div>
                                    
                                    <!-- Professional Camera Viewfinder -->
                                    <div class="camera-container" id="cameraContainer">
                                        <!-- Shutter White Flash Feedback -->
                                        <div id="shutterFlash" class="shutter-flash"></div>

                                        <!-- Media Viewport -->
                                        <div class="media-section">
                                            <video id="cameraVideo" autoplay playsinline muted style="display: none;"></video>
                                            <canvas id="photoCanvas" style="display: none;"></canvas>
                                            <img id="photoPreview" class="photo-preview-full" alt="Pratinjau Foto" style="display: none;">
                                            
                                            <!-- Standby / Idle Screen -->
                                            <div id="cameraPlaceholder" class="camera-placeholder-pro">
                                                <div class="cam-lens-graphic">
                                                    <div class="cam-lens-inner">
                                                        <i class="fas fa-camera text-emerald-400"></i>
                                                    </div>
                                                </div>
                                                <h6 class="text-white font-semibold mb-1" style="font-size: 15px;">Ambil Foto Dokumentasi</h6>
                                                <p class="text-slate-400 text-xs mb-3 px-3 text-center" style="max-width: 320px;">Gunakan kamera ponsel untuk mengambil foto bukti atau pilih gambar dari galeri perangkat.</p>
                                                
                                                <div class="d-flex flex-wrap justify-content-center gap-2 w-100 px-3" style="max-width: 380px;">
                                                    <button type="button" id="startCameraBtn" class="btn btn-emerald-pro d-flex align-items-center justify-content-center gap-2 flex-grow-1">
                                                        <i class="fas fa-camera"></i> <span>Buka Kamera</span>
                                                    </button>
                                                    <button type="button" class="btn btn-galeri-pro d-flex align-items-center justify-content-center gap-2 flex-grow-1" onclick="document.getElementById('fileInput').click()">
                                                        <i class="fas fa-images"></i> <span>Pilih Galeri</span>
                                                    </button>
                                                </div>
                                                <div class="mt-3">
                                                    <span class="cam-guide-pill"><i class="fas fa-circle-check text-emerald-400 me-1"></i> Mendukung Depan/Belakang • Maks 5MB</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Viewfinder Overlay (Corner reticles & Focus target) -->
                                        <div id="viewfinderOverlay" class="viewfinder-overlay" style="display: none;">
                                            <div class="vf-corner vf-top-left"></div>
                                            <div class="vf-corner vf-top-right"></div>
                                            <div class="vf-corner vf-bottom-left"></div>
                                            <div class="vf-corner vf-bottom-right"></div>
                                            <div class="vf-center-target"></div>
                                        </div>

                                        <!-- Top HUD Bar -->
                                        <div id="cameraTopBar" class="camera-top-hud" style="display: none;">
                                            <div class="cam-status-pill">
                                                <span class="cam-pulse-dot"></span>
                                                <span id="camStatusText">Kamera Aktif</span>
                                            </div>
                                            <div class="cam-hud-actions">
                                                <button type="button" id="topSwitchCameraBtn" class="cam-hud-btn" title="Ganti Kamera Depan/Belakang">
                                                    <i class="fas fa-camera-rotate"></i>
                                                </button>
                                                <button type="button" id="closeCameraBtn" class="cam-hud-btn cam-hud-btn-danger" title="Tutup Kamera">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Bottom Control Deck (While live camera is active) -->
                                        <div id="cameraBottomDeck" class="camera-bottom-deck" style="display: none;">
                                            <!-- Switch Camera (Left) -->
                                            <button type="button" id="switchCamera" class="cam-deck-btn" title="Balik Kamera">
                                                <i class="fas fa-camera-rotate"></i>
                                            </button>
                                            
                                            <!-- Shutter Button (Center) -->
                                            <button type="button" id="capturePhoto" class="shutter-trigger" title="Ambil Foto">
                                                <div class="shutter-core"></div>
                                            </button>
                                            
                                            <!-- Pick from Gallery (Right) -->
                                            <button type="button" class="cam-deck-btn" onclick="document.getElementById('fileInput').click()" title="Pilih dari Galeri">
                                                <i class="fas fa-images"></i>
                                            </button>
                                        </div>

                                        <!-- Post-Capture Review Deck (After photo snapped) -->
                                        <div id="photoReviewDeck" class="camera-review-deck" style="display: none;">
                                            <button type="button" id="retakePhoto" class="btn btn-review-retake">
                                                <i class="fas fa-rotate-left me-1"></i> Ambil Ulang
                                            </button>
                                            <button type="button" id="acceptPhoto" class="btn btn-review-accept">
                                                <i class="fas fa-check me-1"></i> Gunakan Foto
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Hidden file input for gallery upload -->
                                    <input type="file" id="fileInput" accept="image/*" multiple style="display: none;">
                                    
                                    <!-- Attached Photos Gallery List -->
                                    <div class="mt-4">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="text-white text-xs font-semibold text-uppercase tracking-wider">
                                                <i class="fas fa-images me-1 text-emerald-400"></i>Foto Terlampir
                                            </span>
                                            <button type="button" class="btn btn-sm btn-galeri-pro py-1 px-2.5" style="font-size: 11px;" onclick="document.getElementById('fileInput').click()">
                                                <i class="fas fa-plus me-1"></i>Tambah Galeri
                                            </button>
                                        </div>
                                        <div id="allImagesPreview" class="attached-grid"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Signature Section (Minimalist & Clean) -->
                            <div class="col-12 mb-4">
                                <div class="signature-section-pro">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="text-white font-semibold mb-0 d-flex align-items-center gap-2" style="font-size: 14px;">
                                            <i class="fas fa-signature text-emerald-400"></i>
                                            <span>Tanda Tangan</span>
                                        </h6>
                                        <span id="signatureStatusSummaryBadge" class="badge bg-slate-800 text-slate-400 border border-slate-700/60 font-normal px-2 py-0.5" style="font-size: 11px;">0/2</span>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Petugas Card -->
                                        <div class="col-md-6">
                                            <div class="signature-box-pro">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-white font-medium text-sm">Petugas</span>
                                                    <span id="petugasStatusBadge" class="text-xs text-slate-400">Belum ditandatangani</span>
                                                </div>

                                                <!-- Signature Canvas Surface -->
                                                <div class="signature-pad-surface" id="petugasSignature" onclick="openSignaturePad('petugas')" role="button" title="Klik untuk tanda tangan">
                                                    <div class="signature-placeholder-pro">
                                                        <i class="fas fa-pen text-slate-500 text-xs mb-1"></i>
                                                        <div class="text-slate-400 text-xs">Klik untuk tanda tangan</div>
                                                    </div>
                                                </div>

                                                <!-- Nama Petugas Input (Freetyping) -->
                                                <div class="mt-2.5">
                                                    <input type="text" 
                                                           class="form-control freetyping-input" 
                                                           id="petugasNameInput" 
                                                           name="nama_petugas" 
                                                           placeholder="Nama Petugas" 
                                                           autocomplete="name">
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="d-flex gap-2 mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-light flex-grow-1 py-1" id="openPetugasPadBtn" onclick="openSignaturePad('petugas')">
                                                        <i class="fas fa-pen text-xs me-1"></i><span id="petugasActionText">Tanda Tangan</span>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger px-2.5 py-1" onclick="clearSignature('petugas')" style="display: none;" id="clearPetugasBtn" title="Hapus tanda tangan">
                                                        <i class="fas fa-trash-can text-xs"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Ka. Unit Card -->
                                        <div class="col-md-6">
                                            <div class="signature-box-pro">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-white font-medium text-sm">Ka. Unit / Ka. Ruangan</span>
                                                    <span id="kaUnitStatusBadge" class="text-xs text-slate-400">Belum ditandatangani</span>
                                                </div>

                                                <!-- Signature Canvas Surface -->
                                                <div class="signature-pad-surface" id="kaUnitSignature" onclick="openSignaturePad('kaUnit')" role="button" title="Klik untuk tanda tangan">
                                                    <div class="signature-placeholder-pro">
                                                        <i class="fas fa-pen text-slate-500 text-xs mb-1"></i>
                                                        <div class="text-slate-400 text-xs">Klik untuk tanda tangan</div>
                                                    </div>
                                                </div>

                                                <!-- Nama Ka. Unit Input (Freetyping) -->
                                                <div class="mt-2.5">
                                                    <input type="text" 
                                                           class="form-control freetyping-input" 
                                                           id="kaUnitNameInput" 
                                                           name="nama_ka_unit" 
                                                           placeholder="Nama Ka. Unit / Ka. Ruangan" 
                                                           autocomplete="off">
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="d-flex gap-2 mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-light flex-grow-1 py-1" id="openKaUnitPadBtn" onclick="openSignaturePad('kaUnit')">
                                                        <i class="fas fa-pen text-xs me-1"></i><span id="kaUnitActionText">Tanda Tangan</span>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger px-2.5 py-1" onclick="clearSignature('kaUnit')" style="display: none;" id="clearKaUnitBtn" title="Hapus tanda tangan">
                                                        <i class="fas fa-trash-can text-xs"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-wrap justify-content-end gap-3 mt-4">
                            <button type="button" class="btn btn-secondary" onclick="goBack()">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                            <button type="button" class="btn btn-outline-warning" id="btnSaveDraft" onclick="saveDraft()">
                                <i class="fas fa-floppy-disk me-2"></i>Simpan Draft
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnSubmit">
                                <i class="fas fa-paper-plane me-2"></i><span id="submitBtnText">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentUser = null;
        let detailId = null;
        let isEditMode = false;
        let editItemId = null;
        let stream = null;
        let capturedPhotos = [];
        let uploadedFiles = [];
        let existingPhotos = [];
        let signatures = {
            petugas: null,
            kaUnit: null
        };

        // Apply and render a signature to the surface UI
        function applySignature(type, dataURL) {
            if (!dataURL) return;
            signatures[type] = dataURL;
            
            const signatureArea = document.getElementById(type + 'Signature');
            if (signatureArea) {
                signatureArea.innerHTML = `
                    <div class="signature-signed-canvas-wrap">
                        <img src="${dataURL}" class="signature-canvas" alt="Tanda Tangan">
                    </div>
                `;
                signatureArea.classList.add('signature-signed');
            }

            const statusBadge = document.getElementById(type + 'StatusBadge');
            if (statusBadge) {
                statusBadge.className = 'text-xs text-emerald-400 font-medium';
                statusBadge.innerHTML = '<i class="fas fa-check me-1"></i>Sudah ditandatangani';
            }

            const actionText = document.getElementById(type + 'ActionText');
            if (actionText) {
                actionText.textContent = 'Ubah';
            }

            const clearBtn = document.getElementById('clear' + (type === 'petugas' ? 'Petugas' : 'KaUnit') + 'Btn');
            if (clearBtn) {
                clearBtn.style.display = 'inline-block';
            }

            updateSignatureBadges();
        }

        // Signature State & Management
        function updateSignatureBadges() {
            const count = (signatures.petugas ? 1 : 0) + (signatures.kaUnit ? 1 : 0);
            const summaryBadge = document.getElementById('signatureStatusSummaryBadge');
            if (summaryBadge) {
                if (count === 2) {
                    summaryBadge.className = 'badge bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-2 py-0.5 text-xs';
                    summaryBadge.innerHTML = '<i class="fas fa-check text-emerald-400 me-1"></i>2/2';
                } else {
                    summaryBadge.className = 'badge bg-slate-800 text-slate-400 border border-slate-700/60 font-normal px-2 py-0.5 text-xs';
                    summaryBadge.textContent = `${count}/2`;
                }
            }
        }

        // Open Signature Pad Modal
        let hasSignatureDrawn = false;

        function openSignaturePad(type) {
            closeSignatureModal();

            const title = type === 'petugas' ? 'Petugas' : 'Ka. Unit / Ka. Ruangan';
            const modal = document.createElement('div');
            modal.className = 'signature-modal';
            modal.id = 'activeSignatureModal';
            modal.style.cssText = 'position:fixed!important;top:0!important;left:0!important;width:100vw!important;height:100vh!important;height:100dvh!important;background:rgba(0,0,0,0.85)!important;backdrop-filter:blur(8px)!important;-webkit-backdrop-filter:blur(8px)!important;display:flex!important;align-items:center!important;justify-content:center!important;z-index:999999!important;padding:16px!important;box-sizing:border-box!important;margin:0!important;';

            // Dismiss modal when clicking backdrop outside content
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeSignatureModal();
                }
            });

            modal.innerHTML = `
                <div class="signature-modal-content" style="max-width: 520px; width: 100%;">
                    <div class="signature-modal-header d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-white/10">
                        <h6 class="text-white mb-0 font-semibold d-flex align-items-center gap-2" style="font-size: 15px;">
                            <i class="fas fa-pen-nib text-emerald-400"></i>
                            <span>Tanda Tangan ${title}</span>
                        </h6>
                        <button type="button" class="btn-close btn-close-white" onclick="closeSignatureModal()" title="Tutup" aria-label="Close"></button>
                    </div>
                    <div class="signature-modal-body">
                        <div class="position-relative mb-3" style="background: #ffffff; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.2); overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.25);">
                            <canvas id="signatureCanvas" style="display: block; width: 100%; height: 210px; cursor: crosshair; touch-action: none; background: #ffffff;"></canvas>
                            <div style="position: absolute; bottom: 18px; left: 16px; right: 16px; border-bottom: 1px dashed rgba(15, 23, 42, 0.25); pointer-events: none; display: flex; justify-content: space-between; align-items: flex-end;">
                                <span style="font-size: 11px; color: rgba(15, 23, 42, 0.45); font-weight: 500;">✕ Tanda tangan di atas garis ini</span>
                                <span style="font-size: 10px; color: rgba(15, 23, 42, 0.35);"><i class="fas fa-pen text-xs me-1"></i>Gunakan mouse / jari</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top border-white/10">
                            <button type="button" class="btn btn-sm btn-outline-danger py-1.5 px-3 rounded-xl text-xs d-flex align-items-center gap-1.5" onclick="clearCanvas()">
                                <i class="fas fa-rotate-left"></i>
                                <span>Hapus Kanvas</span>
                            </button>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-secondary py-1.5 px-3 rounded-xl text-xs" onclick="closeSignatureModal()">
                                    Batal
                                </button>
                                <button type="button" class="btn btn-sm py-1.5 px-4 rounded-xl text-xs font-semibold text-white d-flex align-items-center gap-1.5" style="background: linear-gradient(135deg, #10b981 0%, #0d9488 100%); border: none;" onclick="saveSignature('${type}')">
                                    <i class="fas fa-check"></i>
                                    <span>Simpan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            initializeSignatureCanvas(type);
        }

        function initializeSignatureCanvas(type) {
            const canvas = document.getElementById('signatureCanvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            let isDrawing = false;
            hasSignatureDrawn = false;
            let dpr = window.devicePixelRatio || 1;

            function resizeCanvas() {
                const rect = canvas.getBoundingClientRect();
                dpr = window.devicePixelRatio || 1;
                const width = rect.width || 460;
                const height = rect.height || 210;

                canvas.width = width * dpr;
                canvas.height = height * dpr;

                ctx.scale(dpr, dpr);
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.strokeStyle = '#090d16';
                ctx.lineWidth = 2.6;

                // If signature exists, restore it onto canvas
                if (type && signatures[type]) {
                    const img = new Image();
                    img.onload = function() {
                        ctx.drawImage(img, 0, 0, width, height);
                        hasSignatureDrawn = true;
                    };
                    img.src = signatures[type];
                }
            }

            requestAnimationFrame(resizeCanvas);

            function getPos(e) {
                const rect = canvas.getBoundingClientRect();
                const pointer = (e.touches && e.touches[0]) ? e.touches[0] : e;
                return {
                    x: pointer.clientX - rect.left,
                    y: pointer.clientY - rect.top,
                };
            }

            function startDrawing(e) {
                if (e.touches) e.preventDefault();
                isDrawing = true;
                hasSignatureDrawn = true;
                const pos = getPos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            }

            function draw(e) {
                if (!isDrawing) return;
                if (e.touches) e.preventDefault();
                const pos = getPos(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }

            function stopDrawing() {
                if (isDrawing) {
                    isDrawing = false;
                    ctx.closePath();
                }
            }

            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            window.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseleave', stopDrawing);

            canvas.addEventListener('touchstart', startDrawing, { passive: false });
            canvas.addEventListener('touchmove', draw, { passive: false });
            canvas.addEventListener('touchend', stopDrawing);
            canvas.addEventListener('touchcancel', stopDrawing);
        }

        function clearCanvas() {
            const canvas = document.getElementById('signatureCanvas');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                ctx.save();
                ctx.setTransform(1, 0, 0, 1, 0, 0);
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.restore();
                hasSignatureDrawn = false;
            }
        }

        function saveSignature(type) {
            const canvas = document.getElementById('signatureCanvas');
            if (!canvas) return;

            if (!hasSignatureDrawn) {
                alert('Silakan bubuhkan tanda tangan di kanvas terlebih dahulu.');
                return;
            }

            const dataURL = canvas.toDataURL('image/png');
            applySignature(type, dataURL);
            closeSignatureModal();
        }

        function clearSignature(type) {
            signatures[type] = null;
            hasSignatureDrawn = false;
            
            const signatureArea = document.getElementById(type + 'Signature');
            if (signatureArea) {
                signatureArea.innerHTML = `
                    <div class="signature-placeholder-pro">
                        <i class="fas fa-pen text-slate-500 text-xs mb-1"></i>
                        <div class="text-slate-400 text-xs">Klik untuk tanda tangan</div>
                    </div>
                `;
                signatureArea.classList.remove('signature-signed');
            }
            
            // Update status badge
            const statusBadge = document.getElementById(type + 'StatusBadge');
            if (statusBadge) {
                statusBadge.className = 'text-xs text-slate-400';
                statusBadge.textContent = 'Belum ditandatangani';
            }

            // Update action button label
            const actionText = document.getElementById(type + 'ActionText');
            if (actionText) {
                actionText.textContent = 'Tanda Tangan';
            }

            // Hide clear button
            const clearBtn = document.getElementById('clear' + (type === 'petugas' ? 'Petugas' : 'KaUnit') + 'Btn');
            if (clearBtn) {
                clearBtn.style.display = 'none';
            }

            // Update section summary counter
            updateSignatureBadges();
        }

        function closeSignatureModal() {
            const modal = document.getElementById('activeSignatureModal') || document.querySelector('.signature-modal');
            if (modal) {
                modal.remove();
            }
        }

        // Global functions for inline event handlers
        window.openSignaturePad = openSignaturePad;
        window.closeSignatureModal = closeSignatureModal;
        window.saveSignature = saveSignature;
        window.clearSignature = clearSignature;
        window.clearCanvas = clearCanvas;

        // Fungsi untuk memuat unit berdasarkan NIP user
        async function loadUserUnits(selectedUnit = null) {
            const unitSelect = document.getElementById('unit');
            if (!unitSelect) return;

            const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user') || '{}');
            const token = localStorage.getItem('token') || sessionStorage.getItem('token');
            const targetUnit = (selectedUnit || user?.ruangan || '').trim();

            unitSelect.innerHTML = '<option value="">Memuat unit...</option>';

            try {
                let availableUnits = [];

                if (token) {
                    try {
                        const response = await fetch('/api/unit-ruangan', {
                            method: 'GET',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        });

                        if (response.ok) {
                            const result = await response.json();
                            if (result.success && Array.isArray(result.data)) {
                                availableUnits = result.data.map(item => item.nama_ruangan).filter(Boolean);
                            }
                        }
                    } catch (fetchErr) {
                        console.warn('Gagal memuat /api/unit-ruangan:', fetchErr);
                    }
                }

                // Tambahkan targetUnit dan user.ruangan jika belum terdaftar
                if (targetUnit && !availableUnits.some(u => u.toLowerCase() === targetUnit.toLowerCase())) {
                    availableUnits.push(targetUnit);
                }
                if (user?.ruangan && !availableUnits.some(u => u.toLowerCase() === user.ruangan.trim().toLowerCase())) {
                    availableUnits.push(user.ruangan.trim());
                }

                const uniqueUnits = [...new Set(availableUnits.map(u => u.trim()).filter(Boolean))];

                unitSelect.innerHTML = '<option value="">Pilih Unit</option>';
                let hasSelected = false;

                uniqueUnits.forEach(namaRuangan => {
                    const option = document.createElement('option');
                    option.value = namaRuangan;
                    option.textContent = namaRuangan;
                    if (targetUnit && (targetUnit.toLowerCase() === namaRuangan.toLowerCase())) {
                        option.selected = true;
                        hasSelected = true;
                    }
                    unitSelect.appendChild(option);
                });

                // Jika targetUnit ada tapi belum terpilih
                if (targetUnit && !hasSelected) {
                    const option = document.createElement('option');
                    option.value = targetUnit;
                    option.textContent = targetUnit;
                    option.selected = true;
                    unitSelect.appendChild(option);
                    hasSelected = true;
                }

                // Jika hanya ada satu unit dan belum terpilih, auto-pilih unit tersebut
                if (!hasSelected && uniqueUnits.length === 1) {
                    unitSelect.value = uniqueUnits[0];
                }

            } catch (error) {
                console.error('Error loading units:', error);
                unitSelect.innerHTML = '<option value="">Pilih Unit</option>';
                if (targetUnit) {
                    const option = document.createElement('option');
                    option.value = targetUnit;
                    option.textContent = targetUnit;
                    option.selected = true;
                    unitSelect.appendChild(option);
                }
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', async function() {
            console.log('🚀 DOM Content Loaded - Starting initialization...');
            
            // Periksa autentikasi terlebih dahulu
            // 1. Inisialisasi data halaman sesegera mungkin agar input langsung terisi
            await initializePageData();
            initializeCamera();
            initializeFileUpload();

            // 2. Periksa autentikasi di latar belakang
            const token = localStorage.getItem('token') || sessionStorage.getItem('token');
            let user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user') || '{}');
            
            if (!token) {
                console.log('No valid session token found, redirecting to login...');
                console.warn('No valid session token found, redirecting to login...');
                alert('Session expired. Please login again.');
                window.location.href = '/login';
                return;
            }

            // Jika user data belum lengkap di local storage, ambil dari /api/auth/me
            if (!user || !user.nip || !user.name) {
                try {
                    const meRes = await fetch('/api/auth/me', {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    });
                    if (meRes.ok) {
                        const meData = await meRes.json();
                        if (meData.data) {
                            user = { ...user, ...meData.data };
                            localStorage.setItem('user', JSON.stringify(user));
                            // Update NIP / Petugas jika sebelumnya kosong
                            const nipEl = document.getElementById('nip');
                            if (nipEl && !nipEl.value && user.nip) nipEl.value = user.nip;
                            const petugasNameInput = document.getElementById('petugasNameInput');
                            if (petugasNameInput && !petugasNameInput.value && (user.name || user.nama)) {
                                petugasNameInput.value = user.name || user.nama;
                            }
                        }
                    }
                } catch(e) {
                    console.warn('Failed to refresh user profile:', e);
                }
            }
            
            console.log('User authenticated:', { nip: user.nip, name: user.name });
            console.log('User authenticated:', { nip: user?.nip, name: user?.name || user?.nama });
            
            // Inisialisasi data halaman
            await initializePageData();
            initializeCamera();
            initializeFileUpload();
            
            // Setup form submission handler
            const form = document.getElementById('detailKegiatanForm');
            if (form) {
                console.log('✅ Form found, setting up submission handler...');
                
                // Remove form action and method to prevent default submission
                form.removeAttribute('action');
                form.removeAttribute('method');
                form.onsubmit = null;
                console.log('🧹 Removed form action and method attributes');
                
                form.addEventListener('submit', async function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    event.stopImmediatePropagation();
                    
                    console.log('📝 Form submission started...');
                    
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalText = submitButton.innerHTML;
                    
                    try {
                        // Disable button and show loading
                        submitButton.disabled = true;
                        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                        
                        // Validate required fields before sending
                        const jenisKegiatan = document.getElementById('jenisKegiatan').value;
                        const nip = document.getElementById('nip').value;
                        const unit = document.getElementById('unit').value;
                        const tanggalDibuat = document.getElementById('tanggalDibuat').value;
                        
                        if (!jenisKegiatan || !nip || !unit || !tanggalDibuat) {
                            throw new Error('Semua field wajib harus diisi');
                        }
                        
                        const formData = new FormData();
                        
                        // Add basic fields with proper validation
                        formData.append('jenis_kegiatan', jenisKegiatan);
                        formData.append('nip', nip);
                        formData.append('unit', unit);
                        
                        // Fix date format - ensure it's in Y-m-d H:i:s format
                        let formattedDate;
                        if (tanggalDibuat) {
                            const date = new Date(tanggalDibuat);
                            if (isNaN(date.getTime())) {
                                throw new Error('Format tanggal tidak valid');
                            }
                            formattedDate = date.getFullYear() + '-' + 
                                String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                                String(date.getDate()).padStart(2, '0') + ' ' +
                                String(date.getHours()).padStart(2, '0') + ':' +
                                String(date.getMinutes()).padStart(2, '0') + ':' +
                                String(date.getSeconds()).padStart(2, '0');
                        } else {
                            // Use current datetime if not provided
                            const now = new Date();
                            formattedDate = now.getFullYear() + '-' + 
                                String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                                String(now.getDate()).padStart(2, '0') + ' ' +
                                String(now.getHours()).padStart(2, '0') + ':' +
                                String(now.getMinutes()).padStart(2, '0') + ':' +
                                String(now.getSeconds()).padStart(2, '0');
                        }
                        formData.append('tanggal_dibuat', formattedDate);
                        
                        // Add optional fields
                        const hasilTemuan = document.getElementById('hasilTemuan')?.value || '';
                        if (hasilTemuan) {
                            formData.append('hasil_temuan', hasilTemuan);
                        }
                        
                        // Add signatures if available
                        if (signatures.petugas) {
                            formData.append('signature_pelaksana', signatures.petugas);
                        }
                        if (signatures.kaUnit) {
                            formData.append('signature_pj', signatures.kaUnit);
                        }

                        // Add signee names (free-typing)
                        const namaPetugas = document.getElementById('petugasNameInput')?.value?.trim() || '';
                        if (namaPetugas) {
                            formData.append('nama_petugas', namaPetugas);
                            formData.append('nama_pelaksana', namaPetugas);
                        }
                        const namaKaUnit = document.getElementById('kaUnitNameInput')?.value?.trim() || '';
                        if (namaKaUnit) {
                            formData.append('nama_ka_unit', namaKaUnit);
                            formData.append('nama_pj', namaKaUnit);
                        }
                        
                        // Add existing photos to retain
                        if (existingPhotos && existingPhotos.length > 0) {
                            existingPhotos.forEach((photo, index) => {
                                formData.append(`existing_dokumentasi[${index}]`, photo.path);
                            });
                        }
                        
                        // Add captured photos
                        if (capturedPhotos && capturedPhotos.length > 0) {
                            capturedPhotos.forEach((photo, index) => {
                                if (photo.data) {
                                    formData.append(`captured_photos[${index}]`, photo.data);
                                }
                            });
                        }
                        
                        // Add uploaded files
                        if (uploadedFiles && uploadedFiles.length > 0) {
                            uploadedFiles.forEach((fileData, index) => {
                                if (fileData.file) {
                                    formData.append(`uploaded_files[${index}]`, fileData.file);
                                }
                            });
                        }
                        
                        // Set status
                        formData.append('status', 'submitted');

                        let apiUrl = '/api/detail-jenis-kegiatan';
                        if (isEditMode && editItemId) {
                            apiUrl = `/api/detail-jenis-kegiatan/${editItemId}`;
                            formData.append('_method', 'PUT');
                        }
                        
                        console.log('📤 Sending data to API:', apiUrl);
                        
                        // Check token
                        if (!token) {
                            throw new Error('Token tidak ditemukan. Silakan login ulang.');
                        }
                        
                        const response = await fetch(apiUrl, {
                            method: 'POST',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });
                        
                        console.log('📥 Response status:', response.status);
                        
                        const result = await response.json();
                        console.log('📥 Response data:', result);
                        
                        if (response.ok && result.success) {
                            try {
                                sessionStorage.removeItem('editDetailData');
                            } catch(e) {}

                            const successMsg = isEditMode ? 'Data kegiatan berhasil diperbarui!' : 'Data kegiatan berhasil disimpan!';
                            showNotification(successMsg, 'success');
                            updateStatusBadge('submitted');
                            
                            setTimeout(() => {
                                window.location.href = `/laporan?nip=${nip}`;
                            }, 1200);
                        } else {
                            console.error('❌ API Error:', result);
                            
                            let errorMessage = 'Terjadi kesalahan saat menyimpan data';
                            if (result.message) {
                                errorMessage = result.message;
                            }
                            if (result.errors) {
                                console.error('Validation errors:', result.errors);
                                const errorDetails = Object.entries(result.errors)
                                    .map(([field, messages]) => `${field}: ${Array.isArray(messages) ? messages.join(', ') : messages}`)
                                    .join('\n');
                                errorMessage += ':\n' + errorDetails;
                            }
                            
                            showNotification(errorMessage, 'error');
                        }
                        
                    } catch (error) {
                        console.error('❌ Submit Error:', error);
                        showNotification('Error: ' + error.message, 'error');
                    } finally {
                        // Reset button
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                    }
                    
                    return false;
                }, true);
                
                console.log('✅ Event listener successfully attached with stronger prevention');
            } else {
                console.error('❌ Form with ID "detailKegiatanForm" not found!');
            }
        });

        async function initializePageData() {
            try {
                // Parse URL parameters for auto-fill
                const urlParams = new URLSearchParams(window.location.search);
                const dataParam = urlParams.get('data');
                const idParam = urlParams.get('id');
                const editParam = urlParams.get('edit');

                console.log('URL params:', { dataParam, idParam, editParam });

                // Ambil data user dari localStorage/sessionStorage
                const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user') || '{}');
                const token = localStorage.getItem('token') || sessionStorage.getItem('token');

                // Parse dataParam dengan aman (fallback dual parsing)
                let pageData = null;
                if (dataParam) {
                    try {
                        pageData = JSON.parse(dataParam);
                    } catch (e1) {
                        try {
                            pageData = JSON.parse(decodeURIComponent(dataParam));
                        } catch (e2) {
                            console.error('Error parsing dataParam:', e2);
                        }
                    }
                }
                
                // Jika pageData adalah string (terjadi jika double encoded), parse sekali lagi
                if (typeof pageData === 'string') {
                    try {
                        pageData = JSON.parse(pageData);
                    } catch (e3) {}
                }

                // Auto-fill NIP dari data URL atau session user
                const resolvedNip = pageData?.nip || user?.nip || user?.NIP || urlParams.get('nip') || '';
                if (resolvedNip) {
                    const nipEl = document.getElementById('nip');
                    if (nipEl) nipEl.value = resolvedNip;
                    console.log('Auto-filled NIP:', resolvedNip);
                }

                // Auto-fill Jenis Kegiatan dari data URL atau query param
                const resolvedJenisKegiatan = pageData?.jenis_kegiatan || urlParams.get('jenis_kegiatan') || urlParams.get('jenisKegiatan') || '';
                if (resolvedJenisKegiatan) {
                    const jkEl = document.getElementById('jenisKegiatan');
                    if (jkEl) jkEl.value = resolvedJenisKegiatan;
                    console.log('Auto-filled Jenis Kegiatan:', resolvedJenisKegiatan);
                }

                // Auto-fill Petugas / Pelaksana jika ada
                const resolvedPetugas = pageData?.nama_pelaksana || pageData?.nama_petugas || user?.name || user?.nama || '';
                if (resolvedPetugas) {
                    const petugasInput = document.getElementById('petugasNameInput');
                    if (petugasInput && !petugasInput.value) {
                        petugasInput.value = resolvedPetugas;
                    }
                }

                // Auto-fill Tanggal Kegiatan jika masih kosong dengan waktu lokal saat ini
                const tglEl = document.getElementById('tanggalDibuat');
                if (tglEl && !tglEl.value) {
                    const now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    tglEl.value = now.toISOString().slice(0, 16);
                }

                let editData = null;

                // Check if in Edit Mode
                if (idParam || editParam === 'true') {
                    isEditMode = true;
                    editItemId = idParam;

                    // 1. Try to read cached full record from sessionStorage
                    const cachedEdit = sessionStorage.getItem('editDetailData');
                    if (cachedEdit) {
                        try {
                            const parsed = JSON.parse(cachedEdit);
                            if (!idParam || String(parsed.id) === String(idParam)) {
                                editData = parsed;
                                editItemId = parsed.id;
                            }
                        } catch(e) {
                            console.error('Error parsing cached editDetailData:', e);
                        }
                    }

                    // 2. If not found in cache, fetch from API
                    if (!editData && editItemId) {
                        try {
                            const resp = await fetch(`/api/detail-jenis-kegiatan/${editItemId}`, {
                                headers: {
                                    'Authorization': `Bearer ${token}`,
                                    'Accept': 'application/json'
                                }
                            });
                            if (resp.ok) {
                                const respData = await resp.json();
                                if (respData.success && respData.data) {
                                    editData = respData.data;
                                }
                            }
                        } catch(e) {
                            console.error('Error fetching detail from API:', e);
                        }
                    }

                    // 3. Fallback to URL dataParam if available
                    if (!editData && pageData) {
                        editData = pageData;
                        if (editData.id) editItemId = editData.id;
                    }
                }

                // If Edit Mode with data, populate everything!
                if (isEditMode && editData) {
                    console.log('Populating edit form with data:', editData);

                    // Update Title, Subtitle, Banner
                    const pageTitle = document.getElementById('pageTitle');
                    if (pageTitle) {
                        pageTitle.innerHTML = `<i class="fas fa-edit text-amber-400 me-2"></i>Edit Kegiatan #${editItemId}`;
                    }
                    const pageSubtitle = document.getElementById('pageSubtitle');
                    if (pageSubtitle) {
                        pageSubtitle.textContent = 'Perbarui data laporan kegiatan, tanda tangan, dan foto dokumentasi';
                    }
                    const editNotice = document.getElementById('editModeNotice');
                    if (editNotice) {
                        editNotice.classList.remove('d-none');
                        editNotice.classList.add('d-flex');
                        const editIdBadge = document.getElementById('editIdBadge');
                        if (editIdBadge) editIdBadge.textContent = `ID #${editItemId}`;
                    }
                    const submitBtnText = document.getElementById('submitBtnText');
                    if (submitBtnText) {
                        submitBtnText.textContent = 'Simpan Perubahan';
                    }

                    // Pre-fill Jenis Kegiatan
                    if (editData.jenis_kegiatan) {
                        document.getElementById('jenisKegiatan').value = editData.jenis_kegiatan;
                    }

                    // Pre-fill NIP
                    if (editData.nip) {
                        document.getElementById('nip').value = editData.nip;
                    }

                    // Pre-fill Unit
                    await loadUserUnits(editData.unit);

                    // Pre-fill Tanggal Dibuat
                    if (editData.tanggal_dibuat) {
                        try {
                            const d = new Date(editData.tanggal_dibuat);
                            if (!isNaN(d.getTime())) {
                                const offsetMs = d.getTimezoneOffset() * 60000;
                                const localISOTime = (new Date(d.getTime() - offsetMs)).toISOString().slice(0, 16);
                                document.getElementById('tanggalDibuat').value = localISOTime;
                            }
                        } catch(e) {
                            console.error('Error formatting date:', e);
                        }
                    }

                    // Pre-fill Hasil Temuan
                    if (editData.hasil_temuan) {
                        const temuanEl = document.getElementById('hasilTemuan');
                        if (temuanEl) temuanEl.value = editData.hasil_temuan;
                    }

                    // Pre-fill Signee Names
                    const petugasNameInput = document.getElementById('petugasNameInput');
                    if (petugasNameInput) {
                        petugasNameInput.value = editData.nama_pelaksana || editData.nama_petugas || (user.nama || user.name || '');
                    }
                    const kaUnitNameInput = document.getElementById('kaUnitNameInput');
                    if (kaUnitNameInput) {
                        kaUnitNameInput.value = editData.nama_pj || editData.nama_ka_unit || '';
                    }

                    // Pre-fill Signatures
                    if (editData.signature_pelaksana) {
                        let sig = editData.signature_pelaksana;
                        if (!sig.startsWith('data:image/')) sig = 'data:image/png;base64,' + sig;
                        applySignature('petugas', sig);
                    }
                    if (editData.signature_pj) {
                        let sig = editData.signature_pj;
                        if (!sig.startsWith('data:image/')) sig = 'data:image/png;base64,' + sig;
                        applySignature('kaUnit', sig);
                    }

                    // Pre-fill Documentation Photos
                    existingPhotos = [];
                    let docs = editData.dokumentasi || [];
                    if (typeof docs === 'string') {
                        try { docs = JSON.parse(docs); } catch(e) { docs = [docs]; }
                    }
                    if (Array.isArray(docs)) {
                        docs.forEach((docPath) => {
                            if (!docPath) return;
                            let fullUrl = docPath;
                            if (!fullUrl.startsWith('http://') && !fullUrl.startsWith('https://') && !fullUrl.startsWith('data:')) {
                                let clean = docPath.replace(/^\/+/, '');
                                if (!clean.startsWith('storage/')) {
                                    clean = 'storage/' + clean;
                                }
                                fullUrl = '/' + clean;
                            }
                            existingPhotos.push({
                                path: docPath,
                                url: fullUrl
                            });
                        });
                    }
                    refreshImageDisplay();

                    // Status badge
                    updateStatusBadge(editData.status || 'draft');

                } else {
                    // New item mode
                    const initialUnit = pageData?.unit || user?.ruangan || urlParams.get('unit') || '';
                    await loadUserUnits(initialUnit);

                    const now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    const tglInput = document.getElementById('tanggalDibuat');
                    if (tglInput) tglInput.value = now.toISOString().slice(0, 16);

                    const petugasNameInput = document.getElementById('petugasNameInput');
                    if (petugasNameInput) {
                        petugasNameInput.value = pageData?.nama_pelaksana || pageData?.nama_petugas || user?.nama || user?.name || '';
                    }
                }

                // Jaminan fallback: jika tanggal kegiatan atau nama petugas masih kosong, isi otomatis
                const finalTgl = document.getElementById('tanggalDibuat');
                if (finalTgl && !finalTgl.value) {
                    const now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    finalTgl.value = now.toISOString().slice(0, 16);
                }

                const finalPetugas = document.getElementById('petugasNameInput');
                if (finalPetugas && !finalPetugas.value) {
                    finalPetugas.value = pageData?.nama_pelaksana || pageData?.nama_petugas || user?.nama || user?.name || '';
                }

                updateSignatureBadges();

            } catch (error) {
                console.error('Error initializing page data:', error);
                if (typeof showNotification === 'function') {
                    showNotification('Error initializing page: ' + error.message, 'error');
                }
            }
        }

        // Camera functionality - Professional Mobile Camera System
        let tempCapturedDataUrl = null;

        function initializeCamera() {
            const startCameraBtn = document.getElementById('startCameraBtn');
            const captureBtn = document.getElementById('capturePhoto');
            const retakeBtn = document.getElementById('retakePhoto');
            const acceptBtn = document.getElementById('acceptPhoto');
            const switchBtn = document.getElementById('switchCamera');
            const topSwitchBtn = document.getElementById('topSwitchCameraBtn');
            const closeBtn = document.getElementById('closeCameraBtn');
            
            const video = document.getElementById('cameraVideo');
            const canvas = document.getElementById('photoCanvas');
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('cameraPlaceholder');
            const viewfinderOverlay = document.getElementById('viewfinderOverlay');
            const cameraTopBar = document.getElementById('cameraTopBar');
            const cameraBottomDeck = document.getElementById('cameraBottomDeck');
            const photoReviewDeck = document.getElementById('photoReviewDeck');
            const camStatusText = document.getElementById('camStatusText');
            const shutterFlash = document.getElementById('shutterFlash');

            let currentFacingMode = 'environment';
            let cameraStarted = false;

            if (startCameraBtn) {
                startCameraBtn.addEventListener('click', async () => {
                    await startCamera();
                });
            }

            async function startCamera() {
                try {
                    if (camStatusText) camStatusText.textContent = 'Menyiapkan kamera...';
                    
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
                    }

                    const constraints = {
                        video: {
                            facingMode: { ideal: currentFacingMode },
                            width: { ideal: 1920 },
                            height: { ideal: 1080 }
                        }
                    };

                    stream = await navigator.mediaDevices.getUserMedia(constraints);
                    video.srcObject = stream;
                    
                    // Mirroring for front camera
                    if (currentFacingMode === 'user') {
                        video.classList.add('mirror-mode');
                    } else {
                        video.classList.remove('mirror-mode');
                    }

                    video.style.display = 'block';
                    if (placeholder) placeholder.style.display = 'none';
                    if (preview) preview.style.display = 'none';
                    if (photoReviewDeck) photoReviewDeck.style.display = 'none';

                    if (viewfinderOverlay) viewfinderOverlay.style.display = 'block';
                    if (cameraTopBar) cameraTopBar.style.display = 'flex';
                    if (cameraBottomDeck) cameraBottomDeck.style.display = 'flex';

                    cameraStarted = true;
                    if (camStatusText) camStatusText.textContent = 'Kamera Aktif • Siap Membidik';

                } catch (error) {
                    console.error('Error accessing camera:', error);
                    showNotification('Tidak dapat mengakses kamera: ' + (error.message || 'Periksa izin akses kamera Anda'), 'error');
                    stopCamera();
                }
            }

            function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }

                if (video) {
                    video.style.display = 'none';
                    video.classList.remove('mirror-mode');
                }
                if (preview) preview.style.display = 'none';
                if (viewfinderOverlay) viewfinderOverlay.style.display = 'none';
                if (cameraTopBar) cameraTopBar.style.display = 'none';
                if (cameraBottomDeck) cameraBottomDeck.style.display = 'none';
                if (photoReviewDeck) photoReviewDeck.style.display = 'none';
                if (placeholder) placeholder.style.display = 'flex';

                cameraStarted = false;
                tempCapturedDataUrl = null;
            }

            // Shutter Button Click
            if (captureBtn) {
                captureBtn.addEventListener('click', () => {
                    if (!cameraStarted || !video.videoWidth) return;

                    // Tactile white flash animation
                    if (shutterFlash) {
                        shutterFlash.classList.add('active');
                        setTimeout(() => shutterFlash.classList.remove('active'), 160);
                    }

                    const context = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;

                    // Mirror front camera frame horizontally
                    if (currentFacingMode === 'user') {
                        context.translate(canvas.width, 0);
                        context.scale(-1, 1);
                    }
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    tempCapturedDataUrl = canvas.toDataURL('image/jpeg', 0.92);

                    preview.src = tempCapturedDataUrl;
                    preview.style.display = 'block';
                    video.style.display = 'none';
                    if (viewfinderOverlay) viewfinderOverlay.style.display = 'none';
                    if (cameraBottomDeck) cameraBottomDeck.style.display = 'none';
                    if (photoReviewDeck) photoReviewDeck.style.display = 'flex';

                    if (camStatusText) camStatusText.textContent = 'Tinjau Hasil Foto';
                });
            }

            // Accept / Use Photo Click
            if (acceptBtn) {
                acceptBtn.addEventListener('click', () => {
                    if (!tempCapturedDataUrl) return;

                    const photoData = {
                        data: tempCapturedDataUrl,
                        timestamp: new Date().toISOString(),
                        camera: currentFacingMode,
                        size: tempCapturedDataUrl.length,
                        type: 'capture'
                    };

                    capturedPhotos.push(photoData);
                    tempCapturedDataUrl = null;
                    refreshImageDisplay();
                    showNotification('Foto berhasil ditambahkan ke lampiran dokumentasi!', 'success');
                    stopCamera();
                });
            }

            // Retake Photo Click
            if (retakeBtn) {
                retakeBtn.addEventListener('click', () => {
                    tempCapturedDataUrl = null;
                    preview.style.display = 'none';
                    video.style.display = 'block';
                    if (viewfinderOverlay) viewfinderOverlay.style.display = 'block';
                    if (photoReviewDeck) photoReviewDeck.style.display = 'none';
                    if (cameraBottomDeck) cameraBottomDeck.style.display = 'flex';
                    if (camStatusText) camStatusText.textContent = 'Kamera Aktif • Siap Membidik';
                });
            }

            // Switch Camera (Front/Back)
            async function flipCamera() {
                currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
                const icons = document.querySelectorAll('#switchCamera i, #topSwitchCameraBtn i');
                icons.forEach(ic => ic.classList.add('fa-spin'));
                setTimeout(() => {
                    icons.forEach(ic => ic.classList.remove('fa-spin'));
                }, 600);

                if (cameraStarted) {
                    await startCamera();
                }
            }

            if (switchBtn) switchBtn.addEventListener('click', flipCamera);
            if (topSwitchBtn) topSwitchBtn.addEventListener('click', flipCamera);
            if (closeBtn) closeBtn.addEventListener('click', stopCamera);
        }

        // File upload functionality
        function initializeFileUpload() {
            const fileInput = document.getElementById('fileInput');

            if (fileInput) {
                fileInput.addEventListener('change', (event) => {
                    const files = Array.from(event.target.files);
                    if (!files || files.length === 0) return;
                    
                    let addedCount = 0;
                    files.forEach(file => {
                        if (file.type.startsWith('image/') && file.size <= 5 * 1024 * 1024) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                const imageData = {
                                    file: file,
                                    data: e.target.result,
                                    name: file.name,
                                    type: 'upload',
                                    timestamp: new Date().toISOString()
                                };
                                uploadedFiles.push(imageData);
                                refreshImageDisplay();
                            };
                            reader.readAsDataURL(file);
                            addedCount++;
                        } else {
                            showNotification(`File ${file.name} melebihi 5MB atau bukan format gambar valid.`, 'error');
                        }
                    });

                    if (addedCount > 0) {
                        showNotification(`${addedCount} foto berhasil ditambahkan dari galeri`, 'success');
                    }
                    fileInput.value = '';
                });
            }
        }
        
        function removeImage(type, index) {
            if (type === 'existing') {
                existingPhotos.splice(index, 1);
            } else if (type === 'capture') {
                capturedPhotos.splice(index, 1);
            } else {
                uploadedFiles.splice(index, 1);
            }
            refreshImageDisplay();
            showNotification('Foto berhasil dihapus dari lampiran', 'info');
        }
        
        function refreshImageDisplay() {
            const allImagesContainer = document.getElementById('allImagesPreview');
            const badge = document.getElementById('photoCountBadge');
            if (!allImagesContainer) return;

            const totalCount = (existingPhotos ? existingPhotos.length : 0) + 
                               (capturedPhotos ? capturedPhotos.length : 0) + 
                               (uploadedFiles ? uploadedFiles.length : 0);
            if (badge) {
                badge.textContent = `${totalCount} Lampiran`;
            }

            allImagesContainer.innerHTML = '';

            if (totalCount === 0) {
                allImagesContainer.innerHTML = `
                    <div class="p-3 text-center rounded-xl border border-dashed border-white/15 bg-slate-900/40 text-slate-400 text-xs w-100" style="grid-column: 1 / -1;">
                        <i class="fas fa-images text-slate-500 mb-1 d-block" style="font-size: 20px;"></i>
                        Belum ada foto dokumentasi terlampir. Buka kamera atau unggah dari galeri.
                    </div>
                `;
                return;
            }

            // Display existing saved photos from server
            if (existingPhotos && existingPhotos.length > 0) {
                existingPhotos.forEach((photo, index) => {
                    const card = createPhotoCard({ data: photo.url, name: `Foto Tersimpan ${index + 1}` }, 'existing', index);
                    allImagesContainer.appendChild(card);
                });
            }

            // Display captured photos
            if (capturedPhotos && capturedPhotos.length > 0) {
                capturedPhotos.forEach((photo, index) => {
                    const card = createPhotoCard(photo, 'capture', index);
                    allImagesContainer.appendChild(card);
                });
            }

            // Display uploaded files
            if (uploadedFiles && uploadedFiles.length > 0) {
                uploadedFiles.forEach((file, index) => {
                    const card = createPhotoCard(file, 'upload', index);
                    allImagesContainer.appendChild(card);
                });
            }
        }

        function createPhotoCard(imageData, type, index) {
            const card = document.createElement('div');
            card.className = 'photo-card-pro';
            
            const timeStr = imageData.timestamp ? 
                new Date(imageData.timestamp).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) : '';
            
            let badgeClass = 'source-camera';
            let badgeIcon = 'fa-camera';
            let badgeLabel = 'Kamera';

            if (type === 'upload') {
                badgeClass = 'source-upload';
                badgeIcon = 'fa-image';
                badgeLabel = 'Galeri';
            } else if (type === 'existing') {
                badgeClass = 'source-existing';
                badgeIcon = 'fa-cloud';
                badgeLabel = 'Tersimpan';
            }

            const title = type === 'existing' ? (imageData.name || 'Foto Tersimpan') : (type === 'capture' ? 'Foto Kamera' : (imageData.name || 'Foto Galeri'));

            card.innerHTML = `
                <img src="${imageData.data}" alt="${title}" loading="lazy" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' width=\\'40\\' height=\\'40\\' viewBox=\\'0 0 24 24\\' fill=\\'none\\' stroke=\\'%2364748b\\' stroke-width=\\'1.5\\'><rect width=\\'18\\' height=\\'18\\' x=\\'3\\' y=\\'3\\' rx=\\'2\\'/><circle cx=\\'9\\' cy=\\'9\\' r=\\'2\\'/><path d=\\'m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21\\'/></svg>';">
                <span class="photo-card-source ${badgeClass}">
                    <i class="fas ${badgeIcon} me-1"></i>${badgeLabel}
                </span>
                <button type="button" class="photo-card-delete" onclick="event.stopPropagation(); removeImage('${type}', ${index})" title="Hapus foto">
                    <i class="fas fa-times"></i>
                </button>
                <div class="photo-card-time">
                    <i class="far fa-clock me-1"></i>${timeStr || (type === 'existing' ? 'Tersimpan' : 'Baru')}
                </div>
            `;

            card.addEventListener('click', () => {
                openLightbox(imageData.data, title);
            });

            return card;
        }

        // Lightbox modal functions
        function openLightbox(imgSrc, caption) {
            const modal = document.getElementById('photoLightboxModal');
            const img = document.getElementById('lightboxImage');
            const cap = document.getElementById('lightboxCaption');
            if (modal && img) {
                img.src = imgSrc;
                if (cap) cap.textContent = caption || '';
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        function closeLightbox() {
            const modal = document.getElementById('photoLightboxModal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });

        function goBack() {
            // Stop camera if running
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            
            const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user') || '{}');
            if (document.referrer && (document.referrer.includes('laporan') || document.referrer.includes('user-dashboard'))) {
            if (document.referrer && (document.referrer.includes('laporan') || document.referrer.includes('user-dashboard') || document.referrer.includes('rekap'))) {
                window.history.back();
            } else if (user.nip) {
                window.location.href = `/laporan?nip=${user.nip}`;
                window.location.href = `/laporan-kinerja?nip=${user.nip}`;
            } else {
                window.location.href = '/dashboard';
                window.location.href = '/user-dashboard';
            }
        }

        async function saveDraft() {
            const form = document.getElementById('detailKegiatanForm');
            if (!form) return;

            const btnSaveDraft = document.getElementById('btnSaveDraft');
            const originalDraftContent = btnSaveDraft ? btnSaveDraft.innerHTML : '';

            const jenisKegiatan = document.getElementById('jenisKegiatan')?.value?.trim();
            const nip = document.getElementById('nip')?.value?.trim();
            const unit = document.getElementById('unit')?.value?.trim();
            const tanggalDibuat = document.getElementById('tanggalDibuat')?.value;

            if (!jenisKegiatan || !nip) {
                showNotification('Jenis Kegiatan dan NIP wajib terisi untuk menyimpan draft.', 'warning');
                return;
            }

            if (btnSaveDraft) {
                btnSaveDraft.disabled = true;
                btnSaveDraft.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
            }

            const formData = new FormData();
            formData.append('jenis_kegiatan', jenisKegiatan);
            formData.append('nip', nip);
            formData.append('unit', unit || '');
            
            if (tanggalDibuat) {
                const date = new Date(tanggalDibuat);
                if (!isNaN(date.getTime())) {
                    const formattedDate = date.getFullYear() + '-' + 
                        String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                        String(date.getDate()).padStart(2, '0') + ' ' +
                        String(date.getHours()).padStart(2, '0') + ':' +
                        String(date.getMinutes()).padStart(2, '0') + ':' +
                        String(date.getSeconds()).padStart(2, '0');
                    formData.append('tanggal_dibuat', formattedDate);
                }
            }

            const hasilTemuan = document.getElementById('hasilTemuan')?.value || '';
            if (hasilTemuan) formData.append('hasil_temuan', hasilTemuan);

            if (signatures.petugas) formData.append('signature_pelaksana', signatures.petugas);
            if (signatures.kaUnit) formData.append('signature_pj', signatures.kaUnit);

            const namaPetugas = document.getElementById('petugasNameInput')?.value?.trim() || '';
            if (namaPetugas) {
                formData.append('nama_petugas', namaPetugas);
                formData.append('nama_pelaksana', namaPetugas);
            }
            const namaKaUnit = document.getElementById('kaUnitNameInput')?.value?.trim() || '';
            if (namaKaUnit) {
                formData.append('nama_ka_unit', namaKaUnit);
                formData.append('nama_pj', namaKaUnit);
            }

            if (existingPhotos && existingPhotos.length > 0) {
                existingPhotos.forEach((photo, index) => {
                    formData.append(`existing_dokumentasi[${index}]`, photo.path);
                });
            }

            if (capturedPhotos && capturedPhotos.length > 0) {
                capturedPhotos.forEach((photo, index) => {
                    if (photo.data) formData.append(`captured_photos[${index}]`, photo.data);
                });
            }

            if (uploadedFiles && uploadedFiles.length > 0) {
                uploadedFiles.forEach((fileData, index) => {
                    if (fileData.file) formData.append(`uploaded_files[${index}]`, fileData.file);
                });
            }

            formData.append('status', 'draft');

            let apiUrl = '/api/detail-jenis-kegiatan';
            if (isEditMode && editItemId) {
                apiUrl = `/api/detail-jenis-kegiatan/${editItemId}`;
                formData.append('_method', 'PUT');
            }

            try {
                const token = localStorage.getItem('token') || sessionStorage.getItem('token');
                if (!token) {
                    showNotification('Sesi telah berakhir. Silakan login kembali.', 'warning');
                    setTimeout(() => { window.location.href = '/login'; }, 1500);
                    return;
                }

                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = await response.json();
                if (response.ok && result.success) {
                    try { sessionStorage.removeItem('editDetailData'); } catch(e) {}
                    showNotification('Draft berhasil disimpan!', 'success');
                    updateStatusBadge('draft');
                    if (result.data && result.data.id) {
                        isEditMode = true;
                        editItemId = result.data.id;
                        try {
                            const newUrl = new URL(window.location.href);
                            newUrl.searchParams.set('id', result.data.id);
                            window.history.replaceState({}, '', newUrl.toString());
                        } catch(e) {}
                    }
                } else {
                    let errMsg = result.message || 'Terjadi kesalahan saat menyimpan draft';
                    if (result.errors) {
                        const errorDetails = Object.entries(result.errors)
                            .map(([field, messages]) => `${field}: ${Array.isArray(messages) ? messages.join(', ') : messages}`)
                            .join('\n');
                        errMsg += ':\n' + errorDetails;
                    }
                    showNotification(errMsg, 'error');
                }
            } catch (error) {
                console.error('Error saving draft:', error);
                showNotification('Terjadi kesalahan: ' + error.message, 'error');
            } finally {
                if (btnSaveDraft) {
                    btnSaveDraft.disabled = false;
                    btnSaveDraft.innerHTML = originalDraftContent;
                }
            }
        }

        function updateStatusBadge(status) {
            const badge = document.getElementById('statusBadge');
            if (badge) {
                badge.className = `status-badge status-${status}`;
                badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            }
        }

        // Form submission is now handled in the DOMContentLoaded event
        
        // Add notification function
        function showNotification(message, type = 'info') {
            const existing = document.querySelectorAll('.app-toast-notification');
            existing.forEach(el => el.remove());

            let bgGradient = 'linear-gradient(135deg, #1e293b, #0f172a)';
            let borderColor = 'rgba(255, 255, 255, 0.2)';
            let iconClass = 'fa-info-circle';
            let iconColor = '#38bdf8';
            let title = 'Informasi';

            if (type === 'success') {
                bgGradient = 'linear-gradient(135deg, #064e3b, #022c22)';
                borderColor = 'rgba(16, 185, 129, 0.5)';
                iconClass = 'fa-circle-check';
                iconColor = '#34d399';
                title = 'Berhasil';
            } else if (type === 'error') {
                bgGradient = 'linear-gradient(135deg, #881337, #4c0519)';
                borderColor = 'rgba(244, 63, 94, 0.5)';
                iconClass = 'fa-circle-xmark';
                iconColor = '#fb7185';
                title = 'Gagal';
            } else if (type === 'warning') {
                bgGradient = 'linear-gradient(135deg, #78350f, #451a03)';
                borderColor = 'rgba(245, 158, 11, 0.5)';
                iconClass = 'fa-triangle-exclamation';
                iconColor = '#fbbf24';
                title = 'Perhatian';
            }

            const toast = document.createElement('div');
            toast.className = 'app-toast-notification';
            toast.style.cssText = `
                position: fixed;
                top: 24px;
                right: 24px;
                z-index: 999999;
                min-width: 300px;
                max-width: 450px;
                background: ${bgGradient};
                border: 1px solid ${borderColor};
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5), 0 8px 10px -6px rgba(0, 0, 0, 0.5);
                border-radius: 12px;
                padding: 14px 18px;
                color: #ffffff;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                transform: translateX(120%);
                transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
                opacity: 0;
            `;

            toast.innerHTML = `
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="font-size: 20px; color: ${iconColor}; flex-shrink: 0; margin-top: 2px;">
                        <i class="fas ${iconClass}"></i>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; color: ${iconColor};">
                            ${title}
                        </div>
                        <div style="font-size: 13.5px; line-height: 1.4; color: #f1f5f9; white-space: pre-line; word-break: break-word;">
                            ${message}
                        </div>
                    </div>
                    <button type="button" onclick="this.closest('.app-toast-notification').remove()" style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 16px; padding: 0; margin-left: 6px; line-height: 1;" title="Tutup">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            document.body.appendChild(toast);

            requestAnimationFrame(() => {
                toast.style.transform = 'translateX(0)';
                toast.style.opacity = '1';
            });

            const timer = setTimeout(() => {
                toast.style.transform = 'translateX(120%)';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 350);
            }, 5000);

            toast.addEventListener('mouseenter', () => clearTimeout(timer));
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>

    <!-- Photo Lightbox Modal -->
    <div id="photoLightboxModal" class="photo-lightbox-modal" style="display: none;" onclick="closeLightbox()">
        <div class="photo-lightbox-content" onclick="event.stopPropagation()">
            <button type="button" class="photo-lightbox-close" onclick="closeLightbox()" title="Tutup">
                <i class="fas fa-times"></i>
            </button>
            <img id="lightboxImage" src="" alt="Pratinjau Foto">
            <div id="lightboxCaption" class="mt-2 text-center text-xs text-slate-300"></div>
        </div>
    </div>

    @include('partials.pwa-prompt')
</body>
</html>
