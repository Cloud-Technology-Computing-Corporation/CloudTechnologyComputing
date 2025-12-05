/* service-worker.js */

/** —— Tweak these for your site —— **/
const SCOPE_ROOT = '/';                // If your site lives at /blog/, set '/blog/'
const PRECACHE = 'precache-v1';
const RUNTIME  = 'runtime';
const RAW_URLS = [
  '/',                   // root landing (if your SW scope is root)
  '/index.php',          // or your main PHP page(s)
  '/blog.php',
  '/offline.html',

  // CSS
  '/assets/css/bootstrap.min.css',
  '/assets/css/bootstrap-icons.css',
  '/assets/css/all.min.css',
  '/assets/css/fontawesome.min.css',
  '/assets/css/swiper-bundle.min.css',
  '/assets/css/animate.min.css',
  '/assets/css/jquery.fancybox.min.css',
  '/assets/css/boxicons.min.css',
  '/assets/css/preloader.css',
  '/assets/css/style2.css',

  // JS
  '/assets/js/jquery-3.6.0.min.js',
  '/assets/js/popper.min.js',
  '/assets/js/bootstrap.min.js',
  '/assets/js/swiper-bundle.min.js',
  '/assets/js/waypoints.min.js',
  '/assets/js/jquery.counterup.min.js',
  '/assets/js/isotope.pkgd.min.js',
  '/assets/js/jquery.fancybox.min.js',
  '/assets/js/gsap.min.js',
  '/assets/js/simpleParallax.min.js',
  '/assets/js/TweenMax.min.js',
  '/assets/js/jquery.marquee.min.js',
  '/assets/js/wow.min.js',
  '/assets/js/preloader.js',
  '/assets/js/custom.js',

  // images you want guaranteed offline (optional)
  // '/assets/img/sm-logo.svg',
];

// Build absolute URLs safely relative to the SW scope
const urlsToCache = RAW_URLS.map(u => new URL(u, self.registration.scope).toString());

self.addEventListener('install', event => {
  event.waitUntil((async () => {
    const cache = await caches.open(PRECACHE);

    console.log('[SW] Pre-caching:', urlsToCache);
    for (const url of urlsToCache) {
      try {
        // Force a network fetch for fresh bytes on first install
        const req = new Request(url, { cache: 'reload' });
        const res = await fetch(req, { mode: 'same-origin' }); // same-origin only; avoid opaque failures
        if (!res.ok) throw new Error(`HTTP ${res.status} ${res.statusText}`);
        await cache.put(req, res.clone());
        // eslint-disable-next-line no-console
        console.log('[SW] Cached OK:', url);
      } catch (err) {
        // eslint-disable-next-line no-console
        console.warn('[SW] Skipping (failed to cache):', url, err);
        // We continue instead of rejecting install.
      }
    }

    self.skipWaiting();
  })());
});

self.addEventListener('activate', event => {
  event.waitUntil((async () => {
    const keys = await caches.keys();
    await Promise.all(
      keys.map(k => (k === PRECACHE || k === RUNTIME) ? null : caches.delete(k))
    );
    await self.clients.claim();
  })());
});

self.addEventListener('fetch', event => {
  const { request } = event;

self.addEventListener('fetch', (event) => {
  if (event.request.method !== 'GET') return; // don't intercept form posts
  // ...rest of handler...
});

  // Only handle GETs from our own origin
  const url = new URL(request.url);
  if (request.method !== 'GET' || url.origin !== self.location.origin) return;

  // Cache-first for same-origin assets/pages
  event.respondWith((async () => {
    const cached = await caches.match(request);
    if (cached) return cached;

    try {
      const response = await fetch(request);
      // Stash a copy for future offline use
      const cache = await caches.open(RUNTIME);
      cache.put(request, response.clone());
      return response;
    } catch {
      // Offline fallback for navigations
      if (request.mode === 'navigate' || request.destination === 'document') {
        const fallback = await caches.match('/offline.html');
        if (fallback) return fallback;
      }
      throw; // let the browser report the real network error
    }
  })());
});
