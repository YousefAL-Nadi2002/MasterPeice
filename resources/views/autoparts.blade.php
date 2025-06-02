<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قطع الغيار - شاحنّي</title>
    {{-- Link to your main CSS file --}}
    {{-- Assuming your main CSS is style.css or style.spare-parts.css in the public folder --}}
    {{-- Use asset() to correctly link files from the public directory --}}
    <link rel="stylesheet" href="{{ asset('style.spare-parts.css') }}">
    {{-- أو إذا كان ملف CSS الرئيسي هو style.css: --}}
    {{-- <link rel="stylesheet" href="{{ asset('style.css') }}"> --}}


    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- You can put the specific CSS for this page here if you prefer not to use a separate file --}}
    {{-- إذا كان style.spare-parts.css غير موجود أو لا يحتوي على التنسيقات، يمكنك وضعها هنا --}}
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

        /* Specific styles for Spare Parts page */
        .spare-parts-main {
            padding: 40px 0;
            background-color: #f4f4f4;
        }

        .spare-parts-main .container {
             padding: 20px;
             display: flex;
             flex-direction: column;
             gap: 30px; /* Space between sections */
        }

        .spare-parts-main h2 {
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        /* Filter Panel Styles */
        .filter-panel {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px; /* Space below the filter panel */
        }

        .filter-panel h3 {
            margin-top: 0;
            color: #007bff;
            font-size: 1.4em;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .filter-options {
            display: flex;
            flex-direction: column; /* Stack filters vertically on mobile */
            gap: 20px;
        }

        .filter-group {
            flex-grow: 1; /* Allow filter groups to grow */
        }

        .filter-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .filter-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
            background-color: #fff; /* Ensure background is white */
            cursor: pointer;
        }

        /* Parts List View */
        #parts-list-view {
            display: block; /* Initially visible */
        }

        .parts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Responsive grid */
            gap: 20px;
        }

        .part-item {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            cursor: pointer; /* Indicate clickable */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-align: center;
            padding-bottom: 15px; /* Padding below text */
        }

        .part-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .part-item img {
            width: 100%;
            height: 150px; /* Fixed height for grid images */
            object-fit: cover; /* Cover the area */
            display: block;
            margin-bottom: 10px;
        }

        .part-item h3 {
            font-size: 1.2em;
            color: #007bff;
            margin: 0 10px 5px; /* Margin around heading */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .part-item p {
            font-size: 0.9em;
            color: #555;
            margin: 0 10px; /* Margin around paragraph */
        }

        /* Part Details View */
        #part-details-view {
            display: none; /* Initially hidden */
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        #part-details-view h3 {
             margin-top: 0;
             color: #007bff;
             font-size: 1.6em;
             margin-bottom: 20px;
             border-bottom: 1px solid #eee;
             padding-bottom: 10px;
        }

        .details-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .details-images {
            flex-basis: 50%;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        #main-part-image {
            width: 100%;
            height: auto;
            max-height: 400px; /* Limit max height */
            object-fit: contain; /* Contain the image */
            display: block;
            border-radius: 8px;
             box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .details-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); /* Smaller thumbnails for details gallery */
            gap: 10px;
        }

        .details-gallery img {
            width: 100%;
            height: 80px; /* Fixed height for details thumbnails */
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .details-gallery img:hover {
            transform: scale(1.1);
        }


        .details-info {
            flex-basis: 50%;
            flex-shrink: 0;
        }

         .details-info h4 {
             margin-top: 0;
             margin-bottom: 15px;
             color: #333;
             font-size: 1.4em;
             border-bottom: 1px solid #eee;
             padding-bottom: 8px;
         }

        .detail-item-large {
            margin-bottom: 15px;
            line-height: 1.6;
            color: #555;
             display: flex; /* Use flex to align icon and text */
             align-items: flex-start; /* Align items to the top */
        }

         .detail-item-large i {
             margin-left: 10px; /* Space between icon and text */
             color: #007bff; /* Icon color */
             font-size: 1.3em; /* Slightly larger icons */
             flex-shrink: 0; /* Prevent icon from shrinking */
             margin-top: 3px; /* Adjust vertical alignment */
         }


        .detail-item-large strong {
            color: #333;
            margin-left: 5px; /* Space between bold label and value */
        }

         .contact-button {
            display: inline-block;
            background-color: #007bff; /* Blue color */
            color: #fff;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            font-size: 1.1em;
            margin-top: 20px;
            text-align: center;
         }

         .contact-button:hover {
             background-color: #0056b3; /* Darker blue */
         }

         .contact-button i {
             margin-left: 10px;
         }


        /* Back Button */
        #back-to-list {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #6c757d; /* Gray color */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1em;
        }

        #back-to-list:hover {
            background-color: #5a6268; /* Darker gray */
        }

        #back-to-list i {
            margin-right: 8px; /* Space between icon and text */
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
             .details-content {
                 flex-direction: row; /* Arrange horizontally on larger screens */
                 align-items: flex-start;
             }

             .details-images {
                 flex-basis: 50%;
             }

             .details-info {
                 flex-basis: 50%;
             }

            .filter-options {
                flex-direction: row; /* Arrange filters horizontally */
            }


        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 767px) {
             .container {
                 padding: 0 15px; /* تقليل الحشو على الشاشات الصغيرة */
             }

             .spare-parts-main .container {
                 gap: 20px; /* Adjust gap on smaller screens */
             }

             .spare-parts-main h2 {
                 font-size: 2em; /* Adjust heading size */
             }

             .parts-grid {
                 grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Adjust grid for smaller screens */
                 gap: 15px;
             }

             .part-item img {
                 height: 120px; /* Adjust grid image height */
             }

             .part-item h3 {
                 font-size: 1.1em;
             }

             .part-item p {
                 font-size: 0.85em;
             }

             #part-details-view {
                 padding: 20px; /* Adjust padding */
             }

             #part-details-view h3 {
                 font-size: 1.4em;
             }

             .details-gallery {
                 grid-template-columns: repeat(auto-fit, minmax(60px, 1fr)); /* Adjust details gallery grid */
                 gap: 8px;
             }

             .details-gallery img {
                 height: 60px; /* Adjust details thumbnail height */
             }

             .details-info h4 {
                  font-size: 1.2em;
             }

             .detail-item-large {
                 font-size: 0.9em;
             }

             .contact-button {
                 padding: 10px 20px;
                 font-size: 1em;
             }

             #back-to-list {
                 padding: 8px 15px;
                 font-size: 0.9em;
             }

            .filter-panel {
                 padding: 15px; /* Adjust filter panel padding */
            }

            .filter-panel h3 {
                 font-size: 1.2em;
                 margin-bottom: 15px;
                 padding-bottom: 8px;
            }

            .filter-options {
                 gap: 15px; /* Adjust gap in filter options */
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
                 {{-- Link to this page --}}
                <li><a href="{{ url('/spare-parts') }}">قطع الغيار</a></li>
                <li><a href="#">حول</a></li>
                <li><a href="#">اتصل بنا</a></li>
            </ul>
        </div>
    </nav>

    <main class="spare-parts-main">
        <div class="container">
            <h2>قطع غيار السيارات الكهربائية</h2>

            {{-- Filter Panel --}}
            <div class="filter-panel">
                <h3>تصفية قطع الغيار</h3>
                <div class="filter-options">
                    <div class="filter-group">
                        <label for="car-make">نوع السيارة (Make):</label>
                        <select id="car-make">
                            <option value="">جميع الأنواع</option>
                            {{-- Options will be populated by JS --}}
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="car-model">موديل السيارة (Model):</label>
                        <select id="car-model" disabled> {{-- Disable initially --}}
                            <option value="">جميع الموديلات</option>
                            {{-- Options will be populated by JS --}}
                        </select>
                    </div>
                    {{-- Optional: Add more filter groups here (e.g., Part Type, Condition, Price Range) --}}
                    {{-- <div class="filter-group">
                        <label for="part-type">نوع القطعة:</label>
                        <select id="part-type">
                            <option value="">جميع الأنواع</option>
                            <option value="battery">بطارية</option>
                            <option value="motor">محرك</option>
                            <option value="charger">شاحن</option>
                            </select>
                    </div> --}}
                </div>
            </div>

            {{-- Parts List View --}}
            <div id="parts-list-view">
                <div class="parts-grid" id="parts-grid">
                    {{-- سيتم توليد جميع العناصر عبر جافاسكريبت --}}
                </div>
            </div>

            {{-- Part Details View --}}
            <div id="part-details-view">
                <button id="back-to-list"><i class="fas fa-arrow-right"></i> العودة إلى القائمة</button> {{-- Back button --}}

                <h3 id="part-details-title">تفاصيل القطعة</h3> {{-- Part Name (Dynamic) --}}

                <div class="details-content">
                    <div class="details-images">
                        {{-- Main Part Image (Dynamic) --}}
                        <img id="main-part-image" src="https://placehold.co/800x400/E9ECEF/343A40?text=صورة+القطعة+الرئيسية" alt="صورة القطعة الرئيسية">

                        {{-- Details Image Gallery (Dynamic - if multiple images) --}}
                        <div class="details-gallery" id="details-gallery">
                            {{-- Thumbnails will be loaded here by JS --}}
                        </div>
                    </div>

                    <div class="details-info">
                        <h4>معلومات عن القطعة</h4>
                        {{-- Part Details (Dynamic) --}}
                        <div class="detail-item-large">
                            <i class="fas fa-car-battery"></i>
                            <span><strong>نوع القطعة:</strong> <span id="detail-type"></span></span>
                        </div>
                         <div class="detail-item-large">
                            <i class="fas fa-tags"></i>
                            <span><strong>الحالة:</strong> <span id="detail-condition"></span></span>
                        </div>
                        <div class="detail-item-large">
                            <i class="fas fa-car"></i>
                            <span><strong>متوافقة مع:</strong> <span id="detail-compatibility"></span></span>
                        </div>
                         <div class="detail-item-large">
                            <i class="fas fa-file-alt"></i>
                            <span><strong>وصف إضافي:</strong> <span id="detail-description"></span></span>
                        </div>
                        <div class="detail-item-large">
                            <i class="fas fa-dollar-sign"></i>
                            <span><strong>السعر المطلوب:</strong> <span id="detail-price"></span></span>
                        </div>
                         <div class="detail-item-large">
                            <i class="fas fa-user"></i>
                            <span><strong>اسم البائع:</strong> <span id="detail-seller-name"></span></span>
                        </div>
                         <div class="detail-item-large">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><strong>موقع القطعة:</strong> <span id="detail-location"></span></span>
                        </div>


                        <h4>معلومات التواصل</h4>
                         {{-- Contact Info (Dynamic) --}}
                        <div class="detail-item-large">
                            <i class="fas fa-phone"></i>
                            <span><strong>الهاتف:</strong> <span id="detail-phone"></span></span>
                        </div>
                         <div class="detail-item-large">
                            <i class="fab fa-whatsapp"></i>
                            <span><strong>واتساب:</strong> <span id="detail-whatsapp"></span></span>
                        </div>
                         <div class="detail-item-large">
                            <i class="fas fa-envelope"></i>
                            <span><strong>البريد الإلكتروني:</strong> <span id="detail-email"></span></span>
                        </div>

                         {{-- Contact Button (Optional - if a contact form/modal is used) --}}
                         <a href="#" class="contact-button">التواصل مع البائع <i class="fas fa-comment-dots"></i></a>

                    </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const partsListView = document.getElementById('parts-list-view');
            const partDetailsView = document.getElementById('part-details-view');
            const backToListButton = document.getElementById('back-to-list');
            const partsGrid = document.getElementById('parts-grid'); // Get the grid container

            // Filter Elements
            const carMakeSelect = document.getElementById('car-make');
            const carModelSelect = document.getElementById('car-model');

            // Details View Elements
            const partDetailsTitle = document.getElementById('part-details-title');
            const mainPartImage = document.getElementById('main-part-image');
            const detailsGallery = document.getElementById('details-gallery');
            const detailType = document.getElementById('detail-type');
            const detailCondition = document.getElementById('detail-condition');
            const detailCompatibility = document.getElementById('detail-compatibility');
            const detailDescription = document.getElementById('detail-description');
            const detailPrice = document.getElementById('detail-price');
            const detailSellerName = document.getElementById('detail-seller-name');
            const detailLocation = document.getElementById('detail-location');
            const detailPhone = document.getElementById('detail-phone');
            const detailWhatsapp = document.getElementById('detail-whatsapp');
            const detailEmail = document.getElementById('detail-email');

            // بيانات قطع الغيار من قاعدة البيانات (Laravel)
            const dbParts = @json($sparePartsForJs);
            // دمج القطع الحقيقية مع الوهمية
            const allPartsData = dbParts;

            // تحديث الفلاتر لتشمل الجميع
            const availableMakes = [...new Set(allPartsData.map(part => part.make).filter(Boolean))].sort();
            const availableModels = {};
            availableMakes.forEach(make => {
                availableModels[make] = [...new Set(allPartsData.filter(part => part.make === make).map(part => part.model).filter(Boolean))].sort();
            });

            // Function to populate the Make dropdown
            function populateMakeDropdown() {
                carMakeSelect.innerHTML = '<option value="">جميع الأنواع</option>'; // Add default option
                availableMakes.forEach(make => {
                    const option = document.createElement('option');
                    option.value = make;
                    option.textContent = make;
                    carMakeSelect.appendChild(option);
                });
            }

            // Function to populate the Model dropdown based on selected Make
            function populateModelDropdown(selectedMake) {
                carModelSelect.innerHTML = '<option value="">جميع الموديلات</option>'; // Add default option
                carModelSelect.disabled = true; // Disable by default

                if (selectedMake && availableModels[selectedMake]) {
                    availableModels[selectedMake].forEach(model => {
                        const option = document.createElement('option');
                        option.value = model;
                        option.textContent = model;
                        carModelSelect.appendChild(option);
                    });
                    carModelSelect.disabled = false; // Enable if a make is selected and models exist
                }
            }

            // تعديل renderPartsList ليعرض الجميع
            function renderPartsList(partsToRender) {
                partsGrid.innerHTML = '';
                if (partsToRender.length === 0) {
                    partsGrid.innerHTML = '<p style="text-align: center; color: #555;">لا توجد قطع غيار مطابقة لمعايير التصفية.</p>';
                    return;
                }
                partsToRender.forEach(part => {
                    if (part.is_real) {
                        const a = document.createElement('a');
                        a.href = `/autoparts/${part.id}`;
                        a.className = 'part-item';
                        a.style.textDecoration = 'none';
                        a.style.color = 'inherit';
                        a.innerHTML = `
                            <img src="${part.image}" alt="صورة ${part.name}">
                            <h3>${part.name}</h3>
                            <p>${part.description || ''}</p>
                            @if(auth()->check() && auth()->user()->is_admin)
                          
                            @endif
                        `;
                        partsGrid.appendChild(a);
                    } else {
                        // كرت وهمي
                        const partItem = document.createElement('div');
                        partItem.classList.add('part-item');
                        partItem.dataset.partId = part.id;
                        const imageUrl = part.images && part.images.length > 0 ? part.images[0] : 'https://placehold.co/300x150/E9ECEF/343A40?text=لا+توجد+صورة';
                        partItem.innerHTML = `
                            <img src="${imageUrl}" alt="صورة ${part.name}">
                            <h3>${part.name}</h3>
                            <p>${part.shortDescription}</p>
                        `;
                        partItem.addEventListener('click', function() {
                            const partId = parseInt(this.dataset.partId);
                            showPartDetails(partId);
                        });
                        partsGrid.appendChild(partItem);
                    }
                });
            }


            // Function to display part details
            function showPartDetails(partId) {
                const part = allPartsData.find(p => p.id === partId); // Find the part by ID

                if (part) {
                    // Populate details view with part data
                    partDetailsTitle.textContent = part.name;
                    mainPartImage.src = part.image || 'https://placehold.co/800x400/E9ECEF/343A40?text=لا+توجد+صورة'; // Set main image
                    mainPartImage.alt = `صورة ${part.name} الرئيسية`;

                    // Populate gallery
                    detailsGallery.innerHTML = ''; // Clear existing thumbnails
                    if (part.images && part.images.length > 0) {
                         part.images.forEach(imgUrl => {
                             const img = document.createElement('img');
                             img.src = imgUrl;
                             img.alt = `صورة ${part.name}`;
                             img.addEventListener('click', function() {
                                 mainPartImage.src = this.src; // Change main image on thumbnail click
                             });
                             detailsGallery.appendChild(img);
                         });
                    } else {
                         detailsGallery.innerHTML = '<p style="text-align: center; color: #555;">لا توجد صور إضافية.</p>';
                    }


                    // Populate info details
                    detailType.textContent = part.type || '--';
                    detailCondition.textContent = part.condition || '--';
                    detailCompatibility.textContent = part.compatibility || '--';
                    detailDescription.textContent = part.description || '--';
                    detailPrice.textContent = part.price || '--';
                    detailSellerName.textContent = part.sellerName || '--';
                    detailLocation.textContent = part.location || '--';
                    detailPhone.textContent = part.phone || '--';
                    detailWhatsapp.textContent = part.whatsapp || '--';
                    detailEmail.textContent = part.email || '--';

                    // Show details view and hide list view
                    partsListView.style.display = 'none';
                    partDetailsView.style.display = 'block';

                    // Scroll to the top of the details view
                     partDetailsView.scrollIntoView({ behavior: 'smooth' });

                } else {
                    console.error(`Part with ID ${partId} not found.`);
                    alert('تعذر العثور على تفاصيل هذه القطعة.');
                }
            }

            // --- Filter Logic ---
            function applyFilters() {
                const selectedMake = carMakeSelect.value;
                const selectedModel = carModelSelect.value;

                let filteredParts = allPartsData;

                if (selectedMake) {
                    filteredParts = filteredParts.filter(part => part.make === selectedMake);
                }

                if (selectedModel) {
                    filteredParts = filteredParts.filter(part => part.model === selectedModel);
                }

                renderPartsList(filteredParts); // Render the filtered list
            }

            // Event listeners for filters
            carMakeSelect.addEventListener('change', function() {
                const selectedMake = this.value;
                populateModelDropdown(selectedMake); // Update model dropdown
                applyFilters(); // Apply filters when make changes
            });

            carModelSelect.addEventListener('change', function() {
                applyFilters(); // Apply filters when model changes
            });

            // --- Initial Setup ---
            populateMakeDropdown(); // Populate the make dropdown on page load
            renderPartsList(allPartsData); // Render the full list initially

            // Add click listener to the back button
            backToListButton.addEventListener('click', function() {
                // Hide details view and show list view
                partDetailsView.style.display = 'none';
                partsListView.style.display = 'block';

                // Scroll to the top of the list view
                 partsListView.scrollIntoView({ behavior: 'smooth' });
            });

        });
    </script>

    {{-- You can keep your external script.js file for other scripts --}}
    {{-- <script src="{{ asset('js/script.js') }}"></script> --}}

</body>
</html>
