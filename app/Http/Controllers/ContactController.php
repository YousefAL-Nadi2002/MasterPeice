<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail; // تأكد من أنك أنشأت هذا الـ Mailable

class ContactController extends Controller
{
    /**
     * Display the contact and advertise page.
     */
    public function index()
    {
        // عرض الـ view 'contact-advertise.blade.php'
        return view('contact-advertise');
    }

    /**
     * Handle the contact form submission and send email.
     */
    public function sendContactEmail(Request $request)
    {
        // 1. التحقق من صحة البيانات المرسلة من النموذج
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20', // رقم الهاتف اختياري
            'message' => 'required|string',
        ]);

        // 2. إرسال البريد الإلكتروني باستخدام Laravel Mailer والـ Mailable
        try {
            // استخدام Mail::to() لإرسال البريد إلى عنوان محدد
            // استبدل 'yousefalnadi02@gmail.com' ببريدك الإلكتروني الفعلي
            Mail::to('yousefalnadi02@gmail.com')->send(new ContactFormMail($validatedData));

            // 3. إعادة التوجيه إلى الصفحة السابقة مع رسالة نجاح
            return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح!');

        } catch (\Exception $e) {
            // في حالة حدوث خطأ أثناء الإرسال، إعادة التوجيه مع رسالة خطأ
            // يمكنك تسجيل الخطأ للمراجعة: \Log::error('Failed to send contact email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة لاحقاً.');
        }
    }
}
