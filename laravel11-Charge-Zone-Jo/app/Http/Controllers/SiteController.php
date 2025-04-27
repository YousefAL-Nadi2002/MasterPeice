<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    // عرض الصفحة الرئيسية
    public function Home()
    {
        return view('Home');
    }

// عرض صفحة الخريطة
    public function map()
    {
        return view('welcome');
    }

    // عرض صفحة أقرب محطة
    public function nearest()
    {
        return view('nearest');
    }

    // عرض صفحة حول الموقع
    public function help()
    {
        return view('Help');
    }

    // عرض صفحة اتصل بنا
    public function contact()
    {
        return view('welcome');
    }
}
