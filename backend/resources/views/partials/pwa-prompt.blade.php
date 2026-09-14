<!-- PWA Floating Install Button -->
<button type="button" 
        id="globalPwaInstallBtn" 
        class="global-pwa-btn" 
        style="display: none;" 
        aria-label="Install Aplikasi e-Kinerja" 
        title="Install Aplikasi e-Kinerja">
    <div class="pwa-btn-icon">
        <i class="fas fa-download"></i>
    </div>
    <span class="pwa-btn-text">Install Aplikasi</span>
</button>

<!-- PWA Install Modal -->
<div id="globalPwaModal" class="global-pwa-modal-backdrop" style="display: none;" role="dialog" aria-modal="true">
    <div class="global-pwa-modal-card">
        <button type="button" class="pwa-modal-close" id="globalPwaModalClose" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="pwa-modal-header">
            <div class="pwa-app-icon">
                <img src="/icons/icon-192x192.png" alt="Logo e-Kinerja" width="64" height="64">
            </div>
            <h3 class="pwa-modal-title">Install Aplikasi e-Kinerja</h3>
            <p class="pwa-modal-desc">Pasang e-Kinerja langsung di perangkat Anda untuk akses lebih cepat, praktis, dan dapat dibuka seperti aplikasi native tanpa perlu membuka browser.</p>
        </div>

        <!-- Fitur Unggulan -->
        <div class="pwa-features-list">
            <div class="pwa-feature-item">
                <div class="pwa-feature-icon"><i class="fas fa-bolt"></i></div>
                <div>
                    <strong>Akses Cepat</strong>
                    <span>Buka langsung dari layar utama perangkat</span>
                </div>
            </div>
            <div class="pwa-feature-item">
                <div class="pwa-feature-icon"><i class="fas fa-shield-halved"></i></div>
                <div>
                    <strong>Aman & Ringan</strong>
                    <span>Hemat memori dan tidak membebani penyimpanan</span>
                </div>
            </div>
            <div class="pwa-feature-item">
                <div class="pwa-feature-icon"><i class="fas fa-wifi"></i></div>
                <div>
                    <strong>Siaga Offline</strong>
                    <span>Tetap menampilkan halaman status saat tanpa internet</span>
                </div>
            </div>
        </div>

        <!-- iOS Instructions (Hanya tampil di iOS) -->
        <div id="pwaIosGuide" class="pwa-ios-guide" style="display: none;">
            <p class="pwa-ios-text">
                <i class="fab fa-apple me-1"></i> Untuk pengguna iPhone / iPad:
                <br>1. Ketuk tombol <strong>Bagikan / Share</strong> <i class="fas fa-arrow-up-from-bracket mx-1"></i> di menu Safari.
                <br>2. Gulir ke bawah lalu pilih <strong>Tambah ke Layar Utama (Add to Home Screen)</strong>.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="pwa-modal-actions">
            <button type="button" id="globalPwaModalCancel" class="pwa-btn-secondary">Nanti Saja</button>
            <button type="button" id="globalPwaModalConfirm" class="pwa-btn-primary">
                <i class="fas fa-download me-1.5"></i>
                <span>Install Sekarang</span>
            </button>
        </div>
    </div>
</div>

<style>
    /* Styling PWA Floating Button & Modal */
    .global-pwa-btn {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 99990;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 18px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 9999px;
        box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.5), 0 8px 10px -6px rgba(0, 0, 0, 0.3);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s ease;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
    .global-pwa-btn:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 14px 28px -5px rgba(16, 185, 129, 0.6), 0 10px 10px -5px rgba(0, 0, 0, 0.3);
    }
    .global-pwa-btn:active {
        transform: translateY(0) scale(0.98);
    }
    .pwa-btn-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
    }

    /* Modal Backdrop */
    .global-pwa-modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .global-pwa-modal-backdrop.show {
        opacity: 1;
    }

    /* Modal Card */
    .global-pwa-modal-card {
        position: relative;
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 20px;
        padding: 24px 22px;
        max-width: 420px;
        width: 100%;
        color: #ffffff;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
        transform: scale(0.95);
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    .global-pwa-modal-backdrop.show .global-pwa-modal-card {
        transform: scale(1);
    }
    .pwa-modal-close {
        position: absolute;
        top: 14px;
        right: 14px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #94a3b8;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.15s ease;
    }
    .pwa-modal-close:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }

    .pwa-modal-header {
        text-align: center;
        margin-bottom: 18px;
    }
    .pwa-app-icon img {
        border-radius: 16px;
        box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.3);
        margin-bottom: 12px;
    }
    .pwa-modal-title {
        font-size: 18px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 6px;
    }
    .pwa-modal-desc {
        font-size: 13px;
        color: #94a3b8;
        line-height: 1.5;
    }

    .pwa-features-list {
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 14px;
        padding: 12px 14px;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .pwa-feature-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 12.5px;
    }
    .pwa-feature-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .pwa-feature-item strong {
        display: block;
        color: #f1f5f9;
        font-weight: 600;
        margin-bottom: 1px;
    }
    .pwa-feature-item span {
        color: #94a3b8;
        line-height: 1.3;
    }

    .pwa-ios-guide {
        background: rgba(56, 189, 248, 0.1);
        border: 1px solid rgba(56, 189, 248, 0.25);
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 16px;
        font-size: 12px;
        color: #e0f2fe;
        line-height: 1.5;
        text-align: left;
    }

    .pwa-modal-actions {
        display: flex;
        gap: 10px;
    }
    .pwa-btn-secondary {
        flex: 1;
        padding: 11px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #cbd5e1;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s ease;
    }
    .pwa-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
    }
    .pwa-btn-primary {
        flex: 1.4;
        padding: 11px;
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        color: #ffffff;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 8px 16px -4px rgba(16, 185, 129, 0.4);
        transition: transform 0.15s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pwa-btn-primary:active {
        transform: scale(0.98);
    }

    @media (max-width: 480px) {
        .global-pwa-btn {
            bottom: max(16px, env(safe-area-inset-bottom));
            right: 16px;
            padding: 9px 15px;
            font-size: 12.5px;
        }
        .global-pwa-modal-card {
            padding: 20px 16px;
        }
    }
</style>

<script>
    (function() {
        let deferredPrompt = null;
        const pwaBtn = document.getElementById('globalPwaInstallBtn');
        const pwaModal = document.getElementById('globalPwaModal');
        const pwaClose = document.getElementById('globalPwaModalClose');
        const pwaCancel = document.getElementById('globalPwaModalCancel');
        const pwaConfirm = document.getElementById('globalPwaModalConfirm');
        const pwaIosGuide = document.getElementById('pwaIosGuide');

        // 1. Pendaftaran Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((reg) => {
                        console.log('[PWA] Service Worker terdaftar:', reg.scope);
                    })
                    .catch((err) => {
                        console.warn('[PWA] Gagal mendaftarkan Service Worker:', err);
                    });
            });
        }

        // Deteksi apakah sudah terpasang (Standalone mode)
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || 
                             window.navigator.standalone === true ||
                             document.referrer.includes('android-app://');

        if (isStandalone) {
            console.log('[PWA] Aplikasi berjalan dalam mode standalone (terpasang).');
            return;
        }

        // Deteksi iOS Safari
        const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        const isSafari = /Safari/.test(navigator.userAgent) && !/Chrome|CriOS|FxiOS|EdgiOS/.test(navigator.userAgent);

        function showModal() {
            if (!pwaModal) return;
            pwaModal.style.display = 'flex';
            requestAnimationFrame(() => pwaModal.classList.add('show'));
        }

        function hideModal() {
            if (!pwaModal) return;
            pwaModal.classList.remove('show');
            setTimeout(() => { pwaModal.style.display = 'none'; }, 250);
        }

        // 2. Tangkap event beforeinstallprompt (Android / Chrome / Edge / Desktop)
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            console.log('[PWA] Event beforeinstallprompt diterima.');

            // Tampilkan tombol instalasi
            if (pwaBtn) {
                pwaBtn.style.display = 'inline-flex';
            }
        });

        // 3. Fallback jika di iOS Safari
        if (isIos && isSafari && !isStandalone) {
            // Tampilkan tombol untuk membuka panduan iOS jika belum ditutup sebelumnya
            const dismissed = sessionStorage.getItem('pwa_ios_dismissed');
            if (!dismissed && pwaBtn) {
                pwaBtn.style.display = 'inline-flex';
                if (pwaIosGuide) pwaIosGuide.style.display = 'block';
                if (pwaConfirm) pwaConfirm.style.display = 'none'; // iOS tidak mendukung prompt API
            }
        }

        // 4. Klik tombol install mengambang
        if (pwaBtn) {
            pwaBtn.addEventListener('click', () => {
                showModal();
            });
        }

        // 5. Tutup modal
        if (pwaClose) pwaClose.addEventListener('click', hideModal);
        if (pwaCancel) {
            pwaCancel.addEventListener('click', () => {
                hideModal();
                if (isIos) sessionStorage.setItem('pwa_ios_dismissed', 'true');
            });
        }
        if (pwaModal) {
            pwaModal.addEventListener('click', (e) => {
                if (e.target === pwaModal) hideModal();
            });
        }

        // 6. Konfirmasi install (Panggil Prompt Browser Native)
        if (pwaConfirm) {
            pwaConfirm.addEventListener('click', async () => {
                if (!deferredPrompt) {
                    hideModal();
                    return;
                }

                deferredPrompt.prompt();
                const choiceResult = await deferredPrompt.userChoice;
                console.log('[PWA] User response:', choiceResult.outcome);

                deferredPrompt = null;
                hideModal();

                if (choiceResult.outcome === 'accepted') {
                    if (pwaBtn) pwaBtn.style.display = 'none';
                }
            });
        }

        // 7. Event ketika aplikasi sukses terpasang
        window.addEventListener('appinstalled', () => {
            console.log('[PWA] Aplikasi e-Kinerja berhasil diinstall.');
            if (pwaBtn) pwaBtn.style.display = 'none';
            hideModal();
        });
    })();
</script>

