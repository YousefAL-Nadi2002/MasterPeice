<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Rating;
use App\Models\Station;
use App\Models\Booking;

class RatingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'station_id' => 'required|exists:stations,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'aspects' => 'nullable|array',
            'aspects.cleanliness' => 'nullable|integer|min:1|max:5',
            'aspects.service' => 'nullable|integer|min:1|max:5',
            'aspects.availability' => 'nullable|integer|min:1|max:5',
            'aspects.location' => 'nullable|integer|min:1|max:5'
        ];
    }

    public function messages()
    {
        return [
            'station_id.required' => 'يجب اختيار المحطة',
            'station_id.exists' => 'المحطة غير موجودة',
            'booking_id.exists' => 'الحجز غير موجود',
            'rating.required' => 'يجب إدخال التقييم',
            'rating.integer' => 'التقييم يجب أن يكون رقماً صحيحاً',
            'rating.min' => 'التقييم يجب أن يكون بين 1 و 5',
            'rating.max' => 'التقييم يجب أن يكون بين 1 و 5',
            'comment.string' => 'التعليق يجب أن يكون نصاً',
            'comment.max' => 'التعليق طويل جداً',
            'aspects.array' => 'تقييم الجوانب غير صحيح',
            'aspects.*.integer' => 'تقييم الجانب يجب أن يكون رقماً صحيحاً',
            'aspects.*.min' => 'تقييم الجانب يجب أن يكون بين 1 و 5',
            'aspects.*.max' => 'تقييم الجانب يجب أن يكون بين 1 و 5'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // التحقق من أن المستخدم لديه حجز مكتمل في المحطة
            if ($this->booking_id) {
                $booking = Booking::find($this->booking_id);
                if ($booking->user_id !== auth()->id()) {
                    $validator->errors()->add('booking_id', 'لا يمكنك تقييم حجز لا يخصك');
                    return;
                }
                if ($booking->status !== 'completed') {
                    $validator->errors()->add('booking_id', 'يمكنك تقييم الحجوزات المكتملة فقط');
                    return;
                }
            }

            // التحقق من عدم وجود تقييم سابق لنفس الحجز
            $existingRating = Rating::where([
                'user_id' => auth()->id(),
                'station_id' => $this->station_id,
                'booking_id' => $this->booking_id
            ])->exists();

            if ($existingRating) {
                $validator->errors()->add('station_id', 'لقد قمت بتقييم هذا الحجز مسبقاً');
            }
        });
    }
} 