<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Booking;
use App\Models\Station;

class BookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'station_id' => 'required|exists:stations,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'port_number' => 'required|integer|min:1',
            'vehicle_model' => 'required|string|max:255',
            'vehicle_plate' => 'required|string|max:20',
            'charger_type' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'station_id.required' => 'يجب اختيار محطة الشحن',
            'station_id.exists' => 'محطة الشحن غير موجودة',
            'start_time.required' => 'يجب تحديد وقت بداية الشحن',
            'start_time.date' => 'صيغة وقت البداية غير صحيحة',
            'start_time.after' => 'يجب أن يكون وقت البداية في المستقبل',
            'end_time.required' => 'يجب تحديد وقت نهاية الشحن',
            'end_time.date' => 'صيغة وقت النهاية غير صحيحة',
            'end_time.after' => 'يجب أن يكون وقت النهاية بعد وقت البداية',
            'port_number.required' => 'يجب تحديد رقم المنفذ',
            'port_number.integer' => 'رقم المنفذ يجب أن يكون رقماً صحيحاً',
            'port_number.min' => 'رقم المنفذ غير صحيح',
            'vehicle_model.required' => 'يجب إدخال موديل السيارة',
            'vehicle_model.string' => 'موديل السيارة غير صحيح',
            'vehicle_model.max' => 'موديل السيارة طويل جداً',
            'vehicle_plate.required' => 'يجب إدخال رقم لوحة السيارة',
            'vehicle_plate.string' => 'رقم اللوحة غير صحيح',
            'vehicle_plate.max' => 'رقم اللوحة طويل جداً',
            'charger_type.required' => 'يجب تحديد نوع الشاحن',
            'charger_type.string' => 'نوع الشاحن غير صحيح',
            'charger_type.max' => 'نوع الشاحن طويل جداً',
            'notes.string' => 'الملاحظات يجب أن تكون نصاً',
            'notes.max' => 'الملاحظات طويلة جداً'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // التحقق من توفر المحطة
            $station = Station::find($this->station_id);
            if (!$station->isAvailable()) {
                $validator->errors()->add('station_id', 'المحطة غير متاحة حالياً');
                return;
            }

            // التحقق من توفر المنفذ
            if (!Booking::isPortAvailable(
                $this->station_id,
                $this->port_number,
                $this->start_time,
                $this->end_time
            )) {
                $validator->errors()->add('port_number', 'المنفذ غير متاح في الوقت المحدد');
                return;
            }

            // التحقق من نوع الشاحن
            if (!in_array($this->charger_type, $station->charging_types)) {
                $validator->errors()->add('charger_type', 'نوع الشاحن غير متوفر في هذه المحطة');
                return;
            }

            // التحقق من مدة الحجز
            $bookingValidation = Booking::validateBookingTime($this->start_time, $this->end_time);
            if (!$bookingValidation['valid']) {
                $validator->errors()->add('start_time', $bookingValidation['message']);
            }
        });
    }
} 