/**
 * Service Worker - e-Kinerja Progressive Web App (PWA)
 * Version: 2.7.0
 * Version: 2.8.0
 */

const CACHE_NAME = 'e-kinerja-v2.7';
const CACHE_NAME = 'e-kinerja-v2.8';

// Aset statis inti yang wajib tersedia untuk offline shell
const PRECACHE_ASSETS = [
    '/offline.html',
    '/manifest.json',
    '/favicon.ico',
    '/icons/icon-72x72.png',
    '/icons/icon-96x96.png',
    '/icons/icon-128x128.png',
    '/icons/icon-144x144.png',
    '/icons/icon-152x152.png',
    '/icons/icon-192x192.png',
    '/icons/icon-384x384.png',
    '/icons/icon-512x512.png',
    '/icons/icon-maskable-192x192.png',
    '/icons/icon-maskable-512x512.png',
    '/icons/apple-touch-icon.png'
];

// Install event - Pre-cache core shell
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('[ServiceWorker] Pre-caching core offline assets...');
                // Gunakan addAll dengan toleransi kegagalan parsial
                return Promise.allSettled(
                    PRECACHE_ASSETS.map((url) => cache.add(url).catch(err => {
                        console.warn('[ServiceWorker] Gagal cache asset:', url, err);
                    }))
                );
            })
            .then(() => self.skipWaiting())
    );
});

// Activate event - Bersihkan cache lama & ambil alih kontrol
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        console.log('[ServiceWorker] Menghapus cache versi lama:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch event - Strategi Cerdas (Network-first untuk HTML & API, Cache-first untuk Asset Statis)
self.addEventListener('fetch', (event) => {
    const request = event.request;
    const url = new URL(request.url);

    // 1. Abaikan request non-GET (POST, PUT, DELETE, dll)
    if (request.method !== 'GET') {
        return;
    }

    // 2. Abaikan chrome-extension, internal schemes
    if (!url.protocol.startsWith('http')) {
        return;
    }

    // 3. API Requests: Selalu Network-First (Jangan simpan data sensitif / stale di cache)
    if (url.pathname.startsWith('/api/')) {
        event.respondWith(
            fetch(request).catch(() => {
                return new Response(JSON.stringify({
                    success: false,
                    message: 'Koneksi jaringan terputus. Anda sedang dalam mode offline.',
                    offline: true
                }), {
                    headers: { 'Content-Type': 'application/json' },
                    status: 503
                });
            })
        );
        return;
    }

    // 4. Navigasi Halaman HTML: Network-First dengan Fallback ke offline.html
    const isNavigation = request.mode === 'navigate' || 
                         (request.headers.get('accept') && request.headers.get('accept').includes('text/html'));

    if (isNavigation) {
        event.respondWith(
            fetch(request)
                .then((response) => {
                    // Jika halaman berhasil diambil dan berstatus 200, kembalikan langsung
                    return response;
                })
                .catch(async () => {
                    console.log('[ServiceWorker] Navigasi gagal (offline), menampilkan offline.html...');
                    const cache = await caches.open(CACHE_NAME);
                    const offlineFallback = await cache.match('/offline.html');
                    if (offlineFallback) {
                        return offlineFallback;
                    }
                    return new Response('<h1>Offline</h1><p>Koneksi internet terputus.</p>', {
                        headers: { 'Content-Type': 'text/html' }
                    });
                })
        );
        return;
    }

    // 5. Aset Statis (Build CSS/JS, Fonts, Icons, Images): Stale-While-Revalidate / Cache-First
    const isStaticAsset = url.pathname.startsWith('/build/') ||
                          url.pathname.startsWith('/icons/') ||
                          url.pathname.startsWith('/storage/') ||
                          url.hostname.includes('cdnjs.cloudflare.com') ||
                          url.hostname.includes('fonts.googleapis.com') ||
                          url.hostname.includes('fonts.gstatic.com') ||
                          request.destination === 'image' ||
                          request.destination === 'font' ||
                          request.destination === 'style' ||
                          request.destination === 'script';

    if (isStaticAsset) {
        event.respondWith(
            caches.match(request).then((cachedResponse) => {
                if (cachedResponse) {
                    // Perbarui cache di background (stale-while-revalidate)
                    fetch(request).then((networkResponse) => {
                        if (networkResponse && networkResponse.status === 200) {
                            caches.open(CACHE_NAME).then((cache) => {
                                cache.put(request, networkResponse);
                            });
                        }
                    }).catch(() => {/* abaikan error fetch background */});

                    return cachedResponse;
                }

                // Jika belum ada di cache, ambil dari network dan simpan
                return fetch(request).then((networkResponse) => {
                    if (!networkResponse || networkResponse.status !== 200 || networkResponse.type === 'opaque') {
                        return networkResponse;
                    }

                    const responseToCache = networkResponse.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(request, responseToCache);
                    });

                    return networkResponse;
                }).catch(() => {
                    // Jika aset gambar gagal, bisa berikan fallback bila perlu
                    return new Response('', { status: 408 });
                });
            })
        );
        return;
    }

    // 6. Default: Langsung ambil dari network
    event.respondWith(fetch(request));
});