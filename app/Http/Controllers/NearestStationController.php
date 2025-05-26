<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station; // استيراد نموذج Station

class NearestStationController extends Controller
{
    /**
     * Display the nearest station page and fetch stations data.
     */
    public function index()
    {
        // جلب جميع المحطات من جدول stations باستخدام النموذج
        // في تطبيق حقيقي، قد تحتاج لجلب المحطات بناءً على موقع المستخدم
        // وهذا يتطلب منطقاً أكثر تعقيداً (يمكن تنفيذه هنا أو عبر API)
        $stations = Station::all();

        // تمرير البيانات إلى الـ view 'nearest.blade.php'
        return view('nearest', ['stations' => $stations]);
    }

    // إذا كنت ستستخدم AJAX لجلب المحطات القريبة بناءً على إحداثيات المستخدم،
    // ستحتاج لدالة أخرى هنا (مثلاً getNearbyStations) ترجع JSON
    // public function getNearbyStations(Request $request)
    // {
    //     // منطق جلب المحطات القريبة بناءً على $request->lat و $request->lng
    //     // ...
    //     // return response()->json($nearbyStations);
    // }
}

