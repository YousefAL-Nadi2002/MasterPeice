<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مساعدة طارئة - شاحنّي</title>
    {{-- Link to your main CSS file --}}
    {{-- Assuming your main CSS is style.css in the public folder --}}
    <link rel="stylesheet" href="{{ asset('style.help.css') }}">

    {{-- Link to specific CSS for this page --}}
    <link rel="stylesheet" href="{{ asset('style.emergency.css') }}"> {{-- سنضع التنسيقات الجديدة هنا --}}

    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                <li><a href="#">أقرب محطة</a></li>
                <li><a href="#">حول</a></li>
                <li><a href="#">اتصل بنا</a></li>
                 {{-- Link to this page --}}
            </ul>
        </div>
    </nav>

    <main class="emergency-main">
        <div class="container">
            <h2>خدمات المساعدة الطارئة</h2>
            <p class="page-description">في حالات الطوارئ، يمكنك طلب إحدى الخدمات التالية لمساعدتك على الطريق.</p>

            <div class="emergency-services-grid">
                {{-- Service Card: Mobile Charging --}}
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-car-battery"></i> {{-- أيقونة شحن متنقل --}}
                    </div>
                    <div class="service-details">
                        <h3>شحن متنقل</h3>
                        <p>طلب وحدة شحن متنقلة للوصول إليك وشحن سيارتك في موقعك الحالي.</p>
                        <a href="#" class="service-button">طلب شحن متنقل <i class="fas fa-arrow-left"></i></a>
                    </div>
                </div>

                {{-- Service Card: Vehicle Towing --}}
                <div class="service-card">
                     <div class="service-icon">
                        <i class="fa-solid fa-truck-fast"></i> {{-- أيقونة سحب/رفع سيارة --}}
                    </div>
                    <div class="service-details">
                        <h3>خدمة رفع السيارة</h3>
                        <p>طلب خدمة رفع أو سحب السيارة في حال تعطلها أو نفاد شحنها بالكامل.</p>
                        <a href="#" class="service-button">طلب خدمة رفع <i class="fas fa-arrow-left"></i></a>
                    </div>
                </div>

                {{-- Service Card: Contact Team --}}
                <div class="service-card">
                     <div class="service-icon">
                        <i class="fas fa-headset"></i> {{-- أيقونة تواصل --}}
                    </div>
                    <div class="service-details">
                        <h3>التواصل مع الفريق</h3>
                        <p>تواصل مباشرة مع فريق الدعم المختص للحصول على المساعدة أو الاستشارة.</p>
                        <a href="#" class="service-button">اتصل بنا <i class="fas fa-arrow-left"></i></a>
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

    {{-- You can add specific JavaScript for forms/requests here or in a separate file --}}
    {{-- <script src="{{ asset('js/emergency.js') }}"></script> --}}

</body>
</html>

