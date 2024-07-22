const CACHE_NAME = "pwa-masdi";

const urlsToCache = [
  // php gile
  "/index.php",
  "/admin.php",
  "/checkout.php",
  "/daftar.php",
  "/login.php",
  "/riwayat.php",
  "/js/pwa.js",

  // assets css
  "/login.css",
  "/assets/css/style.css",
  "/login.php",
  "/icons/manifest.json",
  "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css",
  "https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon.ico",
  "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js",
  "https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js",
  "https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js",
  "/firebase-messaging-sw.js",
];

// Install event
self.addEventListener("install", (event) => {
  console.log("PWA DI INSTALL ");
  event.waitUntil(
    caches
      .open(CACHE_NAME)
      .then((cache) => {
        console.log("TAMBHAKAN SUMBER DAYA KE CACHE ");
        return cache.addAll(urlsToCache);
      })
      .then(() => {
        return self.skipWaiting();
      })
      .catch((err) => {
        // Output an error if the paths to the files are incorrect
        console.log(
          `[Service Worker Cache] Error Check SETTINGS.cachedFiles array in the service-worker.js - files are missing or paths to the files are incorrectly written - ${err}`,
          "error"
        );
      })
  );
});

// fetch event
self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      var networkUpdate = fetch(event.request).then((networkResponse) => {
        caches
          .open(CACHE_NAME)
          .then((cache) => cache.put(event.request, networkResponse));
        return networkResponse.clone();
      });
      return cachedResponse || networkUpdate;
    })
  );
});

// Activate event
self.addEventListener("activate", (event) => {
  self.clients.claim();
  // const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames
          .filter((cacheName) => cacheName !== CACHE_NAME)
          .map((cacheName) => {
            caches.delete(cacheName);
          })
      );
    })
  );
});
