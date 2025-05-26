<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the about us page.
     */
    public function index()
    {
        // إذا كان محتوى "حول شاحنّي" ديناميكياً، يمكنك جلبه من قاعدة البيانات هنا
        // $aboutContent = \App\Models\Setting::where('key', 'about_us_text')->first();

        // عرض الـ view 'about-us.blade.php'
        return view('about-us'); // يمكنك تمرير البيانات هنا إذا جلبتها: , ['aboutContent' => $aboutContent]
    }
}
