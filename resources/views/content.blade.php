<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تواصل معنا وأعلن هنا - شاحنّي</title>
    {{-- Link to your main CSS file --}}
    {{-- Assuming your main CSS is style.css or style.contact.css in the public folder --}}
    {{-- Use asset() to correctly link files from the public directory --}}
    <link rel="stylesheet" href="{{ asset('style.contact.css') }}">
    {{-- أو إذا كان ملف CSS الرئيسي هو style.css: --}}
    {{-- <link rel="stylesheet" href="{{ asset('style.css') }}"> --}}


    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- You can put the specific CSS for this page here if you prefer not to use a separate file --}}
    {{-- إذا كان style.contact.css غير موجود أو لا يحتوي على التنسيقات، يمكنك وضعها هنا --}}
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

        /* Specific styles for Contact & Advertise page */
        .contact-advertise-main {
            padding: 40px 0;
            background-color: #f4f4f4;
        }

        .contact-advertise-main .container {
             padding: 20px;
             display: flex;
             flex-direction: column;
             gap: 40px; /* Space between sections */
        }

        .contact-advertise-main h2 {
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .section-panel {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .section-panel h3 {
            margin-top: 0;
            color: #007bff;
            font-size: 1.6em;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        /* Contact Form Styles */
        .contact-form .form-group {
            margin-bottom: 20px;
        }

        .contact-form .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .contact-form .form-group input[type="text"],
        .contact-form .form-group input[type="email"],
        .contact-form .form-group input[type="tel"],
        .contact-form .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box; /* Include padding in width */
        }

         .contact-form .form-group textarea {
             min-height: 150px; /* Minimum height for textarea */
             resize: vertical; /* Allow vertical resizing */
         }

        .contact-form button[type="submit"] {
            display: inline-block;
            background-color: #28a745; /* Green color */
            color: #fff;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .contact-form button[type="submit"]:hover {
            background-color: #218838; /* Darker green */
        }

         .contact-form button[type="submit"] i {
             margin-left: 8px;
         }


        /* Advertise Section Styles */
        .advertise-content p {
            margin-bottom: 15px;
            line-height: 1.7;
            color: #555;
        }

        .advertise-content ul {
            margin-bottom: 15px;
            padding-right: 20px; /* Indent list items */
            color: #555;
        }

        .advertise-content ul li {
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .advertise-content .contact-info {
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

         .advertise-content .contact-info p {
             margin-bottom: 10px;
             font-weight: bold;
             color: #333;
         }

         .advertise-content .contact-info a {
             color: #007bff;
             text-decoration: none;
             transition: color 0.3s ease;
         }

         .advertise-content .contact-info a:hover {
             color: #0056b3;
             text-decoration: underline;
         }

         .advertise-content .contact-info i {
             margin-left: 8px;
             color: #007bff;
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

             .contact-advertise-main .container {
                 gap: 30px; /* Adjust gap between sections */
             }

             .contact-advertise-main h2 {
                 font-size: 2em; /* Adjust heading size */
             }

             .section-panel {
                 padding: 20px; /* Adjust section panel padding */
             }

             .section-panel h3 {
                 font-size: 1.4em; /* Adjust sub-heading size */
                 margin-bottom: 15px;
                 padding-bottom: 8px;
             }

             .contact-form .form-group input[type="text"],
             .contact-form .form-group input[type="email"],
             .contact-form .form-group input[type="tel"],
             .contact-form .form-group textarea {
                 padding: 10px; /* Adjust input padding */
                 font-size: 0.95em;
             }

             .contact-form button[type="submit"] {
                 padding: 10px 20px;
                 font-size: 1em;
             }

             .advertise-content p,
             .advertise-content ul li {
                 font-size: 0.95em;
             }

             .advertise-content ul {
                 padding-right: 15px;
             }

             .advertise-content .contact-info p {
                 font-size: 1em;
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
                 {{-- Link to this page --}}
                <li><a href="{{ url('/contact-advertise') }}">تواصل معنا / أعلن هنا</a></li>
                <li><a href="#">حول</a></li>
            </ul>
        </div>
    </nav>

    <main class="contact-advertise-main">
        <div class="container">
            <h2>تواصل معنا وأعلن معنا</h2>

            {{-- Contact Us Section --}}
            <div class="section-panel contact-form">
                <h3>تواصل معنا</h3>
                {{--
                    IMPORTANT: The 'action' and 'method' attributes of the form
                    need to point to a Laravel route that handles form submission.
                    The route will receive the form data and send the email.
                    Client-side JavaScript alone cannot send emails directly.
                --}}
                <form action="{{ url('/submit-contact-form') }}" method="POST">
                    @csrf {{-- Laravel CSRF token for security --}}

                    <div class="form-group">
                        <label for="subject">الموضوع:</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">رقم الهاتف (اختياري):</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="message">الرسالة:</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit">إرسال الرسالة <i class="fas fa-paper-plane"></i></button>
                </form>
                 {{-- Optional: Add a div here to display success or error messages after submission --}}
                 {{-- <div id="form-message"></div> --}}
            </div>

            {{-- Advertise Here Section --}}
            <div class="section-panel advertise-content">
                <h3>أعلن هنا</h3>
                <p>هل أنت صاحب عمل في مجال السيارات الكهربائية أو قطع الغيار أو محطات الشحن؟ هل لديك منتجات أو خدمات تهم مالكي السيارات الكهربائية في الأردن؟</p>
                <p>يمكنك الإعلان على منصة "شاحنّي" للوصول إلى جمهورك المستهدف!</p>
                <p>نقدم فرصاً إعلانية متنوعة، بما في ذلك:</p>
                <ul>
                    <li>عرض محطات الشحن الخاصة بك بشكل مميز.</li>
                    <li>إدراج قطع الغيار المتوفرة لديك في قسم قطع الغيار.</li>
                    <li>الإعلان عن خدمات الصيانة أو التركيب.</li>
                    <li>وضع بانرات إعلانية في أماكن بارزة على الموقع.</li>
                    <li>الترويج لعروض خاصة أو فعاليات.</li>
                </ul>
                <p>للاستفسار عن خيارات الإعلان والأسعار، يرجى التواصل معنا عبر النموذج أعلاه أو من خلال المعلومات التالية:</p>

                <div class="contact-info">
                    <p><i class="fas fa-envelope"></i> البريد الإلكتروني: <a href="mailto:yousefalnadi02@gmail.com">yousefalnadi02@gmail.com</a></p>
                    {{-- Add phone number or other contact info if desired --}}
                    {{-- <p><i class="fas fa-phone"></i> الهاتف: 07xxxxxxxx</p> --}}
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
            // Client-side validation example (optional, backend validation is crucial)
            const contactForm = document.querySelector('.contact-form form');
            const formMessageDiv = document.getElementById('form-message'); // Assuming you add this div

            if (contactForm) {
                 contactForm.addEventListener('submit', function(event) {
                     // Prevent default form submission
                     // event.preventDefault();

                     // Basic client-side validation
                     const email = document.getElementById('email').value;
                     const subject = document.getElementById('subject').value;
                     const message = document.getElementById('message').value;

                     if (!email || !subject || !message) {
                         alert('الرجاء تعبئة جميع الحقول المطلوبة (البريد الإلكتروني، الموضوع، الرسالة).');
                         // If you prevent default, you'd handle displaying the message here
                         // if (formMessageDiv) {
                         //     formMessageDiv.textContent = 'الرجاء تعبئة جميع الحقول المطلوبة.';
                         //     formMessageDiv.style.color = 'red';
                         // }
                         // return; // Stop submission if not preventing default
                     }

                     // In a real application, you would use JavaScript to send the form data
                     // asynchronously (using Fetch API or XMLHttpRequest) to your Laravel backend route.
                     // The Laravel backend would then process the data and send the email.
                     // Example (conceptual):
                     /*
                     const formData = new FormData(contactForm);
                     fetch(contactForm.action, {
                         method: contactForm.method,
                         body: formData,
                         headers: {
                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Include CSRF token
                         }
                     })
                     .then(response => response.json()) // Assuming your backend returns JSON
                     .then(data => {
                         if (formMessageDiv) {
                             if (data.success) {
                                 formMessageDiv.textContent = 'تم إرسال رسالتك بنجاح!';
                                 formMessageDiv.style.color = 'green';
                                 contactForm.reset(); // Clear the form
                             } else {
                                 formMessageDiv.textContent = 'حدث خطأ أثناء إرسال الرسالة: ' + (data.message || 'خطأ غير معروف');
                                 formMessageDiv.style.color = 'red';
                             }
                         }
                     })
                     .catch(error => {
                         console.error('Error submitting form:', error);
                         if (formMessageDiv) {
                             formMessageDiv.textContent = 'حدث خطأ في الاتصال بالخادم.';
                             formMessageDiv.style.color = 'red';
                         }
                     });
                     */

                     // If you are NOT preventing default, the form will submit normally
                     // and Laravel will handle the request based on the 'action' and 'method'.
                     // You would then redirect back to this page with a success/error message
                     // stored in the session (using Laravel's session flash data).
                 });
            } else {
                 console.error('Contact form element not found!');
            }

        });
    </script>

    {{-- You can keep your external script.js file for other scripts --}}
    {{-- <script src="{{ asset('js/script.js') }}"></script> --}}

</body>
</html>
