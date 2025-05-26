<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'station_id',
        'start_time',
        'end_time',
        'status',
        'port_number',
        'vehicle_model',
        'vehicle_plate',
        'charger_type',
        'estimated_duration',
        'notes'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'estimated_duration' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    // التحقق من توفر المنفذ في الوقت المحدد
    public static function isPortAvailable($station_id, $port_number, $start_time, $end_time, $exclude_booking_id = null)
    {
        $query = self::where('station_id', $station_id)
            ->where('port_number', $port_number)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                    ->orWhereBetween('end_time', [$start_time, $end_time])
                    ->orWhere(function ($query) use ($start_time, $end_time) {
                        $query->where('start_time', '<=', $start_time)
                            ->where('end_time', '>=', $end_time);
                    });
            });

        if ($exclude_booking_id) {
            $query->where('id', '!=', $exclude_booking_id);
        }

        return $query->count() === 0;
    }

    // التحقق من صحة وقت الحجز
    public static function validateBookingTime($start_time, $end_time)
    {
        $start = Carbon::parse($start_time);
        $end = Carbon::parse($end_time);
        
        // التحقق من أن وقت البداية قبل وقت النهاية
        if ($start->gte($end)) {
            return ['valid' => false, 'message' => 'وقت البداية يجب أن يكون قبل وقت النهاية'];
        }

        // التحقق من أن الحجز لا يبدأ في الماضي
        if ($start->isPast()) {
            return ['valid' => false, 'message' => 'لا يمكن إنشاء حجز في وقت سابق'];
        }

        // التحقق من أن مدة الحجز معقولة (مثلاً أقل من 24 ساعة)
        if ($start->diffInHours($end) > 24) {
            return ['valid' => false, 'message' => 'مدة الحجز يجب أن لا تتجاوز 24 ساعة'];
        }

        return ['valid' => true];
    }

    // الحصول على الحجوزات النشطة
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }

    // الحصول على الحجوزات المكتملة
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // الحصول على الحجوزات الملغاة
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // حساب المدة المتوقعة للشحن
    public function calculateEstimatedDuration()
    {
        if ($this->start_time && $this->end_time) {
            return $this->start_time->diffInMinutes($this->end_time);
        }
        return null;
    }
}