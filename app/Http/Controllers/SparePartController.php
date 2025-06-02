<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SparePart; // استيراد نموذج SparePart
use Illuminate\Http\Response;

class SparePartController extends Controller
{
    /**
     * Display the spare parts list page and fetch data.
     */
    public function index(Request $request)
    {
        // جلب جميع قطع الغيار من جدول spare_parts
        // إذا كنت ستضيف فلترة من جانب الباك إند، ستحتاج لاستخدام بيانات الطلب ($request) هنا
        // مثال بسيط للفلترة بناءً على make و model إذا تم إرسالها كبارامترات GET:
        $query = SparePart::query();

        if ($request->has('make') && $request->input('make') != '') {
            $query->where('make', $request->input('make'));
        }

        if ($request->has('model') && $request->input('model') != '') {
            $query->where('model', $request->input('model'));
        }

        $spareParts = $query->get(); // تنفيذ الاستعلام وجلب البيانات
        $sparePartsForJs = $spareParts->map(function($part) {
            return [
                'id' => $part->id,
                'name' => $part->name,
                'description' => $part->description,
                'make' => $part->make,
                'model' => $part->model,
                'image' => $part->image ? asset('storage/' . $part->image) : 'https://placehold.co/300x150/E9ECEF/343A40?text=لا+توجد+صورة',
                'is_real' => true
            ];
        });

        // تمرير البيانات إلى الـ view 'spare-parts.blade.php'
        $response = new Response(view('autoparts', [
            'spareParts' => $spareParts,
            'sparePartsForJs' => $sparePartsForJs
        ])->render());
        $response->header('Content-Type', 'text/html; charset=UTF-8');
        return $response;
    }

    public function show($id)
    {
        $part = \App\Models\SparePart::findOrFail($id);
        return view('autoparts-show', compact('part'));
    }

    // إذا كنت ستستخدم AJAX لعرض التفاصيل، ستحتاج لدالة show أو getDetails
    // public function show($id)
    // {
    //     $part = SparePart::find($id);
    //     if (!$part) {
    //         // التعامل مع عدم وجود القطعة (مثلاً إرجاع خطأ 404 أو JSON خطأ)
    //         abort(404);
    //     }
    //     // إرجاع الـ view لتفاصيل القطعة (إذا كانت صفحة منفصلة)
    //     // return view('spare-parts.show', ['part' => $part]);
    //     // أو إرجاع JSON إذا كانت AJAX
    //     // return response()->json($part);
    // }
}
