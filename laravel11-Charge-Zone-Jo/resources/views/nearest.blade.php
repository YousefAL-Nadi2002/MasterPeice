<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أقرب محطة شحن - شاحنّي</title>
    {{-- Link to your main CSS file --}}
    {{-- Assuming your main CSS is style.css in the public folder --}}
    {{-- Use asset() to correctly link files from the public directory --}}
    <link rel="stylesheet" href="{{ asset('style.nearest.css') }}">

    {{-- If you have specific styles for this page, link them here using asset() --}}
    {{-- Example: <link rel="stylesheet" href="{{ asset('style.nearest.css') }}"> --}}
    {{-- Make sure the CSS for #map and the layout is in one of the linked CSS files --}}


    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Leaflet CSS for map - UPDATED INTEGRITY --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>

    {{-- Leaflet JS for map - UPDATED INTEGRITY --}}
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    {{-- You can put the specific CSS for this page here if you prefer not to use a separate file --}}
    
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
                        <p><i class="fas fa-charging-station"></i> <span id="station-name">اسم المحطة (وهمي)</span></p>
                        <p><i class="fas fa-map-marker-alt"></i> <span id="station-address">العنوان (وهمي)</span></p>
                        <p><i class="fas fa-route"></i> المسافة: <span id="station-distance">--</span> كم</p>
                        <p><i class="fa-solid fa-circle-info"></i> <span id="station-address"> معلومات عن المحطة</span></p>
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

            // Get the location status paragraph and details panel
            const locationStatus = document.getElementById('location-status');
            const nearestStationDetails = document.getElementById('nearest-station-details');
            const stationName = document.getElementById('station-name');
            const stationAddress = document.getElementById('station-address');
            const stationDistance = document.getElementById('station-distance');

            // Try to get the user's current location
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    // Success callback
                    function(position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        const userLatLng = [userLat, userLng];

                        // Update status
                        locationStatus.textContent = 'تم تحديد موقعك.';
                        locationStatus.style.color = '#007bff'; // Change color on success

                        // Center the map on the user's location
                        map.setView(userLatLng, 13); // Zoom in closer to the user's location

                        // Add a marker for the user's location
                        L.marker(userLatLng).addTo(map)
                            .bindPopup('<b>موقعك الحالي</b>').openPopup();

                        // --- Placeholder for finding nearest stations ---
                        // In a real application, you would fetch charging station data here
                        // based on the user's location and display them on the map.
                        // This requires a data source (API, database, etc.) and potentially
                        // server-side logic to calculate distances efficiently.

                        // Example: Simulate some dummy charging station locations near Amman
                        // In a real app, this data would come from your backend/API
                        const dummyStations = [
    { latlng: [31.9552, 35.9450], name: 'محطة الشروق', address: 'شارع الجامعة' },
    { latlng: [31.9800, 35.9200], name: 'محطة الغروب', address: 'الدوار السابع' },
    { latlng: [31.9400, 35.9600], name: 'محطة الأمل', address: 'شارع مكة' },
    { latlng: [32.0000, 35.9000], name: 'محطة النور', address: 'شارع الحرية' },
    // الموقع الجديد الذي أضفته - تأكد من الفاصلة قبل هذا السطر
    { latlng: [32.55301386893929, 36.007017264466306], name: 'محطة تكرم', address: 'الرمثا' }
    // تأكد من عدم وجود فاصلة بعد آخر عنصر في المصفوفة (بعد القوس } الأخير)
];

                        let nearestStation = null;
                        let minDistance = Infinity;
                        let nearestStationData = null;

                        // Add markers for dummy stations and find the nearest
                        dummyStations.forEach(station => {
                            const stationMarker = L.marker(station.latlng).addTo(map)
                                .bindPopup(`<b>${station.name}</b><br>${station.address}`); // Use dummy data in popup

                            // Calculate distance (using Leaflet's built-in distanceTo)
                            const distance = L.latLng(userLatLng).distanceTo(station.latlng); // Distance in meters

                            if (distance < minDistance) {
                                minDistance = distance;
                                nearestStation = stationMarker;
                                nearestStationData = station;
                            }
                        });

                        // Display nearest station details and highlight it
                        if (nearestStation && nearestStationData) {
                            // Update info panel
                            stationName.textContent = nearestStationData.name;
                            stationAddress.textContent = nearestStationData.address;
                            // Convert distance from meters to kilometers and format
                            stationDistance.textContent = (minDistance / 1000).toFixed(2);
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
                             nearestStation.setPopupContent(`<b>${nearestStationData.name}</b><br>${nearestStationData.address}<br>الأقرب إليك`);


                             // Optionally, draw a line from user to nearest station
                             const polyline = L.polyline([userLatLng, nearestStation.getLatLng()], {color: 'blue'}).addTo(map);
                             // Fit map bounds to include both user and nearest station
                             map.fitBounds(polyline.getBounds());
                        } else {
                             // If no stations found (in a real app, handle this case)
                             nearestStationDetails.style.display = 'none';
                             locationStatus.textContent += ' لم يتم العثور على محطات قريبة (بيانات وهمية).';
                        }


                        // --- End of Placeholder ---

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
