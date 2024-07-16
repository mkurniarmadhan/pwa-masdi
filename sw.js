const CACHE_NAME = "pwa-masdi";

const urlsToCache = [
  "/",
  "/index.html",
  "/assets/js/main.js",
  "/assets/css/style.css",
  "/login.html",
  "/firebase-messaging-sw.js",
  "/manifest.json",
  "/sw.js",
  "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css",
  "https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon.ico",
  "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js",
];

// Install event
self.addEventListener("install", (event) => {
  console.log("PWA DI INSTALL ");
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      console.log("TAMBHAKAN SUMBER DAYA KE CACHE ");
      return cache.addAll(urlsToCache);
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
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});
