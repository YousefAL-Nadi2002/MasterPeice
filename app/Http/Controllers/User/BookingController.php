<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
//        dd($request->all()); // Debug 1: Check incoming request data

        // التحقق من أن المستخدم مسجل الدخول
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يرجى تسجيل الدخول لإتمام عملية الحجز.');
        }

        // الحصول على المستخدم الحالي
        $user = Auth::user();

        // التحقق من صحة البيانات المرسلة من النموذج
        $validator = Validator::make($request->all(), [
            'station_id' => 'required|exists:stations,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'estimated_duration' => 'required|integer|min:1|max:4', // مدة الشحن بالساعات (1-4)
            // يمكنك إضافة حقول أخرى إذا كان النموذج يحتوي عليها (مثل نوع الشاحن المختار، ملاحظات، ...)
        ]);

        if ($validator->fails()) {
            // dd($validator->errors()); // Debug 2: Check validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // دمج التاريخ والوقت في كائن Carbon
        $startTime = Carbon::parse($request->date . ' ' . $request->time);
        $endTime = $startTime->copy()->addHours($request->estimated_duration);

        // dd(['startTime' => $startTime, 'endTime' => $endTime, 'duration' => $request->estimated_duration]); // Debug 3: Check calculated times and duration

        // التحقق من أن وقت النهاية بعد وقت البداية (وهو مضمون إذا كانت المدة > 0)

        // التحقق من توفر المحطة في الوقت المحدد (يمكن إعادة استخدام منطق التحقق من API Controller)
        $conflictingBookings = Booking::where('station_id', $request->station_id)
            ->whereIn('status', ['pending', 'confirmed']) // التحقق من الحجوزات المعلقة والمؤكدة
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->count();

        // dd('Conflict check result: ' . $conflictingBookings); // Debug 4: Check conflict count

        if ($conflictingBookings > 0) {
            return redirect()->back()->withInput()->with('error', 'وقت الحجز المحدد غير متاح. يرجى اختيار وقت آخر.');
        }

        // إنشاء الحجز
        try {
            $booking = Booking::create([
                'user_id' => $user->id,
                'station_id' => $request->station_id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'estimated_duration' => $request->estimated_duration,
                'status' => 'pending', // يمكن تعيين الحالة مبدئياً كـ pending للمراجعة
                // يمكنك إضافة بيانات أخرى من النموذج هنا (مثل port_number, charger_type, ...)
                 // مثال إذا كانت الحقول موجودة في النموذج:
                // 'vehicle_model' => $request->vehicle_model,
                // 'vehicle_plate' => $request->vehicle_plate,
                // 'notes' => $request->notes,
            ]);

            // إعادة توجيه المستخدم مع رسالة نجاح
            return redirect()->route('my-bookings')->with('success', 'تم إرسال طلب الحجز بنجاح. سيتم مراجعته قريباً.');
            // أو يمكنك التوجيه إلى صفحة تفاصيل الحجز أو صفحة أخرى مناسبة
            // return redirect()->route('bookings.show', $booking)->with('success', 'تم إنشاء الحجز بنجاح!');
        } catch (\Exception $e) {
            // dd($e->getMessage()); // Debug 5: Catch and show any exceptions during create
        }
    }
}
