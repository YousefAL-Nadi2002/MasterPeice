<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أقرب محطة شحن - شاحنّي</title>
    {{-- Link to your main CSS file --}}
    {{-- Assuming your main CSS is style.css or style.nearest.css in the public folder --}}
    {{-- Use asset() to correctly link files from the public directory --}}
    <link rel="stylesheet" href="{{ asset('style.nearest.css') }}">
    {{-- أو إذا كان ملف CSS الرئيسي هو style.css: --}}
    {{-- <link rel="stylesheet" href="{{ asset('style.css') }}"> --}}
    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Leaflet CSS for map - UPDATED INTEGRITY --}}
    {{-- تأكد من استخدام قيم integrity الصحيحة التي تعمل لديك --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>

    {{-- Leaflet JS for map - UPDATED INTEGRITY --}}
    {{-- تأكد من استخدام قيم integrity الصحيحة التي تعمل لديك --}}
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    {{-- You can put the specific CSS for this page here if you prefer not to use a separate file --}}
    {{-- إذا كان style.nearest.css غير موجود أو لا يحتوي على التنسيقات، يمكنك وضعها هنا --}}
     <style>
        /* Add specific styles for the map container */
        #map {
            height: 400px; /* Adjust height as needed for mobile */
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* margin-bottom: 20px; -- Removed if using gap in wrapper */
        }

        /* Optional: Style for the section containing the map */
        .map-section {
            padding: 40px 0;
            background-color: #f4f4f4; /* Match body background or choose another */
            text-align: center; /* Center the heading */
        }

        .map-section h2 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #333;
        }

         /* Ensure container padding applies */
        .map-section .container {
             padding: 20px;
        }

         /* Ensure the main content area has some padding */
        .nearest-station-main .container {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        /* Style for the wrapper containing the map and info panel */
        .map-and-info-wrapper {
            display: flex; /* Use Flexbox for layout */
            flex-direction: column; /* Stack elements vertically by default (mobile first) */
            gap: 20px; /* Space between map and info panel */
            margin-top: 20px; /* Space below the heading */
        }

        /* Style for the information panel */
        #info-panel {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            flex-grow: 1; /* Allow panel to grow */
            width: 100%; /* Full width on small screens */
        }

        #info-panel h3 {
            margin-top: 0;
            color: #007bff;
            font-size: 1.4em;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        #info-panel h4 {
            margin-top: 15px;
            margin-bottom: 10px;
            color: #333;
            font-size: 1.2em;
        }

        #info-panel p {
            margin-bottom: 8px;
            color: #555;
            line-height: 1.5;
            display: flex; /* Use flex to align icon and text */
            align-items: center;
        }

        #info-panel p i {
            margin-left: 10px; /* Space between icon and text */
            color: #007bff; /* Icon color */
        }

        /* Style for the location status text */
        #location-status {
            /* margin-top: 15px; -- Already handled by gap in wrapper or margin-bottom on elements above */
            font-size: 1.1em;
            color: #555;
            text-align: center; /* Ensure status text is centered */
            width: 100%; /* Take full width */
        }

        /* Responsive adjustments for larger screens */
        @media (min-width: 768px) {
            .map-and-info-wrapper {
                flex-direction: row; /* Arrange elements horizontally on larger screens */
                align-items: flex-start; /* Align items to the top */
            }

            #map {
                height: 600px; /* Increase map height on larger screens */
                flex-basis: 70%; /* Map takes 70% of the width */
                flex-shrink: 0; /* Prevent map from shrinking */
            }

            #info-panel {
                flex-basis: 30%; /* Info panel takes 30% of the width */
                flex-shrink: 0; /* Prevent panel from shrinking */
                width: auto; /* Auto width based on flex-basis */
            }

            /* Adjust location status alignment on larger screens if needed */
             #location-status {
                text-align: right; /* Align status text to the right in the info panel */
                margin-top: 0; /* Remove top margin if needed */
             }
        }

    </style>
</head>
<body>
    {{-- Navbar - Same as the home page --}}
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#">
                    <i class="fas fa-charging-station"></i> <span>شاحنّي</span>
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="#">الخريطة</a></li>
                <li><a href="{{ url('/nearest') }}">أقرب محطة</a></li> {{-- Link to this page --}}
                <li><a href="#">حول</a></li>
                <li><a href="#">اتصل بنا</a></li>
            </ul>
        </div>
    </nav>

    <main class="nearest-station-main">
        <div class="container">
             <h2>أقرب محطة شحن إليك</h2>
            <div class="map-and-info-wrapper">
                {{-- The div where the map will be rendered --}}
                <div id="map"></div>

                {{-- Information Panel --}}
                <div id="info-panel">
                    <h3>حالة الموقع وأقرب محطة</h3>
                    {{-- Paragraph to show location status --}}
                    <p id="location-status">جارٍ البحث عن موقعك...</p>

                    {{-- Placeholder for nearest station details --}}
                    <div id="nearest-station-details" style="display: none;">
                        <h4>أقرب محطة:</h4>
                        <p><i class="fas fa-charging-station"></i> <span id="station-name">اسم المحطة</span></p>
                        <p><i class="fas fa-map-marker-alt"></i> <span id="station-address">العنوان</span></p>
                        <p><i class="fas fa-route"></i> المسافة: <span id="station-distance">--</span> كم</p>
                        <p><i class="fa-solid fa-circle-info"></i> <span id="station-info">معلومات إضافية (وهمية)</span></p>
                        {{-- Add more details like connector types, status, etc. --}}
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer - Same as the home page --}}
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} شاحنّي. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    {{--
        JavaScript for Map and Geolocation
        This script should be placed at the end of the body
        to ensure the map container div is loaded before the script runs.
    --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the map
            // Set initial view to a default location (e.g., center of Jordan)
            // You can adjust the coordinates and zoom level
            const map = L.map('map').setView([31.9632, 35.9306], 8); // Coordinates for Amman, Jordan

            // Add OpenStreetMap tiles as the base layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Get the location status paragraph and details panel elements
            const locationStatus = document.getElementById('location-status');
            const nearestStationDetails = document.getElementById('nearest-station-details');
            const stationName = document.getElementById('station-name');
            const stationAddress = document.getElementById('station-address');
            const stationDistance = document.getElementById('station-distance');
            const stationInfo = document.getElementById('station-info'); // Get the info element

            // --- Dummy Charging Station Data (Expanded for Jordan) ---
            // const dummyStations = [...];
            const stations = @json($stations);

            console.log('Loaded stations data:', stations); // Debug 1: Log stations data

            // رسم المحطات الحقيقية على الخريطة
            stations.forEach(station => {
                if (station.latitude && station.longitude) {
                    // Construct the link using JavaScript
                    // const stationDetailsUrl = '/stations/' + station.id; // Removed this variable
                    L.marker([station.latitude, station.longitude])
                        .addTo(map)
                        .bindPopup(`<b>${station.name}</b><br>${station.location ?? ''}<br><a href="/stations/${station.id}">تفاصيل المحطة</a>`); // Construct URL directly in the string
                }
            });

            let nearestStation = null;
            let minDistance = Infinity;
            let nearestStationData = null;

            // دالة حساب المسافة بين نقطتين
            function calculateDistance(point1, point2) {
                // استخدام صيغة هافرساين لحساب المسافة على سطح كروي
                const R = 6371; // نصف قطر الأرض بالكيلومتر
                const dLat = (point2[0] - point1[0]) * Math.PI / 180;
                const dLon = (point2[1] - point1[1]) * Math.PI / 180;
                const a = 
                    Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(point1[0] * Math.PI / 180) * Math.cos(point2[0] * Math.PI / 180) * 
                    Math.sin(dLon/2) * Math.sin(dLon/2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                // المسافة بالكيلومترات
                const distance = R * c;
                return distance; // Distance in kilometers
            }
            
            // دالة لرسم المسار على الطريق باستخدام خدمة OSRM
            function drawRouteOnRoad(startPoint, endPoint) {
                // تحويل الإحداثيات إلى التنسيق المطلوب لـ OSRM (طول،عرض)
                // OSRM يتوقع [longitude, latitude] بينما Leaflet يستخدم [latitude, longitude]
                const startCoords = startPoint instanceof L.LatLng ? 
                    [startPoint.lng, startPoint.lat] : 
                    [startPoint[1], startPoint[0]];
                    
                const endCoords = endPoint instanceof L.LatLng ? 
                    [endPoint.lng, endPoint.lat] : 
                    [endPoint[1], endPoint[0]];
                
                // تكوين رابط طلب المسار من OSRM
                const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${startCoords[0]},${startCoords[1]};${endCoords[0]},${endCoords[1]}?overview=full&geometries=geojson`;
                
                // إضافة مؤشر تحميل
                locationStatus.textContent += ' جاري تحميل المسار...';
                
                // إرسال الطلب إلى خدمة OSRM
                fetch(osrmUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.routes && data.routes.length > 0) {
                            const routeGeometry = data.routes[0].geometry;
                            // تحويل إحداثيات المسار إلى تنسيق Leaflet [lat, lng]
                            const routeCoordinates = routeGeometry.coordinates.map(coord => [coord[1], coord[0]]);
                            
                            // إزالة أي مسارات سابقة إذا وجدت
                            if (window.routeLine) {
                                map.removeLayer(window.routeLine);
                            }
                            
                            // رسم المسار على الخريطة
                            window.routeLine = L.polyline(routeCoordinates, { 
                                color: 'blue', 
                                weight: 5,
                                opacity: 0.7
                            }).addTo(map);
                            
                            // ضبط حدود الخريطة لتشمل المسار كاملاً
                            map.fitBounds(window.routeLine.getBounds(), { padding: [50, 50] });
                            
                            // تحديث حالة التحميل
                            locationStatus.textContent = 'تم تحديد موقعك وعرض المسار إلى المحطة الأقرب.';
                            
                            // إذا كان لديك عنصر لعرض المسافة على الطريق
                            if (document.getElementById('routeDistance')) {
                                const distanceInMeters = data.routes[0].distance; // المسافة بالمتر
                                const distanceInKm = (distanceInMeters / 1000).toFixed(2);
                                document.getElementById('routeDistance').textContent = `المسافة على الطريق: ${distanceInKm} كم`;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('خطأ في جلب بيانات المسار:', error);
                        locationStatus.textContent = 'تعذر تحميل بيانات المسار. يتم عرض خط مباشر بديلاً.';
                        
                        // في حالة الفشل، ارسم خطاً مباشراً كخطة بديلة
                        const startLatLng = startPoint instanceof L.LatLng ? startPoint : L.latLng(startPoint[0], startPoint[1]);
                        const endLatLng = endPoint instanceof L.LatLng ? endPoint : L.latLng(endPoint[0], endPoint[1]);
                        
                        if (window.routeLine) {
                            map.removeLayer(window.routeLine);
                        }
                        
                        window.routeLine = L.polyline([startLatLng, endLatLng], {
                            color: 'red',
                            dashArray: '5, 10', // خط متقطع للإشارة إلى أنه ليس مساراً على الطريق
                            weight: 3
                        }).addTo(map);
                        
                        map.fitBounds(window.routeLine.getBounds());
                    });
            }

            // Try to get the user's current location
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    // Success callback
                    function(position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        const userLatLng = [userLat, userLng];

                        console.log('User location obtained:', userLatLng); // Debug 2: Log user location

                        // Update status
                        locationStatus.textContent = 'تم تحديد موقعك.';
                        locationStatus.style.color = '#007bff'; // Change color on success

                        // Center the map on the user's location
                        map.setView(userLatLng, 13); // Zoom in closer to the user's location

                        // Add a marker for the user's location
                        L.marker(userLatLng).addTo(map)
                            .bindPopup('<b>موقعك الحالي</b>').openPopup();

                        // Add markers for stations and find the nearest
                        stations.forEach(station => {
                            // استخدم الإحداثيات الصحيحة من بيانات الـ backend
                            if (station.latitude && station.longitude) {
                                const stationLatLng = [station.latitude, station.longitude];
                                const stationMarker = L.marker(stationLatLng).addTo(map)
                                    .bindPopup(`<b>${station.name}</b><br>${station.location ?? ''}<br><a href="/stations/${station.id}">تفاصيل المحطة</a>`);

                                // استخدام الدالة لحساب المسافة مع الإحداثيات الصحيحة
                                const distance = calculateDistance(userLatLng, stationLatLng);

                                if (distance < minDistance) {
                                    minDistance = distance;
                                    nearestStation = stationMarker;
                                    nearestStationData = station;
                                }
                            }
                        });

                        // Display nearest station details and highlight it
                        if (nearestStation && nearestStationData) {
                            // Update info panel
                            stationName.textContent = nearestStationData.name;
                            stationAddress.textContent = nearestStationData.location ?? ''; // استخدم location بدلاً من address إذا كان هذا هو الاسم
                            // Convert distance to kilometers and format
                            stationDistance.textContent = minDistance.toFixed(2);
                            stationInfo.textContent = nearestStationData.description || 'لا توجد معلومات إضافية'; // استخدم description بدلاً من info إذا كان هذا هو الاسم
                            nearestStationDetails.style.display = 'block'; // Show the details panel

                            // Highlight the nearest station marker (e.g., change color)
                             nearestStation.setIcon(L.icon({
                                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png', // Example: Red marker
                                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                                iconSize: [25, 41],
                                iconAnchor: [12, 41],
                                popupAnchor: [1, -34],
                                shadowSize: [41, 41]
                            }));
                             // تحديث محتوى الـ popup للمحطة الأقرب
                             nearestStation.setPopupContent(`<b>${nearestStationData.name}</b><br>${nearestStationData.location ?? ''}<br>الأقرب إليك`);

                             // رسم مسار على الطريق بدلاً من الخط الهوائي
                             drawRouteOnRoad(userLatLng, [nearestStationData.latitude, nearestStationData.longitude]);

                        } else {
                             // إذا لم يتم العثور على محطة قريبة (نظرياً لن يحدث مع البيانات المولدة)
                             nearestStationDetails.style.display = 'none';
                             locationStatus.textContent = 'تم تحديد موقعك، ولكن لم يتم العثور على محطات قريبة في نطاق البحث (قد تحتاج لضبط نطاق البحث أو إضافة المزيد من المحطات).';
                        }

                        console.log('Nearest station found:', nearestStationData); // Debug 3: Log nearest station data

                    },
                    // Error callback
                    function(error) {
                        console.error("Error getting user location:", error);
                        let errorMessage = 'تعذر تحديد موقعك.';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += ' يرجى السماح للموقع.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += ' معلومات الموقع غير متوفرة.';
                                break;
                            case error.TIMEOUT:
                                errorMessage += ' انتهت مهلة طلب الموقع.';
                                break;
                            case error.UNKNOWN_ERROR:
                                errorMessage += ' حدث خطأ غير معروف.';
                                break;
                        }
                        locationStatus.textContent = errorMessage;
                        locationStatus.style.color = 'red'; // Indicate error
                        nearestStationDetails.style.display = 'none'; // Hide details panel on error
                    }
                );
            } else {
                // Geolocation is not supported by the browser
                locationStatus.textContent = 'تحديد الموقع غير مدعوم في متصفحك.';
                locationStatus.style.color = 'red'; // Indicate error
                 nearestStationDetails.style.display = 'none'; // Hide details panel if geolocation not supported
            }
        });  
    </script>

    {{-- You can keep your external script.js file for other scripts --}}
    {{-- <script src="{{ asset('js/script.js') }}"></script> --}}

</body>
</html>

