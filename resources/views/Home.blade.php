<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>محطات شحن السيارات الكهربائية في الأردن</title>
    <link rel="stylesheet" href="{{ asset('style.home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="Home">
                    <i class="fas fa-charging-station"></i> <span>شاحني</span>
                </a>
            </div>

            {{-- Main Navigation Links (including Services) --}}
            <ul class="nav-links main-nav-links">
                <li><a href="#map-section">الخريطة</a></li>
                <li><a href="nearest">أقرب محطة</a></li>
                <li><a href="#services">خدماتنا</a></li>
                <li><a href="#about">حول</a></li>
                <li><a href="content">اتصل بنا</a></li>
            </ul>

            {{-- Utility Links (Login/Logout, Download App) --}}
            <ul class="nav-links utility-nav-links">
                {{-- Download App Link (Placeholder) --}}
                <li><a href="#" class="download-app-link">تنزيل التطبيق</a></li>

                {{-- Login/Logout Link --}}
                @auth
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-link nav-btn" style="color:inherit;text-decoration:none;">
                                <i class="fas fa-sign-out-alt"></i> <span class="d-none d-md-inline">تسجيل الخروج</span>
                            </button>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" class="btn btn-link nav-btn" style="color:inherit;text-decoration:none;">
                            <i class="fas fa-user-circle"></i> <span class="d-none d-md-inline">تسجيل الدخول</span>
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </nav>

    <header class="hero">
        <div class="video-background">
            <video id="heroVideo" autoplay loop muted playsinline>
                <source src="{{ asset('video/Video 1.mp4') }}" type="video/mp4">
                متصفحك لا يدعم تشغيل الفيديو.
            </video>
        </div>
        <div class="hero-content">
            <h1>اعثر على محطة شحن سيارتك الكهربائية بسهولة في الأردن</h1>
            <p>ابحث عن أقرب محطة شحن، تعرف على الخدمات المتاحة، وخطط لرحلتك بكفاءة.</p>
            <button class="cta-button">
                <i class="fas fa-map-marker-alt"></i> ابحث عن محطة قريبة
            </button>
        </div>

        <button id="muteToggle" class="mute-toggle-button">
            <i class="fas fa-volume-xmark"></i> كتم
        </button>
    </header>

    <section id="services" class="services">
        <div class="container">
            <h2>خدماتنا</h2>
            <div class="service-grid">
                <a href="/location" class="service-item" style="text-decoration:none;color:inherit;">
                    <i class="fas fa-location-arrow fa-2x"></i>
                    <h3>تحديد الموقع الدقيق</h3>
                    <p>اعثر على جميع محطات الشحن المتوفرة على الخريطة.</p>
                </a>
                <a href="/nearest" class="service-item" style="text-decoration:none;color:inherit;">
                    <i class="fas fa-route fa-2x"></i>
                    <h3>أقرب محطة</h3>
                    <p>حدد موقعك الحالي واعثر على أقرب محطة شحن إليك.</p>
                </a>
                <a href="/help" class="service-item" style="text-decoration:none;color:inherit;">
                    <i class="fa-solid fa-handshake-angle fa-2x"></i>
                    <h3>المساعدة الطارئة</h3>
                    <p>تواصل مع الفريق المختص لتشخيص الحالة والمساعدة الطارئة</p>
                </a>
                <a href="/autoparts" class="service-item" style="text-decoration:none;color:inherit;">
                    <i class="fa-solid fa-calendar-check fa-2x"></i>
                    <h3>قطع السيارات </h3>
                    <p>ابحث عن قطع السيارات الخاصة بك</p>
                </a>
                <a href="/maintenance" class="service-item" style="text-decoration:none;color:inherit;">
                    <i class="fa-solid fa-screwdriver-wrench fa-2x"></i>
                    <h3>الصيانة الدورية</h3>
                    <p>احصل على خدمات الصيانة الدورية لمحطات الشحن</p>
                </a>
                <a href="/content" class="service-item" style="text-decoration:none;color:inherit;">
                    <i class="fa-solid fa-credit-card fa-2x"></i>
                    <h3>الإعلان معنا</h3>
                    <p>أعلن عن خدماتك في منصتنا ووصل إلى عملاء جدد</p>
                </a>
            </div>
        </div>
    </section>

    <section id="map-section" class="map-section">
        <div class="container">
            <h2>خريطة محطات الشحن</h2>
            <div id="map"></div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} شاحنّي. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('heroVideo');
            const muteToggle = document.getElementById('muteToggle');

            if (video && muteToggle) {
                updateMuteButtonIcon();

                muteToggle.addEventListener('click', function() {
                    if (video.muted) {
                        video.muted = false;
                    } else {
                        video.muted = true;
                    }
                    updateMuteButtonIcon();
                });
            } else {
                console.error('Video or mute toggle button not found!');
            }

            function updateMuteButtonIcon() {
                const icon = muteToggle.querySelector('i');
                if (icon) {
                    if (video.muted) {
                        icon.classList.remove('fa-volume-up');
                        icon.classList.add('fa-volume-xmark');
                        muteToggle.innerHTML = '<i class="fas fa-volume-xmark"></i> كتم';
                    } else {
                        icon.classList.remove('fa-volume-xmark');
                        icon.classList.add('fa-volume-up');
                        muteToggle.innerHTML = '<i class="fas fa-volume-up"></i> إلغاء الكتم';
                    }
                }
            }

            setTimeout(function() {
                const mapElement = document.getElementById('map');

                if (mapElement) {
                    console.log('تهيئة الخريطة...');

                    try {
                        const map = L.map('map').setView([31.9539, 35.9106], 10);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                            maxZoom: 19
                        }).addTo(map);

                        const stations = @json($stations);
                        stations.forEach(station => {
                            if (station.latitude && station.longitude) {
                                L.marker([station.latitude, station.longitude])
                                .addTo(map)
                                    .bindPopup(station.name + (station.location ? '<br>' + station.location : ''));
                            }
                        });

                        console.log('تم تهيئة الخريطة بنجاح!');

                        setTimeout(function() {
                            map.invalidateSize();
                        }, 500);
                    } catch (error) {
                        console.error('خطأ في تهيئة الخريطة:', error);
                    }
                } else {
                    console.error('عنصر الخريطة غير موجود في الصفحة!');
                }
            }, 1000);
        });
    </script>
</body>
</html>
