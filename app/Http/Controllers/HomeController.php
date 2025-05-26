<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // يمكنك جلب بعض البيانات هنا إذا كانت الصفحة الرئيسية تحتاجها
        // مثلاً: أحدث قطع الغيار، عدد المحطات، إلخ.
        // $latestParts = \App\Models\SparePart::latest()->limit(5)->get();

        // عرض الـ view للصفحة الرئيسية (عادةً welcome.blade.php)
        return view('welcome'); // تأكد من أن اسم ملف الـ view صحيح
    }
}
