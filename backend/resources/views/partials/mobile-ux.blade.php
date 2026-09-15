<style>
    /* Shared mobile UX guardrails for all Blade pages. */
    html { -webkit-text-size-adjust: 100%; text-size-adjust: 100%; scroll-behavior: smooth; }
    body { min-width: 0; overflow-x: clip; }
    img, video, canvas, svg { max-width: 100%; }
    button, a, input, select, textarea { touch-action: manipulation; }
    button:focus-visible, a:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
        outline: 3px solid rgba(255, 255, 255, 0.9); outline-offset: 3px;
    }
    input, select, textarea { max-width: 100%; font-size: 16px; }
    textarea { resize: vertical; }
    .overflow-x-auto, .table-container, .table-responsive {
        -webkit-overflow-scrolling: touch; overscroll-behavior-inline: contain; scrollbar-gutter: stable;
    }
    .modal, [id$="Modal"] { overscroll-behavior: contain; }
    .notification, [class*="notification"] { max-width: calc(100vw - 2rem) !important; overflow-wrap: anywhere; }

    @media (max-width: 767px) {
        body { min-height: 100dvh; }
        body > .relative,
        body > .relative > div,
        .max-w-md,
        .max-w-sm,
        .glass-effect,
        form {
            width: 100%;
            max-width: 100% !important;
            min-width: 0;
            box-sizing: border-box;
        }
        button, a.btn, input:not([type="checkbox"]):not([type="radio"]), select { min-height: 44px; }
        h1 { overflow-wrap: anywhere; }
        #sidebar {
            width: min(19rem, calc(100vw - 3rem)) !important; height: 100dvh !important;
            min-height: 100dvh !important; overflow-y: auto; overscroll-behavior: contain;
            padding-bottom: calc(1rem + env(safe-area-inset-bottom)) !important;
        }
        #mobileBackdrop, #sidebarOverlay { height: 100dvh; }
        main { min-width: 0; }
        .container, .container-fluid { width: 100%; max-width: 100%; padding-left: 1rem; padding-right: 1rem; }
        .header, .morphism-card, .glass-card, .table-container { border-radius: 1rem; }
        .header { padding: 1.25rem; margin-bottom: 1rem; }
        .header h1 { font-size: clamp(1.65rem, 8vw, 2rem); line-height: 1.15; }
        .stats-grid { grid-template-columns: 1fr; gap: 0.75rem; margin-bottom: 1rem; }
        .stat-card { padding: 1rem; }
        .table-container { padding: 1rem; margin-bottom: 1rem; }
        .table-container table, .overflow-x-auto > table, .table-responsive > table { min-width: 42rem; }
        th, td { white-space: nowrap; }
        .table-controls, .date-filter-container {
            width: 100%; flex-direction: column !important; align-items: stretch !important;
        }
        .table-controls > *, .date-filter-container > *, .search-box, .filter-select,
        .date-filter-container input, .date-filter-container button { width: 100% !important; }
        .pagination { max-width: 100%; justify-content: flex-start; overflow-x: auto; padding-bottom: 0.5rem; }
        .data-section > .flex.items-center.justify-between {
            align-items: stretch; flex-direction: column; gap: 0.75rem;
        }
        .data-section > .flex.items-center.justify-between button { width: 100%; }
        form .flex.items-center.justify-between { flex-wrap: wrap; gap: 0.75rem; }
        .modal, [id$="Modal"] {
            overflow-y: auto; padding: max(0.75rem, env(safe-area-inset-top)) 0.75rem max(0.75rem, env(safe-area-inset-bottom));
        }
        .modal > .flex, [id$="Modal"] > .flex {
            min-height: auto !important; align-items: flex-start !important; padding: 0 !important;
        }
        .modal-content { max-height: calc(100dvh - 1.5rem); overflow-y: auto; padding: 1.25rem !important; }
        .pwa-install-btn {
            right: max(0.75rem, env(safe-area-inset-right)) !important;
            bottom: max(0.75rem, env(safe-area-inset-bottom)) !important;
        }
        .signature-actions, form > .d-flex.justify-content-end {
            display: grid !important; grid-template-columns: 1fr; gap: 0.75rem !important;
        }
        .signature-actions .btn, form > .d-flex.justify-content-end .btn {
            width: 100%; margin: 0 !important;
        }
    }

    @media (max-width: 420px) {
        .glass-effect, .morphism-card, .glass-card { padding: 1rem !important; }
        .image-item { width: calc(50% - 0.3125rem) !important; height: auto !important; aspect-ratio: 1; }
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            scroll-behavior: auto !important; animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important; transition-duration: 0.01ms !important;
        }
    }
</style>
