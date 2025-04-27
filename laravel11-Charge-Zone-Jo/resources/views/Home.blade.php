<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>محطات شحن السيارات الكهربائية في الأردن</title>
    <link rel="stylesheet" href="style.home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/ccF1aEHugnnBpaTOz/IsBg==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYM8mRkwPWQrQlQlJVlJpZjvgyxyJlCvKBRZj5PeuaLqliekKVifieikiCxHf/zqunFJZ/2hVQWlWIekJHFg==" crossorigin=""></script>

</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#">
                    <i class="fas fa-charging-station"></i> <span>شاحنّي</span>
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="#map-section">الخريطة</a></li>
                <li><a href="#nearest-station">أقرب محطة</a></li>
                <li><a href="#about">حول</a></li>
                <li><a href="#contact">اتصل بنا</a></li>
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

    <section class="services">
        <div class="container">
            <h2>خدماتنا</h2>
            <div class="service-grid">
                <a href="location.html" class="service-item">
                    <i class="fas fa-location-arrow fa-2x"></i>
                    <h3>تحديد الموقع الدقيق</h3>
                    <p>اعثر على جميع محطات الشحن المتوفرة على الخريطة.</p>
                </a>
                <a href="nearest.html" class="service-item">
                    <i class="fas fa-route fa-2x"></i>
                    <h3>أقرب محطة</h3>
                    <p>حدد موقعك الحالي واعثر على أقرب محطة شحن إليك.</p>
                </a>
                <a href="emergency.html" class="service-item">
                    <i class="fa-solid fa-handshake-angle fa-2x"></i>
                    <h3>المساعدة الطارئة</h3>
                    <p>تواصل مع الفريق المختص لتشخيص الحالة والمساعدة الطارئة</p>
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
            // مشغل الفيديو مع خيار كتم الصوت
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

            // تهيئة الخريطة
            const map = L.map('map').setView([31.9539, 35.9106], 10); // إحداثيات عمان، الأردن

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // أمثلة على محطات الشحن (يمكنك تغييرها بالبيانات الحقيقية)
            const stations = [
                { name: "محطة شحن الرابية", lat: 31.9761, lng: 35.8489 },
                { name: "محطة شحن الدوار السابع", lat: 31.9605, lng: 35.8783 },
                { name: "محطة شحن العبدلي", lat: 31.9565, lng: 35.9128 },
                { name: "محطة شحن الجامعة الأردنية", lat: 32.0133, lng: 35.8719 }
            ];

            // إضافة العلامات للمحطات على الخريطة
            stations.forEach(station => {
                L.marker([station.lat, station.lng])
                    .addTo(map)
                    .bindPopup(station.name);
            });
        });
    </script>
</body>
</html>
