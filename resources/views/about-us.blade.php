<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حول شاحنّي - شاحنّي</title>
    {{-- Link to your main CSS file --}}
    {{-- Assuming your main CSS is style.css or style.about.css in the public folder --}}
    {{-- Use asset() to correctly link files from the public directory --}}
    <link rel="stylesheet" href="{{ asset('style.about.css') }}">
    {{-- أو إذا كان ملف CSS الرئيسي هو style.css: --}}
    {{-- <link rel="stylesheet" href="{{ asset('style.css') }}"> --}}


    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- You can put the specific CSS for this page here if you prefer not to use a separate file --}}
    {{-- إذا كان style.about.css غير موجود أو لا يحتوي على التنسيقات، يمكنك وضعها هنا --}}
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

        /* Specific styles for About Us page */
        .about-main {
            padding: 40px 0;
            background-color: #f4f4f4;
        }

        .about-main .container {
             padding: 20px;
             display: flex;
             flex-direction: column;
             gap: 40px; /* Space between sections */
        }

        .about-main h2 {
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .video-section {
            text-align: center; /* Center the video */
        }

        .video-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #000; /* Placeholder background */
        }

        .video-container iframe,
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .story-section {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .story-section h3 {
            margin-top: 0;
            color: #007bff;
            font-size: 1.6em;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .story-content p {
            margin-bottom: 15px;
            line-height: 1.7;
            color: #555;
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

             .about-main .container {
                 gap: 30px; /* Adjust gap between sections */
             }

             .about-main h2 {
                 font-size: 2em; /* Adjust heading size */
             }

             .story-section {
                 padding: 20px; /* Adjust padding */
             }

             .story-section h3 {
                 font-size: 1.4em; /* Adjust sub-heading size */
                 margin-bottom: 15px;
                 padding-bottom: 8px;
             }

             .story-content p {
                 font-size: 0.95em;
             }

             .video-container {
                 padding-bottom: 75%; /* Adjust aspect ratio for potentially taller mobile videos (e.g., 4:3 or 3:4) if needed, 16:9 is common though */
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
                 {{-- Link to this page --}}
                <li><a href="{{ url('/about-us') }}">حول</a></li>
            </ul>
        </div>
    </nav>

    <main class="about-main">
        <div class="container">
            <h2>حول شاحنّي</h2>

            {{-- Video Section --}}
            <div class="video-section">
                <h3>شاهد قصتنا</h3>
                <div class="video-container">
                    {{-- Replace the src with your actual video embed URL (e.g., YouTube, Vimeo) --}}
                    {{-- Example using a placeholder YouTube embed (replace VIDEO_ID) --}}
                    <iframe
                        src="https://www.youtube.com/embed/VIDEO_ID?autoplay=0&controls=1&showinfo=0&rel=0"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        title="فيديو تعريفي عن شاحنّي">
                    </iframe>
                    {{-- Or use a <video> tag for self-hosted videos --}}
                    {{-- <video controls>
                         <source src="{{ asset('videos/your-intro-video.mp4') }}" type="video/mp4">
                         متصفحك لا يدعم تشغيل الفيديو.
                     </video> --}}
                </div>
            </div>

            {{-- Our Story Section --}}
            <div class="story-section">
                <h3>قصتنا</h3>
                <div class="story-content">
                    <p>
                        بدأت فكرة "شاحنّي" من الحاجة المتزايدة لمنصة موثوقة وشاملة لمالكي السيارات الكهربائية في الأردن. مع تزايد عدد السيارات الكهربائية على الطرق، أصبح العثور على محطات الشحن المتاحة، والتخطيط للرحلات الطويلة دون قلق بشأن مدى البطارية، والحصول على قطع الغيار المناسبة، أمراً ضرورياً.
                    </p>
                    <p>
                        لاحظنا التحديات التي يواجهها أصحاب السيارات الكهربائية، من صعوبة تحديد مواقع الشواحن المختلفة التابعة لشركات متعددة، إلى نقص المعلومات التفصيلية عن أنواع الشواحن وقوتها وحالة توفرها. كما أن الحصول على قطع الغيار المتخصصة يمكن أن يكون تحدياً بحد ذاته.
                    </p>
                    <p>
                        من هنا، ولد مشروع "شاحنّي" ليقدم حلاً متكاملاً. هدفنا هو بناء مجتمع داعم لمالكي السيارات الكهربائية في الأردن، وتزويدهم بالأدوات والمعلومات التي يحتاجونها لجعل تجربة امتلاك سيارة كهربائية أكثر سهولة وراحة وثقة. نحن نسعى لتجميع كل ما يتعلق بالسيارات الكهربائية في مكان واحد: خريطة تفاعلية للمحطات، أدوات تخطيط الرحلات الذكية، سوق لقطع الغيار، ودليل للمساعدة الطارئة.
                    </p>
                     <p>
                         نحن ملتزمون بتطوير "شاحنّي" باستمرار بناءً على ملاحظات واحتياجات المستخدمين، والمساهمة في دعم البنية التحتية للمركبات الكهربائية في الأردن وتشجيع التوجه نحو النقل المستدام.
                     </p>
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

    {{-- You can keep your external script.js file for other scripts --}}
    {{-- <script src="{{ asset('js/script.js') }}"></script> --}}

</body>
</html>
