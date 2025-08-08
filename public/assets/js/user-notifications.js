document.addEventListener('DOMContentLoaded', function() {
    localStorage.removeItem('lastNearbyShopIds');
    const notificationBadge = document.getElementById('notification-badge');
    const notificationsContainer = document.getElementById('notifications-container');
    let userLocation = null;
    let notifications = [];
    let unreadNotifications = 0;
    let notificationSettings = {
        shopNotifications: true,
        productNotifications: true,
        notificationRadius: 5
    };

    function loadNotifications() {
        notifications = [];
        const savedNotifications = localStorage.getItem('userNotifications');
        if (savedNotifications) {
            try {
                notifications = JSON.parse(savedNotifications);
            } catch (e) {
                notifications = [];
            }
        }
        unreadNotifications = notifications.filter(notif => !notif.read).length;
        notifications = [
            ...notifications.filter(n => !n.read).sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp)),
            ...notifications.filter(n => n.read).sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp))
        ];
        updateNotificationBadge();
        renderNotifications();
    }

    function loadNotificationSettings() {
        const savedSettings = localStorage.getItem('notificationSettings');
        if (savedSettings) {
            notificationSettings = JSON.parse(savedSettings);
            console.log('Loaded notification settings:', notificationSettings);
        }
    }

    function saveNotifications() {
        localStorage.setItem('userNotifications', JSON.stringify(notifications));
    }

    function updateNotificationBadge() {
        notificationBadge.textContent = unreadNotifications;
        if (unreadNotifications > 0 && 
            (notificationSettings.shopNotifications || notificationSettings.productNotifications)) {
            notificationBadge.style.display = 'inline-block';
        } else {
            notificationBadge.style.display = 'none';
        }
    }

    function renderNotifications() {
        const filteredNotifications = notifications.filter(notification => {
            if (notification.type === 'shop' && !notificationSettings.shopNotifications) {
                return false;
            }
            if (notification.type === 'product' && !notificationSettings.productNotifications) {
                return false;
            }
            return true;
        });

        function updateList(listElement) {
            if (!listElement) return;
            if (filteredNotifications.length === 0) {
                listElement.innerHTML = '<li class="text-center p-2 text-muted">لا توجد إشعارات جديدة</li>';
                return;
            }
            listElement.innerHTML = '';
            const unread = filteredNotifications.filter(n => !n.read).sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
            const read = filteredNotifications.filter(n => n.read).sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
            const allSorted = [...unread, ...read];
            const recentNotifications = allSorted.slice(0, 10);
            recentNotifications.forEach(notification => {
                const notificationItem = document.createElement('li');
                notificationItem.className = `notification-item ${notification.read ? '' : 'notification-unread'}`;
                const timeAgo = getTimeAgo(notification.timestamp);
                notificationItem.innerHTML = `
                    <div class="notification-title">
                        <i class="fas ${notification.type === 'shop' ? 'fa-store' : 'fa-box'} me-2"></i>
                        ${notification.title}
                    </div>
                    <div class="notification-text">${notification.message}</div>
                    <div class="notification-time">
                        <i class="fas fa-clock me-1"></i> ${timeAgo}
                    </div>
                `;
                notificationItem.addEventListener('click', function() {
                    const notifIndex = notifications.findIndex(n => n.id === notification.id);
                    if (notifIndex !== -1 && !notifications[notifIndex].read) {
                        notifications[notifIndex].read = true;
                        saveNotifications();
                    unreadNotifications = notifications.filter(n => !n.read).length;
                    updateNotificationBadge();
                    updateList(document.getElementById('notifications-container'));
                    updateList(document.getElementById('notifications-container-mobile'));
                    }
                    if (notification.link) {
                        window.location.href = notification.link;
                    }
                });
                listElement.appendChild(notificationItem);
            });
        }
        updateList(document.getElementById('notifications-container'));
        updateList(document.getElementById('notifications-container-mobile'));
    }

    function getTimeAgo(timestamp) {
        const now = new Date();
        const past = new Date(timestamp);
        const diffSeconds = Math.floor((now - past) / 1000);
        if (diffSeconds < 60) return 'منذ لحظات';
        const diffMinutes = Math.floor(diffSeconds / 60);
        if (diffMinutes < 60) return `منذ ${diffMinutes} دقيقة`;
        const diffHours = Math.floor(diffMinutes / 60);
        if (diffHours < 24) return `منذ ${diffHours} ساعة`;
        const diffDays = Math.floor(diffHours / 24);
        if (diffDays < 7) return `منذ ${diffDays} يوم`;
        const diffWeeks = Math.floor(diffDays / 7);
        if (diffWeeks < 4) return `منذ ${diffWeeks} أسبوع`;
        const diffMonths = Math.floor(diffDays / 30);
        if (diffMonths < 12) return `منذ ${diffMonths} شهر`;
        return `منذ ${Math.floor(diffMonths / 12)} سنة`;
    }

    function getUserLocation() {
        return new Promise((resolve, reject) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        localStorage.setItem('userLocation', JSON.stringify(userLocation));
                        resolve(userLocation);
                    },
                    error => {
                        console.log('Error getting location:', error.message);
                        const savedLocation = localStorage.getItem('userLocation');
                        if (savedLocation) {
                            userLocation = JSON.parse(savedLocation);
                            resolve(userLocation);
                        } else {
                            userLocation = {
                                lat: 31.5017,
                                lng: 34.4668
                            };
                            localStorage.setItem('userLocation', JSON.stringify(userLocation));
                            resolve(userLocation);
                        }
                    },
                    { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
                );
            } else {
                console.log('Geolocation is not supported by this browser.');
                reject(new Error('Geolocation not supported'));
            }
        });
    }

    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2); 
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        const d = R * c;
        return d;
    }

    function deg2rad(deg) {
        return deg * (Math.PI/180);
    }

    function checkForNearbyShops() {
        getUserLocation().then(location => {
            fetch(`/your-liquidity/user/nearby-shops?lat=${location.lat}&lng=${location.lng}&radius=${notificationSettings.notificationRadius}`)
                .then(response => response.json())
                .then(async data => {
                    let shops = data.shops || [];
                    const lastShopIds = JSON.parse(localStorage.getItem('lastNearbyShopIds') || '[]');
                    const currentShopIds = shops.map(shop => shop.id);
                    if (notificationSettings.shopNotifications) {
                        const newShops = shops.filter(shop => !lastShopIds.includes(shop.id));
                        newShops.forEach(shop => {
                            addShopNotification({
                                id: shop.id,
                                name: shop.name,
                                distance: shop.distance
                            });
                        });
                    }
                    localStorage.setItem('lastNearbyShopIds', JSON.stringify(currentShopIds));
                    await checkForProductNotifications(shops);
                });
        });
    }

    function addShopNotification(shop) {
        const exists = notifications.some(n => n.type === 'shop' && n.shopId === shop.id);
        if (exists) return;
        const notification = {
            id: `shop-${shop.id}-${Date.now()}`,
            shopId: shop.id,
            type: 'shop',
            title: 'متجر جديد بالقرب منك!',
            message: `${shop.name} على بعد ${shop.distance} كم من موقعك`,
            timestamp: new Date().toISOString(),
            read: false,
            link: `/your-liquidity/shops/${shop.id}`
        };
        notifications.unshift(notification);
        unreadNotifications = notifications.filter(n => !n.read).length;
        updateNotificationBadge();
        renderNotifications();
        saveNotifications();
    }

    async function checkForProductNotifications(nearbyShops) {
        if (!notificationSettings.productNotifications) return;
        for (const shop of nearbyShops) {
            try {
                const res = await fetch(`/your-liquidity/shops/${shop.id}/products?limit=1&sort=desc`);
                if (res.ok) {
                    const prodData = await res.json();
                    if (prodData.products && prodData.products.length > 0) {
                        const latestProduct = prodData.products[0];
                        const exists = notifications.some(n => n.type === 'product' && n.productId === latestProduct.id && n.shopId === shop.id);
                        if (!exists) {
                            addProductNotification(latestProduct, shop);
                        }
                    }
                }
            } catch (e) { }
        }
    }

    function addProductNotification(product, shop) {
        const exists = notifications.some(n => n.type === 'product' && n.productId === product.id && n.shopId === shop.id);
        if (exists) return;
        const notification = {
            id: `product-${product.id}-${Date.now()}`,
            productId: product.id,
            shopId: shop.id,
            type: 'product',
            title: 'منتج جديد في متجر قريب!',
            message: `${product.name} متوفر الآن في ${shop.name}`,
            timestamp: new Date().toISOString(),
            read: false,
            link: `/your-liquidity/shops/${shop.id}#product-${product.id}`
        };
        notifications.unshift(notification);
        unreadNotifications = notifications.filter(n => !n.read).length;
        updateNotificationBadge();
        renderNotifications();
        saveNotifications();
    }

    loadNotificationSettings();
    loadNotifications();
    getUserLocation().then(() => {
        checkForNearbyShops();
    });
});