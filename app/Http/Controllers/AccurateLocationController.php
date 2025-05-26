<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station; // استيراد نموذج Station

class AccurateLocationController extends Controller
{
    /**
     * Display the accurate location page and fetch stations data.
     */
    public function index()
    {
        // جلب جميع المحطات من جدول stations لاستخدامها في الخريطة
        // منطق حساب المسار والمدى يتم في الواجهة الأمامية باستخدام Leaflet Routing Machine حالياً،
        // لكن البيانات الأساسية للمحطات تأتي من هنا.
        $stations = Station::all();

        // تمرير البيانات إلى الـ view 'accurate-location.blade.php'
        return view('accurate-location', ['stations' => $stations]);
    }
}
