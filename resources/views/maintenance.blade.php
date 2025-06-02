<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خدمات الصيانة - شاحنّي</title>
    {{-- Link to your main CSS file --}}
    {{-- Assuming your main CSS is style.css or style.maintenance.css in the public folder --}}
    {{-- Use asset() to correctly link files from the public directory --}}
    <link rel="stylesheet" href="{{ asset('style.maintenance.css') }}">
    {{-- أو إذا كان ملف CSS الرئيسي هو style.css: --}}
    {{-- <link rel="stylesheet" href="{{ asset('style.css') }}"> --}}


    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- You can put the specific CSS for this page here if you prefer not to use a separate file --}}
    {{-- إذا كان style.maintenance.css غير موجود أو لا يحتوي على التنسيقات، يمكنك وضعها هنا --}}
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

        /* Specific styles for Maintenance page */
        .maintenance-main {
            padding: 40px 0;
            background-color: #f4f4f4;
        }

        .maintenance-main .container {
             padding: 20px;
             display: flex;
             flex-direction: column;
             gap: 30px; /* Space between sections */
        }

        .maintenance-main h2 {
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        /* Service Type Selection */
        #service-type-selection {
            display: flex;
            justify-content: center; /* Center the buttons */
            gap: 30px; /* Space between buttons */
            margin-bottom: 30px;
             flex-wrap: wrap; /* Allow wrapping on smaller screens */
        }

        .service-type-button {
            background-color: #007bff;
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            flex-grow: 1; /* Allow buttons to grow */
            max-width: 300px; /* Limit max width */
            text-align: center;
        }

        .service-type-button:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

         .service-type-button i {
             margin-left: 10px;
         }


        /* Service Lists */
        .service-list {
            display: none; /* Initially hidden */
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .service-list h3 {
            margin-top: 0;
            color: #28a745; /* Green color for service list title */
            font-size: 1.6em;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .service-item {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #eee; /* Dashed separator */
            line-height: 1.6;
            color: #555;
            cursor: pointer; /* Indicate clickable */
            transition: background-color 0.2s ease;
        }

         .service-item:hover {
             background-color: #f9f9f9; /* Slight hover effect */
         }


        .service-item:last-child {
            border-bottom: none; /* No border for the last item */
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .service-item strong {
            color: #333;
            font-size: 1.1em;
            display: block; /* Make service name a block */
            margin-bottom: 5px;
        }

        .service-item p {
            margin: 0; /* Remove default paragraph margin */
        }

         .service-item i {
             margin-left: 8px;
             color: #007bff; /* Icon color */
         }

        /* Provider List Styles */
        #provider-list-view {
            display: none; /* Initially hidden */
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        #provider-list-view h3 {
             margin-top: 0;
             color: #007bff; /* Blue color for provider list title */
             font-size: 1.6em;
             margin-bottom: 20px;
             border-bottom: 1px solid #eee;
             padding-bottom: 10px;
        }

        .provider-item {
             margin-bottom: 20px;
             padding-bottom: 15px;
             border-bottom: 1px dashed #eee;
             line-height: 1.6;
             color: #555;
        }

         .provider-item:last-child {
             border-bottom: none;
             margin-bottom: 0;
             padding-bottom: 0;
         }

         .provider-item h4 {
             margin-top: 0;
             margin-bottom: 10px;
             color: #333;
             font-size: 1.2em;
         }

         .provider-item p {
             margin-bottom: 8px;
             display: flex; /* Use flex to align icon and text */
             align-items: center;
         }

         .provider-item p i {
             margin-left: 10px;
             color: #28a745; /* Green icon color */
         }

         .provider-item p a {
             color: #555; /* Default text color for links */
             text-decoration: none;
             transition: color 0.3s ease;
         }

         .provider-item p a:hover {
             color: #007bff; /* Highlight color on hover */
             text-decoration: underline;
         }


        /* Back Button */
        .back-button {
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

        .back-button:hover {
            background-color: #5a6268; /* Darker gray */
        }

        .back-button i {
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


        /* Responsive adjustments for smaller screens */
        @media (max-width: 767px) {
             .container {
                 padding: 0 15px; /* تقليل الحشو على الشاشات الصغيرة */
             }

             .maintenance-main .container {
                 gap: 20px; /* Adjust gap between sections */
             }

             .maintenance-main h2 {
                 font-size: 2em; /* Adjust heading size */
             }

             #service-type-selection {
                 flex-direction: column; /* Stack buttons vertically */
                 gap: 15px; /* Adjust gap */
             }

             .service-type-button {
                 font-size: 1em; /* Adjust button font size */
                 padding: 12px 20px;
                 max-width: none; /* Remove max width */
             }

             .service-list,
             #provider-list-view { /* Apply padding to both lists */
                 padding: 20px; /* Adjust padding */
             }

             .service-list h3,
             #provider-list-view h3 { /* Apply title styles to both */
                 font-size: 1.4em; /* Adjust sub-heading size */
                 margin-bottom: 15px;
                 padding-bottom: 8px;
             }

             .service-item {
                 font-size: 0.95em;
                 margin-bottom: 15px;
                 padding-bottom: 10px;
             }

             .service-item strong {
                 font-size: 1em;
             }

             .provider-item h4 {
                  font-size: 1.1em;
             }

             .provider-item p {
                  font-size: 0.95em;
             }

             .back-button {
                 padding: 8px 15px;
                 font-size: 0.9em;
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
                <li><a href="{{ url('/spare-parts') }}">قطع الغيار</a></li>
                <li><a href="{{ url('/contact-advertise') }}">تواصل معنا / أعلن هنا</a></li>
                <li><a href="{{ url('/about-us') }}">حول</a></li>
                 {{-- Link to this page --}}
                <li><a href="{{ url('/maintenance') }}">خدمات الصيانة</a></li>
            </ul>
        </div>
    </nav>

    <main class="maintenance-main">
        <div class="container">
            <h2>خدمات صيانة السيارات الكهربائية</h2>

            {{-- Service Type Selection --}}
            <div id="service-type-selection">
                <button class="service-type-button" data-service-type="electrical">
                    صيانة كهربائية <i class="fas fa-bolt"></i>
                </button>
                <button class="service-type-button" data-service-type="mechanical">
                    صيانة ميكانيكية <i class="fas fa-cogs"></i>
                </button>
            </div>

            {{-- Electrical Maintenance Services List --}}
            <div id="electrical-services-list" class="service-list">
                <h3>خدمات الصيانة الكهربائية</h3>
                {{-- Services will be dynamically loaded here by JS --}}
            </div>

            {{-- Mechanical Maintenance Services List --}}
            <div id="mechanical-services-list" class="service-list">
                <h3>خدمات الصيانة الميكانيكية</h3>
                 {{-- Services will be dynamically loaded here by JS --}}
            </div>

             {{-- Provider List View (Initially hidden) --}}
            <div id="provider-list-view">
                <button id="back-to-services-list" class="back-button"><i class="fas fa-arrow-right"></i> العودة إلى قائمة الخدمات</button> {{-- Back button --}}
                <h3 id="provider-list-title">مقدمو الخدمة: <span id="selected-service-name"></span></h3> {{-- Title will show selected service name --}}
                <div id="providers-list-container">
                    {{-- Providers will be dynamically loaded here by JS --}}
                </div>
            </div>


        </div>
    </main>

    {{-- Footer - Same as other pages --}}
    <footer>
        <div class="container">
            <p>© {{ date('Y') }} شاحنّي. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceTypeSelection = document.getElementById('service-type-selection');
            const electricalServicesList = document.getElementById('electrical-services-list');
            const mechanicalServicesList = document.getElementById('mechanical-services-list');
            const serviceTypeButtons = document.querySelectorAll('.service-type-button');

            // New elements for Provider List View
            const providerListView = document.getElementById('provider-list-view');
            const backToServicesListButton = document.getElementById('back-to-services-list');
            const providerListTitle = document.getElementById('provider-list-title');
            const selectedServiceNameSpan = document.getElementById('selected-service-name');
            const providersListContainer = document.getElementById('providers-list-container');

            let currentServiceType = null; // To keep track of the currently displayed service type list

            // جلب الخدمات من الباك اند
            const electricalServices = @json($electricalServices);
            const mechanicalServices = @json($mechanicalServices);

            // Function to render services in a list
            function renderServices(serviceType, services) {
                const listElement = serviceType === 'electrical' ? electricalServicesList : mechanicalServicesList;
                listElement.innerHTML = `<h3>خدمات الصيانة ${serviceType === 'electrical' ? 'الكهربائية' : 'الميكانيكية'}</h3>`;
                if (services.length === 0) {
                    listElement.innerHTML += '<p style="text-align: center; color: #555;">لا توجد خدمات متاحة حالياً في هذه الفئة.</p>';
                    return;
                }
                services.forEach(service => {
                    const serviceItem = document.createElement('div');
                    serviceItem.classList.add('service-item');
                    serviceItem.dataset.serviceId = service.id;
                    serviceItem.dataset.serviceType = serviceType;
                    serviceItem.innerHTML = `
                        <strong><i class="fas fa-check-circle"></i> ${service.name}</strong>
                        <p>${service.description}</p>
                    `;
                    listElement.appendChild(serviceItem);
                });
                const serviceItems = listElement.querySelectorAll('.service-item');
                serviceItems.forEach(item => {
                    item.addEventListener('click', function() {
                        const serviceId = this.dataset.serviceId;
                        const serviceType = this.dataset.serviceType;
                        showProvidersList(serviceId, serviceType);
                    });
                });
            }

            // Function to render providers for a specific service
            function renderProviders(providers) {
                providersListContainer.innerHTML = ''; // Clear current list

                if (!providers || providers.length === 0) {
                    providersListContainer.innerHTML = '<p style="text-align: center; color: #555;">لا يوجد مقدمو خدمة متاحون لهذه الخدمة حالياً.</p>';
                    return;
                }

                providers.forEach(provider => {
                    const providerItem = document.createElement('div');
                    providerItem.classList.add('provider-item');
                    providerItem.innerHTML = `
                        <h4>${provider.name}</h4>
                        <p><i class="fas fa-map-marker-alt"></i> الموقع: ${provider.location || '--'}</p>
                        <p><i class="fas fa-phone"></i> الهاتف: <a href="tel:${provider.phone}">${provider.phone || '--'}</a></p>
                        <p><i class="fab fa-whatsapp"></i> واتساب: <a href="https://wa.me/${provider.whatsapp}" target="_blank">${provider.whatsapp || '--'}</a></p>
                        <p><i class="fas fa-envelope"></i> البريد الإلكتروني: <a href="mailto:${provider.email}">${provider.email || '--'}</a></p>
                         {{-- Add other contact info or details if needed --}}
                    `;
                    providersListContainer.appendChild(providerItem);
                });
            }


            // Function to show a specific service list and hide others
            function showServiceList(serviceType) {
                electricalServicesList.style.display = 'none';
                mechanicalServicesList.style.display = 'none';
                providerListView.style.display = 'none';
                if (serviceType === 'electrical') {
                    electricalServicesList.style.display = 'block';
                    renderServices('electrical', electricalServices);
                    currentServiceType = 'electrical';
                } else if (serviceType === 'mechanical') {
                    mechanicalServicesList.style.display = 'block';
                    renderServices('mechanical', mechanicalServices);
                    currentServiceType = 'mechanical';
                }
                const displayedList = document.querySelector('.service-list[style*="display: block"]');
                if (displayedList) {
                    displayedList.scrollIntoView({ behavior: 'smooth' });
                }
            }

            // Function to show the provider list for a selected service
            function showProvidersList(serviceId, serviceType) {
                let service = null;
                if (serviceType === 'electrical') {
                    service = electricalServices.find(s => s.id == serviceId);
                } else {
                    service = mechanicalServices.find(s => s.id == serviceId);
                }
                if (service) {
                    selectedServiceNameSpan.textContent = service.name;
                    renderProviders(service.providers);
                    if (serviceType === 'electrical') {
                        electricalServicesList.style.display = 'none';
                    } else {
                        mechanicalServicesList.style.display = 'none';
                    }
                    providerListView.style.display = 'block';
                    providerListView.scrollIntoView({ behavior: 'smooth' });
                } else {
                    alert('تعذر العثور على تفاصيل الخدمة.');
                }
            }


            // Add click listeners to the service type buttons
            serviceTypeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const serviceType = this.dataset.serviceType;
                    showServiceList(serviceType);
                });
            });

            // Add click listener to the back button in the provider list
            backToServicesListButton.addEventListener('click', function() {
                providerListView.style.display = 'none';
                if (currentServiceType === 'electrical') {
                    electricalServicesList.style.display = 'block';
                } else if (currentServiceType === 'mechanical') {
                    mechanicalServicesList.style.display = 'block';
                }
                const displayedList = document.querySelector('.service-list[style*="display: block"]');
                if (displayedList) {
                    displayedList.scrollIntoView({ behavior: 'smooth' });
                }
            });

            // عند تحميل الصفحة، أظهر الخدمات الكهربائية افتراضياً
            showServiceList('electrical');
        });
    </script>

    {{-- You can keep your external script.js file for other scripts --}}
    {{-- <script src="{{ asset('js/script.js') }}"></script> --}}

</body>
</html>
