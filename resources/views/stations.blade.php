<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المحطة - شاحنّي</title>
    {{-- Link to your main CSS file --}}
    {{-- Assuming your main CSS is style.css or style.station-details.css in the public folder --}}
    {{-- Use asset() to correctly link files from the public directory --}}
    <link rel="stylesheet" href="{{ asset('style.station-details.css') }}">
    {{-- أو إذا كان ملف CSS الرئيسي هو style.css: --}}
    {{-- <link rel="stylesheet" href="{{ asset('style.css') }}"> --}}


    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- You can put the specific CSS for this page here if you prefer not to use a separate file --}}
    {{-- إذا كان style.station-details.css غير موجود أو لا يحتوي على التنسيقات، يمكنك وضعها هنا --}}
     <style>
        /* Base Styles */
        body {
            font-family: 'Cairo', sans-serif; /* خط عربي جميل */
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            direction: rtl; /* اتجاه النص من اليمين لليسار */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px; /* تم تعديل الحشو الأفقي ليبقى */
        }

        /* Navbar Styles */
        .navbar {
            background-color: #fff;
            padding: 9px 0; /* تأكد من أن هذا هو الحشو المطلوب */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo a {
            display: flex;
            align-items: center;
            color: #007bff;
            font-size: 1.5em;
            text-decoration: none;
            font-weight: bold;
        }

        .logo i {
            margin-left: 5px;
        }

        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-links li {
            margin-right: 20px;
        }

        .nav-links li:last-child {
            margin-right: 0;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #007bff;
        }

        /* Specific styles for Station Details page */
        .station-details-main {
            padding: 40px 0;
            background-color: #f4f4f4;
        }

        .station-details-main .container {
             padding: 20px;
             display: flex;
             flex-direction: column;
             gap: 30px; /* Space between sections */
        }

        .station-details-main h2 {
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .station-info-wrapper {
            display: flex;
            flex-direction: column; /* Stack vertically on mobile */
            gap: 30px;
        }

        .station-images {
            flex-basis: 50%; /* Images take 50% width on large screens */
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
            border-radius: 8px;
            overflow: hidden; /* Ensure image corners are rounded */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .station-images img {
            width: 100%;
            height: auto;
            display: block; /* Remove extra space below image */
            object-fit: cover; /* Cover the area without distorting aspect ratio */
            border-radius: 8px; /* Apply border-radius to images */
        }

        /* Style for a simple image gallery (if multiple images) */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Responsive grid */
            gap: 10px;
        }

        .image-gallery img {
            width: 100%;
            height: 150px; /* Fixed height for gallery thumbnails */
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer; /* Indicate clickable */
            transition: transform 0.2s ease;
        }

        .image-gallery img:hover {
            transform: scale(1.05);
        }

        .station-details-panel {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            flex-basis: 50%; /* Details take 50% width on large screens */
            flex-shrink: 0;
        }

        .station-details-panel h3 {
            margin-top: 0;
            color: #007bff;
            font-size: 1.6em;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .detail-item {
            margin-bottom: 15px;
            line-height: 1.6;
            color: #555;
            display: flex; /* Use flex to align icon and text */
            align-items: flex-start; /* Align items to the top */
        }

        .detail-item i {
            margin-left: 10px; /* Space between icon and text */
            color: #007bff; /* Icon color */
            font-size: 1.2em; /* Slightly larger icons */
            flex-shrink: 0; /* Prevent icon from shrinking */
            margin-top: 3px; /* Adjust vertical alignment */
        }

        .detail-item strong {
            color: #333;
            margin-left: 5px; /* Space between bold label and value */
        }

        /* Style for the booking button */
        .booking-button {
            display: inline-block;
            background-color: #28a745; /* Green color */
            color: #fff;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            font-size: 1.1em;
            margin-top: 20px;
            text-align: center; /* Center button text */
        }

        .booking-button:hover {
            background-color: #218838; /* Darker green */
        }

        .booking-button i {
            margin-left: 10px; /* Space between text and icon */
        }


        /* Footer Styles */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            font-size: 0.9em;
            margin-top: 20px;
        }

        footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }


        /* Responsive adjustments for larger screens */
        @media (min-width: 768px) {
            .station-info-wrapper {
                flex-direction: row; /* Arrange horizontally on larger screens */
                align-items: flex-start; /* Align items to the top */
            }

             .station-images {
                 flex-basis: 50%; /* Images take 50% width */
             }

             .station-details-panel {
                 flex-basis: 50%; /* Details take 50% width */
             }

             .station-details-main .container {
                 flex-direction: column; /* Keep main container as column */
             }


        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 767px) {
             .container {
                 padding: 0 15px; /* تقليل الحشو على الشاشات الصغيرة */
             }

             .station-details-main .container {
                 gap: 20px; /* Adjust gap on smaller screens */
             }

             .station-images {
                  box-shadow: none; /* Remove shadow on smaller screens */
             }

             .station-details-panel {
                  padding: 20px; /* Adjust padding */
             }

             .station-details-main h2 {
                 font-size: 2em; /* Adjust heading size */
             }

             .station-details-panel h3 {
                 font-size: 1.4em; /* Adjust sub-heading size */
             }

             .detail-item {
                 font-size: 0.95em;
             }

             .booking-button {
                 padding: 10px 20px; /* Adjust button padding */
                 font-size: 1em;
             }

             .image-gallery img {
                 height: 100px; /* Smaller height for gallery thumbnails on mobile */
             }

        }


    </style>
</head>
<body>
    {{-- Navbar - Same as other pages --}}
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
                <li><a href="{{ url('/accurate-location') }}">تحديد الموقع الدقيق</a></li>
                <li><a href="{{ url('/emergency') }}">مساعدة طارئة</a></li>
                <li><a href="#">حول</a></li>
                <li><a href="#">اتصل بنا</a></li>
                 {{-- Link to this page (placeholder) --}}
                {{-- <li><a href="{{ url('/station-details/123') }}">تفاصيل محطة</a></li> --}}
            </ul>
        </div>
    </nav>

    <main class="station-details-main">
        <div class="container">
            {{-- Station Name (Dynamic) --}}
            <h2>محطة تكرم للشحن السريع (الرمثا)</h2>

            <div class="station-info-wrapper">
                <div class="station-images">
                    {{-- Main Image (Dynamic) --}}
                    {{-- Replace with actual image URL from backend --}}
                    <img src="https://www.contactcars.com/_next/image?url=https%3A%2F%2Fcontactcars.fra1.cdn.digitaloceanspaces.com%2Fcontactcars-production%2FImages%2FSmall%2FNews%2Fff191536-1613-4cf7-a3b8-e756de858d73.jpg&w=3840&q=75" alt="صورة المحطة الرئيسية">

                    {{-- Image Gallery (Dynamic - if multiple images) --}}
                    {{-- Loop through station images from backend --}}
                    <div class="image-gallery">
                        <img src="https://attaqa.net/wp-content/uploads/2023/09/3a0092394aff4908f62eff1f8730d3d4.jpg" alt="صورة المحطة 1">
                        <img src="https://attaqa.net/wp-content/uploads/2023/09/283ea714ba84bbb51b605755fe0af8ee.jpeg" alt="صورة المحطة 2">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRdJh_BFJOJz49gAwd4gxHftgIP5yXIUP_59w&s" alt="صورة المحطة 3">
                        {{-- Add more images as needed --}}
                    </div>
                </div>

                <div class="station-details-panel">
                    <h3>معلومات المحطة</h3>

                    {{-- Station Details (Dynamic) --}}
                    {{-- Replace with actual data from backend --}}
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><strong>العنوان:</strong> <span id="station-address">شارع الرابية، عمان</span></span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-plug"></i>
                        <span><strong>أنواع الشواحن:</strong> <span id="charger-types">DC Fast Charger (CCS2), AC Charger (Type 2)</span></span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-bolt"></i>
                        <span><strong>قوة الشحن:</strong> <span id="charging-power">50 kW DC, 22 kW AC</span></span>
                    </div>
                     <div class="detail-item">
                         <i class="fas fa-charging-station"></i>
                         <span><strong>عدد نقاط الشحن:</strong> <span id="number-of-points">2 DC, 3 AC</span></span>
                     </div>
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <span><strong>ساعات العمل:</strong> <span id="opening-hours">مفتوح 24 ساعة</span></span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-dollar-sign"></i>
                        <span><strong>الأسعار:</strong> <span id="pricing">0.25 دينار/كيلوواط ساعة</span></span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span><strong>الحالة:</strong> <span id="status" style="color: green; font-weight: bold;">متوفر</span></span>
                         {{-- Example: <span id="status" style="color: red; font-weight: bold;">مشغول</span> --}}
                         {{-- Example: <span id="status" style="color: orange; font-weight: bold;">صيانة</span> --}}
                    </div>
                     <div class="detail-item">
                         <i class="fas fa-wifi"></i>
                         <span><strong>المرافق:</strong> <span id="amenities">مقهى قريب، واي فاي مجاني</span></span>
                     </div>
                      <div class="detail-item">
                         <i class="fas fa-info-circle"></i>
                         <span><strong>معلومات إضافية:</strong> <span id="additional-info">موقع هادئ، مناسب للانتظار.</span></span>
                     </div>


                    {{-- Booking Form --}}
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        {{-- Hidden input for station ID --}}
                        <input type="hidden" name="station_id" value="{{ $station->id }}">

                        {{-- Date, Time, and Duration Selection --}}
                        <div class="form-group">
                            <label for="booking_date">تاريخ الحجز المطلوب:</label>
                            <input type="date" id="booking_date" name="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="booking_time">وقت الحجز المطلوب:</label>
                            <input type="time" id="booking_time" name="time" class="form-control" required>
                        </div>
                         <div class="form-group">
                            <label for="booking_duration">مدة الحجز (بالساعات):</label>
                            <input type="number" id="booking_duration" name="estimated_duration" class="form-control" min="1" value="1" required>
                        </div>

                        {{-- Booking Button --}}
                        <button type="submit" class="booking-button">حجز موعد في هذه المحطة <i class="fas fa-calendar-check"></i></button>
                    </form>

                </div>
            </div>
        </div>
    </main>

    {{-- Footer - Same as other pages --}}
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} شاحنّي. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    {{-- You can add JavaScript here for image gallery functionality or fetching data if needed --}}
    <script>
        // Example: Simple script to change main image when clicking a thumbnail
        const mainImage = document.querySelector('.station-images img');
        const thumbnails = document.querySelectorAll('.image-gallery img');

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                mainImage.src = this.src; // Change main image source to thumbnail source
                // Optional: Add a class to highlight the active thumbnail
            });
        });

        // In a real application, you would fetch station data based on the URL parameter
        // For example, if the URL is /station-details/123, you would fetch data for station ID 123
        // This would typically be done in Laravel controller and passed to the Blade view.
        // The data would then populate the elements with IDs like station-name, station-address, etc.
        // Example (conceptual, not runnable here):
        /*
        async function fetchStationDetails(stationId) {
            try {
                const response = await fetch(`/api/stations/${stationId}`); // Example API endpoint
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const stationData = await response.json();

                // Populate the HTML elements with fetched data
                document.querySelector('.station-details-main h2').textContent = stationData.name;
                document.getElementById('station-address').textContent = stationData.address;
                document.getElementById('charger-types').textContent = stationData.charger_types.join(', '); // Assuming an array
                document.getElementById('charging-power').textContent = stationData.power;
                document.getElementById('number-of-points').textContent = stationData.num_points;
                document.getElementById('opening-hours').textContent = stationData.hours;
                document.getElementById('pricing').textContent = stationData.pricing;
                document.getElementById('status').textContent = stationData.status; // You might need logic to color this
                document.getElementById('amenities').textContent = stationData.amenities;
                document.getElementById('additional-info').textContent = stationData.info;

                // Update images (example assumes stationData.images is an array of URLs)
                if (stationData.images && stationData.images.length > 0) {
                    mainImage.src = stationData.images[0]; // Set first image as main
                    // Clear existing thumbnails and add new ones
                    const gallery = document.querySelector('.image-gallery');
                    gallery.innerHTML = ''; // Clear existing
                    stationData.images.forEach(imgUrl => {
                        const img = document.createElement('img');
                        img.src = imgUrl;
                        img.alt = 'صورة المحطة'; // Add alt text
                        gallery.appendChild(img);
                         // Re-attach click listener for new thumbnails
                         img.addEventListener('click', function() {
                            mainImage.src = this.src;
                         });
                    });
                }


            } catch (error) {
                console.error("Could not fetch station details:", error);
                // Display an error message to the user
                document.querySelector('.station-details-main h2').textContent = 'خطأ في تحميل تفاصيل المحطة';
                document.getElementById('station-address').textContent = 'تعذر تحميل البيانات.';
                // Hide other detail items or show error message
            }
        }

        // Example: Get station ID from URL (requires Laravel routing to pass ID)
        // const stationId = {{ $stationId ?? 'null' }}; // Assuming Laravel passes $stationId
        // if (stationId) {
        //     fetchStationDetails(stationId);
        // } else {
        //     console.warn('No station ID provided in URL.');
        //     // Display a message asking user to select a station
        // }
        */

    </script>

    {{-- You can keep your external script.js file for other scripts --}}
    {{-- <script src="{{ asset('js/script.js') }}"></script> --}}

</body>
</html>
