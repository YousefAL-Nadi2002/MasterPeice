<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحديد الموقع الدقيق - شاحنّي</title>
    <link rel="stylesheet" href="{{ asset('style.location.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

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
                <li><a href="#">الخريطة</a></li>
                <li><a href="{{ url('/nearest') }}">أقرب محطة</a></li>
                <li><a href="#">حول</a></li>
                <li><a href="#">اتصل بنا</a></li>
            </ul>
        </div>
    </nav>

    <main class="location-main">
        <div class="container">
            <h2>تحديد الموقع الدقيق</h2>

            <div class="side-by-side-container">
                <div class="map-panel">
                    <div id="locationMap"></div>
                </div>

                <div class="info-panel">
                    <div class="input-panel">
                        <h3>أدخل بيانات الرحلة</h3>
                 <div class="form-group" id="amman-area-group" style="display: none;">
                            <label for="amman-area">منطقة في عمان:</label>
                            <select id="amman-area">
                                <option value="">اختر المنطقة</option>
                                <option value="الرابية">الرابية</option>
                                <option value="الدوار السابع">الدوار السابع</option>
                                <option value="العبدلي">العبدلي</option>
                                <option value="الجاردنز">الجاردنز</option>
                                <option value="خلدا">خلدا</option>
                                <option value="صويلح">صويلح</option>
                                <option value="مرج الحمام">مرج الحمام</option>
                                <option value="أبو نصير">أبو نصير</option>
                                <option value="المقابلين">المقابلين</option>
                                <option value="طبربور">طبربور</option>
                                <option value="وادي السير">وادي السير</option>
                                <option value="تلاع العلي">تلاع العلي</option>
                                <option value="الشميساني">الشميساني</option>
                                <option value="الصويفية">الصويفية</option>
                                <option value="ضاحية الرشيد">ضاحية الرشيد</option>
                                <option value="أم السماق">أم السماق</option>
                                <option value="ضاحية الياسمين">ضاحية الياسمين</option>
                                <option value="البيادر">البيادر</option>
                                <option value="جبل عمان">جبل عمان</option>
                                <option value="الجبيهة">الجبيهة</option>
                                <option value="ماركا">ماركا</option>
                                <option value="النزهة">النزهة</option>
                                <option value="القويسمة">القويسمة</option>
                                <option value="شارع الجامعة">شارع الجامعة</option>
                                <option value="شارع المدينة المنورة">شارع المدينة المنورة</option>
                                <option value="شارع مكة">شارع مكة</option>
                                <option value="الهاشمي الشمالي">الهاشمي الشمالي</option>
                                <option value="ضاحية الأمير راشد">ضاحية الأمير راشد</option>
                                <option value="وسط البلد">وسط البلد</option>
                                <option value="الجبل الأخضر">الجبل الأخضر</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start-point">نقطة الانطلاق:</label>
                            <select id="start-governorate">
                                <option value="">اختر المحافظة</option>
                                <option value="عمان">عمان</option>
                                <option value="اربد">اربد</option>
                                <option value="الزرقاء">الزرقاء</option>
                                <option value="البلقاء">البلقاء</option>
                                <option value="مأدبا">مأدبا</option>
                                <option value="جرش">جرش</option>
                                <option value="عجلون">عجلون</option>
                                <option value="الكرك">الكرك</option>
                                <option value="معان">معان</option>
                                <option value="الطفيلة">الطفيلة</option>
                                <option value="العقبة">العقبة</option>
                                <option value="المفرق">المفرق</option>
                            </select>
                        </div>

                     <div class="form-group" id="destination-amman-area-group" style="display: none;">
                            <label for="destination-amman-area">منطقة الوجهة في عمان:</label>
                            <select id="destination-amman-area">
                                <option value="">اختر المنطقة</option>
                                <option value="الرابية">الرابية</option>
                                <option value="الدوار السابع">الدوار السابع</option>
                                <option value="العبدلي">العبدلي</option>
                                <option value="الجاردنز">الجاردنز</option>
                                <option value="خلدا">خلدا</option>
                                <option value="صويلح">صويلح</option>
                                <option value="مرج الحمام">مرج الحمام</option>
                                <option value="أبو نصير">أبو نصير</option>
                                <option value="المقابلين">المقابلين</option>
                                <option value="طبربور">طبربور</option>
                                <option value="وادي السير">وادي السير</option>
                                <option value="تلاع العلي">تلاع العلي</option>
                                <option value="الشميساني">الشميساني</option>
                                <option value="الصويفية">الصويفية</option>
                                <option value="ضاحية الرشيد">ضاحية الرشيد</option>
                                <option value="أم السماق">أم السماق</option>
                                <option value="ضاحية الياسمين">ضاحية الياسمين</option>
                                <option value="البيادر">البيادر</option>
                                <option value="جبل عمان">جبل عمان</option>
                                <option value="الجبيهة">الجبيهة</option>
                                <option value="ماركا">ماركا</option>
                                <option value="النزهة">النزهة</option>
                                <option value="القويسمة">القويسمة</option>
                                <option value="شارع الجامعة">شارع الجامعة</option>
                                <option value="شارع المدينة المنورة">شارع المدينة المنورة</option>
                                <option value="شارع مكة">شارع مكة</option>
                                <option value="الهاشمي الشمالي">الهاشمي الشمالي</option>
                                <option value="ضاحية الأمير راشد">ضاحية الأمير راشد</option>
                                <option value="وسط البلد">وسط البلد</option>
                                <option value="الجبل الأخضر">الجبل الأخضر</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="destination">نقطة النهاية (الوجهة):</label>
                             <select id="destination-governorate">
                                <option value="">اختر المحافظة</option>
                                <option value="عمان">عمان</option>
                                <option value="اربد">اربد</option>
                                <option value="الزرقاء">الزرقاء</option>
                                <option value="البلقاء">البلقاء</option>
                                <option value="مأدبا">مأدبا</option>
                                <option value="جرش">جرش</option>
                                <option value="عجلون">عجلون</option>
                                <option value="الكرك">الكرك</option>
                                <option value="معان">معان</option>
                                <option value="الطفيلة">الطفيلة</option>
                                <option value="العقبة">العقبة</option>
                                <option value="المفرق">المفرق</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="current-charge">الشحن الحالي للسيارة (%):</label>
                            <input type="number" id="current-charge" min="0" max="100" value="80">
                        </div>

                        <button id="calculate-route" class="calculate-button">احسب المسار والمدى</button>
                    </div>

                    <div id="results-panel" class="results-panel" style="display: none;">
                        <h3>نتائج الحساب</h3>
                        <p id="reachability-result"><strong>إمكانية الوصول:</strong> جارٍ الحساب...</p>
                        <p id="recommended-speed"><strong>السرعة الموصى بها:</strong> جارٍ الحساب...</p>
                        <p id="route-distance"><strong>المسافة:</strong> جارٍ الحساب...</p>

                        <div id="stations-along-route">
                            <h4>المحطات المتوفرة على الطريق:</h4>
                            <p>يتم عرض جميع المحطات على الخريطة. للعثور على أقرب محطة للوجهة، انظر أدناه.</p>
                        </div>

                        <div id="nearest-station-to-destination" style="display: none;">
                            <h4>أقرب محطة شحن للوجهة:</h4>
                            <p><i class="fas fa-charging-station"></i> <span id="dest-station-name">اسم المحطة</span></p>
                            <p><i class="fas fa-map-marker-alt"></i> <span id="dest-station-address">العنوان</span></p>
                            <p><i class="fas fa-route"></i> المسافة من الوجهة: <span id="dest-station-distance">--</span> كم</p>
                            <button class="service-button" style="margin-top: 15px;">حجز موعد في هذه المحطة <i class="fas fa-calendar-check"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} شاحنّي. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // المتغيرات الرئيسية
            const startGovernorateSelect = document.getElementById('start-governorate');
            const ammanAreaGroup = document.getElementById('amman-area-group');
            const ammanAreaSelect = document.getElementById('amman-area');
            const destinationGovernorateSelect = document.getElementById('destination-governorate');
            const destinationAmmanAreaGroup = document.getElementById('destination-amman-area-group');
            const destinationAmmanAreaSelect = document.getElementById('destination-amman-area');
            const currentChargeInput = document.getElementById('current-charge');
            const calculateButton = document.getElementById('calculate-route');
            const resultsPanel = document.getElementById('results-panel');
            const reachabilityResult = document.getElementById('reachability-result');
            const recommendedSpeed = document.getElementById('recommended-speed');
            const routeDistance = document.getElementById('route-distance');
            const nearestStationToDestinationDiv = document.getElementById('nearest-station-to-destination');
            const destStationName = document.getElementById('dest-station-name');
            const destStationAddress = document.getElementById('dest-station-address');
            const destStationDistance = document.getElementById('dest-station-distance');

            // تهيئة الخريطة
            let map = null;
            const mapElement = document.getElementById('locationMap');

            if (mapElement) {
                try {
                    map = L.map('locationMap').setView([31.9632, 35.9306], 8); // إحداثيات عمان، الأردن

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    console.log('تم تهيئة الخريطة بنجاح.');

                    // تحديث حجم الخريطة بعد التهيئة
                    map.invalidateSize();
                    setTimeout(() => {
                        map.invalidateSize();
                    }, 500);

                } catch (error) {
                    console.error('خطأ في تهيئة الخريطة:', error);
                    if (mapElement) {
                        mapElement.innerHTML = '<p style="color: red; text-align: center;">تعذر تحميل الخريطة. يرجى التحقق من اتصال الإنترنت.</p>';
                        mapElement.style.height = 'auto';
                        mapElement.style.boxShadow = 'none';
                    }
                }
            } else {
                console.error('عنصر الخريطة غير موجود!');
            }

            // الإحداثيات للمحافظات الأردنية
            const governorateCoordinates = {
                'عمان': [31.9632, 35.9306],
                'اربد': [32.55, 35.85],
                'الزرقاء': [32.08, 36.09],
                'البلقاء': [32.0387, 35.7285], // السلط
                'مأدبا': [31.72, 35.79],
                'جرش': [32.2733, 35.8928],
                'عجلون': [32.33, 35.75],
                'الكرك': [31.18, 35.70],
                'معان': [30.1956, 35.7375],
                'الطفيلة': [30.8333, 35.6000],
                'العقبة': [29.53, 35.00],
                'المفرق': [32.35, 36.2]
            };

            // الإحداثيات لمناطق عمان
            const ammanAreaCoordinates = {
                'الرابية': [31.9761, 35.8489],
                'الدوار السابع': [31.9605, 35.8783],
                'العبدلي': [31.9565, 35.9128],
                'الجاردنز': [31.9800, 35.8800],
                'خلدا': [32.0050, 35.8400],
                'صويلح': [32.0300, 35.8600],
                'مرج الحمام': [31.8500, 35.8200],
                'أبو نصير': [32.0600, 35.8900],
                'المقابلين': [31.8800, 35.9500],
                'طبربور': [32.0200, 35.9500],
                'وادي السير': [31.9333, 35.8167],
                'تلاع العلي': [31.9850, 35.8650],
                'الشميساني': [31.9677, 35.9008],
                'الصويفية': [31.9574, 35.8761],
                'ضاحية الرشيد': [31.9727, 35.8394],
                'أم السماق': [31.9894, 35.8561],
                'ضاحية الياسمين': [32.0100, 35.8683],
                'البيادر': [31.9467, 35.8319],
                'جبل عمان': [31.9500, 35.9200],
                'الجبيهة': [32.0147, 35.8703],
                'ماركا': [31.9667, 36.0000],
                'النزهة': [31.9389, 35.9431],
                'القويسمة': [31.9000, 35.9667],
                'شارع الجامعة': [32.0133, 35.8703],
                'شارع المدينة المنورة': [31.9933, 35.8594],
                'شارع مكة': [31.9800, 35.8600],
                'الهاشمي الشمالي': [31.9772, 35.9614],
                'ضاحية الأمير راشد': [31.9072, 35.8622],
                'وسط البلد': [31.9522, 35.9308],
                'الجبل الأخضر': [31.9469, 35.9486]
            };

            // محطات الشحن الوهمية
const dummyStations = [
    // عمان
    { latlng: [31.9761, 35.8489], name: 'محطة وهمية عمان - الرابية', address: 'شارع الرابية', info: 'متوفر 2 شاحن سريع' },
    { latlng: [31.9605, 35.8783], name: 'محطة وهمية عمان - الدوار السابع', address: 'الدوار السابع', info: 'مفتوح 24 ساعة' },
    { latlng: [31.9565, 35.9128], name: 'محطة وهمية عمان - العبدلي', address: 'بوليفارد العبدلي', info: 'شحن سريع' },
    { latlng: [31.9800, 35.8800], name: 'محطة وهمية عمان - الجاردنز', address: 'شارع وصفي التل', info: 'متوفر 4 شواحن' },
    { latlng: [32.0050, 35.8400], name: 'محطة وهمية عمان - خلدا', address: 'شارع خلدا الرئيسي', info: 'مفتوح من 8 صباحاً - 10 مساءً' },

    // إربد
    { latlng: [32.55, 35.85], name: 'محطة وهمية إربد 1', address: 'شارع الجامعة، إربد', info: 'متوفر 3 شواحن' },
    { latlng: [32.56, 35.84], name: 'محطة وهمية إربد 2', address: 'شارع الهاشمي، إربد', info: 'مفتوح 24 ساعة' },

    // الزرقاء
    { latlng: [32.08, 36.09], name: 'محطة وهمية الزرقاء 1', address: 'شارع الملك عبدالله، الزرقاء', info: 'شحن سريع' },
    { latlng: [32.07, 36.10], name: 'محطة وهمية الزرقاء 2', address: 'الوسط التجاري، الزرقاء', info: 'متوفر 2 شاحن بطيء' },

    // العقبة
    { latlng: [29.53, 35.00], name: 'محطة وهمية العقبة 1', address: 'شارع الملك حسين، العقبة', info: 'مفتوح من 8 صباحاً - 12 ليلاً' },
    { latlng: [29.52, 35.01], name: 'محطة وهمية العقبة 2', address: 'منطقة العقبة الاقتصادية', info: 'متوفر 5 شواحن' },

    // المفرق
    { latlng: [32.35, 36.2], name: 'محطة وهمية المفرق', address: 'الطريق الدولي، المفرق', info: 'شحن سريع' },

    // جرش
    { latlng: [32.2733, 35.8928], name: 'محطة وهمية جرش', address: 'بالقرب من الآثار، جرش', info: 'متوفر 2 شاحن' },

    // مأدبا
    { latlng: [31.72, 35.79], name: 'محطة وهمية مأدبا', address: 'وسط المدينة، مأدبا', info: 'مفتوح من 9 صباحاً - 9 مساءً' }
];

// متغيرات خاصة بحساب المسار
let markers = [];
let routeLine = null;
let stationMarkers = [];

// عند تغيير اختيار المحافظة لنقطة الانطلاق
startGovernorateSelect.addEventListener('change', function() {
    // إظهار/إخفاء مجموعة مناطق عمان حسب اختيار المستخدم
    if (this.value === 'عمان') {
        ammanAreaGroup.style.display = 'block';
    } else {
        ammanAreaGroup.style.display = 'none';
        ammanAreaSelect.value = '';
    }

    // تحديث الخريطة لتظهر المحافظة المختارة
    if (this.value && governorateCoordinates[this.value]) {
        map.setView(governorateCoordinates[this.value], 10);
    }
});

// عند تغيير اختيار محافظة الوجهة
destinationGovernorateSelect.addEventListener('change', function() {
    // إظهار/إخفاء مجموعة مناطق عمان للوجهة حسب اختيار المستخدم
    if (this.value === 'عمان') {
        destinationAmmanAreaGroup.style.display = 'block';
    } else {
        destinationAmmanAreaGroup.style.display = 'none';
        destinationAmmanAreaSelect.value = '';
    }

    // تحديث الخريطة لتظهر محافظة الوجهة المختارة
    if (this.value && governorateCoordinates[this.value]) {
        map.setView(governorateCoordinates[this.value], 10);
    }
});

// تحديد المنطقة في عمان لنقطة الانطلاق
ammanAreaSelect.addEventListener('change', function() {
    const startGov = startGovernorateSelect.value;
    if (startGov === 'عمان' && this.value && ammanAreaCoordinates[this.value]) {
        map.setView(ammanAreaCoordinates[this.value], 14);
    } else if (startGov && governorateCoordinates[startGov]) {
         map.setView(governorateCoordinates[startGov], 10);
    }
});


// تحديد منطقة الوجهة في عمان
destinationAmmanAreaSelect.addEventListener('change', function() {
     const destGov = destinationGovernorateSelect.value;
    if (destGov === 'عمان' && this.value && ammanAreaCoordinates[this.value]) {
        map.setView(ammanAreaCoordinates[this.value], 14);
    } else if (destGov && governorateCoordinates[destGov]) {
        map.setView(governorateCoordinates[destGov], 10);
    }
});

// تنظيف المؤشرات والمسار السابق على الخريطة
function clearMap() {
    // إزالة المؤشرات السابقة
    markers.forEach(marker => {
        map.removeLayer(marker);
    });
    markers = [];

    // إزالة خط المسار السابق
    if (routeLine) {
        map.removeLayer(routeLine);
        routeLine = null;
    }

    // إزالة مؤشرات المحطات
    stationMarkers.forEach(marker => {
        map.removeLayer(marker);
    });
    stationMarkers = [];
}

// إضافة محطات الشحن إلى الخريطة
function addStationsToMap() {
    // رمز المحطة
    const stationIcon = L.icon({
        iconUrl: 'https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/images/marker-icon.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowUrl: 'https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/images/marker-shadow.png',
        shadowSize: [41, 41],
        shadowAnchor: [12, 41]
    });

    // إضافة كل محطة إلى الخريطة
    dummyStations.forEach(station => {
        let marker = L.marker(station.latlng, { icon: stationIcon }).addTo(map);
        marker.bindPopup(`
            <strong>${station.name}</strong><br>
            ${station.address}<br>
            <span style="color: green;">${station.info}</span><br>
            <button class="station-details-btn" style="margin-top: 10px; padding: 5px 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">تفاصيل المحطة</button>
        `);

        stationMarkers.push(marker);
    });
}

// دالة لجلب المسار من OSRM ورسمه
function fetchAndDrawRoute(startCoords, destCoords) {
    const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${startCoords[1]},${startCoords[0]};${destCoords[1]},${destCoords[0]}?overview=full&geometries=geojson`;

    fetch(osrmUrl)
        .then(response => response.json())
        .then(data => {
            if (data.routes && data.routes.length > 0) {
                const routeGeometry = data.routes[0].geometry;
                const routeCoordinates = routeGeometry.coordinates.map(coord => [coord[1], coord[0]]); // OSRM returns [lon, lat], Leaflet uses [lat, lon]

                // رسم خط المسار على الخريطة
                routeLine = L.polyline(routeCoordinates, { color: 'blue' }).addTo(map);

                // تكبير الخريطة لتشمل المسار الكامل
                map.fitBounds(routeLine.getBounds(), { padding: [50, 50] });

                // تحديث المسافة (من بيانات OSRM)
                const distanceInMeters = data.routes[0].distance; // المسافة بالمتر
                const distanceInKm = (distanceInMeters / 1000).toFixed(1);

                routeDistance.innerHTML = `<strong>المسافة:</strong> ${distanceInKm} كم`;

                 // حساب إمكانية الوصول بناءً على الشحن الحالي
                // افتراض: السيارة يمكنها السفر 4 كم لكل 1% من الشحن
                const currentCharge = parseInt(currentChargeInput.value) || 80; // القيمة الافتراضية 80%
                const maxRange = currentCharge * 4; // المدى الأقصى بالكيلومترات
                const canReach = maxRange >= parseFloat(distanceInKm);

                if (canReach) {
                    reachabilityResult.innerHTML = `<strong>إمكانية الوصول:</strong> <span style="color: green;">يمكنك الوصول إلى الوجهة بالشحن الحالي (${currentCharge}%)</span>`;
                } else {
                    reachabilityResult.innerHTML = `<strong>إمكانية الوصول:</strong> <span style="color: red;">لا يمكنك الوصول إلى الوجهة بالشحن الحالي. تحتاج إلى شحن إضافي ${Math.ceil((parseFloat(distanceInKm) - maxRange) / 4)}%</span>`;
                }

                 // السرعة الموصى بها (هذه تحتاج لمنطق أكثر تعقيدًا ويعتمد على بيانات السيارة والطقس والتضاريس، هنا مجرد تقدير مبسط)
                const chargeAfterTrip = currentCharge - (parseFloat(distanceInKm) / 4);
                let recommendedSpeedValue = 100; // السرعة القصوى الافتراضية

                if (chargeAfterTrip < 50) {
                    recommendedSpeedValue -= Math.floor((50 - chargeAfterTrip) / 10) * 5;
                }
                 recommendedSpeed.innerHTML = `<strong>السرعة الموصى بها:</strong> ${recommendedSpeedValue} كم/ساعة`;


            } else {
                console.error('لم يتم العثور على مسار.');
                routeDistance.innerHTML = `<strong>المسافة:</strong> تعذر حساب المسافة (لا يوجد مسار)`;
                 reachabilityResult.innerHTML = `<strong>إمكانية الوصول:</strong> تعذر حساب إمكانية الوصول`;
                 recommendedSpeed.innerHTML = `<strong>السرعة الموصى بها:</strong> تعذر الحساب`;
            }
            resultsPanel.style.display = 'block';
        })
        .catch(error => {
            console.error('خطأ في جلب المسار:', error);
            routeDistance.innerHTML = `<strong>المسافة:</strong> خطأ في جلب المسار`;
            reachabilityResult.innerHTML = `<strong>إمكانية الوصول:</strong> خطأ في الحساب`;
            recommendedSpeed.innerHTML = `<strong>السرعة الموصى بها:</strong> خطأ في الحساب`;
             resultsPanel.style.display = 'block';
        });
}


// حساب المسار والمدى
calculateButton.addEventListener('click', function() {
    // التحقق من صحة المدخلات
    const startGov = startGovernorateSelect.value;
    const startArea = ammanAreaSelect.value;
    const destGov = destinationGovernorateSelect.value;
    const destArea = destinationAmmanAreaSelect.value;


    if (!startGov || !destGov) {
        alert('يرجى اختيار المحافظات لنقطة البداية والوجهة.');
        return;
    }

    // تنظيف الخريطة
    clearMap();

    // نقطة البداية
    let startCoords;
    if (startGov === 'عمان' && startArea) {
        startCoords = ammanAreaCoordinates[startArea];
    } else {
        startCoords = governorateCoordinates[startGov];
    }

    // نقطة الوجهة
    let destCoords;
    if (destGov === 'عمان' && destArea) {
        destCoords = ammanAreaCoordinates[destArea];
    } else {
        destCoords = governorateCoordinates[destGov];
    }

    // وضع المؤشرات
    let startMarker = L.marker(startCoords).addTo(map);
    startMarker.bindPopup(`<b>نقطة البداية</b><br>${startGov}${startArea ? ' - ' + startArea : ''}`).openPopup();
    markers.push(startMarker);

    let destMarker = L.marker(destCoords).addTo(map);
    destMarker.bindPopup(`<b>الوجهة</b><br>${destGov}${destArea ? ' - ' + destArea : ''}`);
    markers.push(destMarker);

    // جلب ورسم المسار باستخدام OSRM
    fetchAndDrawRoute(startCoords, destCoords);

    // إضافة محطات الشحن إلى الخريطة
    addStationsToMap();

    // حساب أقرب محطة للوجهة (يبقى الحساب الجوي هنا، يمكن تحسينه باستخدام OSRM لاحقاً)
    let nearestStation = null;
    let minDistance = Infinity;

     function calculateDistance(coords1, coords2) {
        // صيغة هافرساين لحساب المسافة بين نقطتين على سطح الأرض
        const toRad = value => value * Math.PI / 180;
        const R = 6371; // نصف قطر الأرض بالكيلومترات
        const dLat = toRad(coords2[0] - coords1[0]);
        const dLon = toRad(coords2[1] - coords1[1]);
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(toRad(coords1[0])) * Math.cos(toRad(coords2[0])) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return (R * c).toFixed(1); // المسافة الهوائية بالكيلومترات
    }


    dummyStations.forEach(station => {
        const distToDestination = calculateDistance(station.latlng, destCoords);
        if (parseFloat(distToDestination) < parseFloat(minDistance)) {
            minDistance = distToDestination;
            nearestStation = station;
        }
    });

     // عرض أقرب محطة للوجهة
    if (nearestStation) {
        nearestStationToDestinationDiv.style.display = 'block';
        destStationName.textContent = nearestStation.name;
        destStationAddress.textContent = nearestStation.address;
        destStationDistance.textContent = minDistance;
    } else {
         nearestStationToDestinationDiv.style.display = 'none';
    }
});

// تحديث حجم الخريطة عند تغيير حجم الشاشة
window.addEventListener('resize', function() {
    if (map) {
        map.invalidateSize();
    }
});
});
</script>
</body>
</html>