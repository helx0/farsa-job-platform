const CACHE_NAME = 'farsa-v1';
const ASSETS_TO_CACHE = [
    '/',
    '/index.php',
    '/css/style.css',
    '/css/rtl.css',
    '/css/responsive.css',
    '/css/dashboard.css',
    '/js/app.js',
    '/manifest.json',
    '/pages/jobs.php',
    '/pages/courses.php',
    '/pages/about.php',
    '/pages/contact.php',
    '/pages/auth/login.php',
    '/pages/auth/register.php'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(ASSETS_TO_CACHE))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', event => {
    const { request } = event;
    
    if (request.method !== 'GET') {
        return;
    }

    if (request.url.includes('/php/api/')) {
        event.respondWith(networkFirst(request));
    } else {
        event.respondWith(cacheFirst(request));
    }
});

async function cacheFirst(request) {
    const cached = await caches.match(request);
    
    if (cached) {
        return cached;
    }

    try {
        const response = await fetch(request);
        
        if (response && response.status === 200) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(request, response.clone());
        }
        
        return response;
    } catch (error) {
        return new Response('Offline - Resource not available', {
            status: 503,
            statusText: 'Service Unavailable',
            headers: new Headers({
                'Content-Type': 'text/plain'
            })
        });
    }
}

async function networkFirst(request) {
    try {
        const response = await fetch(request);
        
        if (response && response.status === 200) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(request, response.clone());
        }
        
        return response;
    } catch (error) {
        const cached = await caches.match(request);
        
        if (cached) {
            return cached;
        }

        return new Response(JSON.stringify({
            status: 'error',
            message: 'Offline mode: Could not reach the server'
        }), {
            status: 503,
            headers: new Headers({
                'Content-Type': 'application/json'
            })
        });
    }
}

self.addEventListener('push', event => {
    if (!event.data) return;

    let notificationData;
    
    try {
        notificationData = event.data.json();
    } catch (e) {
        notificationData = {
            title: 'فرصة',
            body: event.data.text()
        };
    }

    const options = {
        body: notificationData.body || '',
        icon: '/images/logo.png',
        badge: '/images/favicon.ico',
        tag: notificationData.tag || 'default',
        requireInteraction: false,
        actions: [
            {
                action: 'open',
                title: 'فتح'
            },
            {
                action: 'close',
                title: 'إغلاق'
            }
        ]
    };

    event.waitUntil(
        self.registration.showNotification(notificationData.title || 'فرصة', options)
    );
});

self.addEventListener('notificationclick', event => {
    event.notification.close();

    if (event.action === 'open' || !event.action) {
        const urlToOpen = event.notification.data?.url || '/';
        
        event.waitUntil(
            clients.matchAll({
                type: 'window',
                includeUncontrolled: true
            }).then(clientList => {
                for (let i = 0; i < clientList.length; i++) {
                    const client = clientList[i];
                    if (client.url === urlToOpen && 'focus' in client) {
                        return client.focus();
                    }
                }
                
                if (clients.openWindow) {
                    return clients.openWindow(urlToOpen);
                }
            })
        );
    }
});

self.addEventListener('notificationclose', event => {
    console.log('Notification closed:', event.notification.tag);
});

self.addEventListener('sync', event => {
    if (event.tag === 'sync-jobs') {
        event.waitUntil(syncJobs());
    } else if (event.tag === 'sync-applications') {
        event.waitUntil(syncApplications());
    }
});

async function syncJobs() {
    try {
        const response = await fetch('/php/api/jobs.php?action=list&page=1');
        if (response.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put('/php/api/jobs.php?action=list&page=1', response);
        }
    } catch (error) {
        console.error('Background sync failed:', error);
    }
}

async function syncApplications() {
    try {
        const response = await fetch('/php/api/applications.php?action=list');
        if (response.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put('/php/api/applications.php?action=list', response);
        }
    } catch (error) {
        console.error('Background sync failed:', error);
    }
}
