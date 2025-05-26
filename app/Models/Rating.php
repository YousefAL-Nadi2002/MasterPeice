<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'station_id',
        'booking_id',
        'rating',
        'comment',
        'aspects'
    ];

    protected $casts = [
        'rating' => 'integer',
        'aspects' => 'array'
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع المحطة
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    // العلاقة مع الحجز
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // التحقق من صحة التقييم
    public static function validateRating($rating)
    {
        return $rating >= 1 && $rating <= 5;
    }

    // الحصول على متوسط تقييم جانب معين
    public static function getAspectAverage($stationId, $aspect)
    {
        return self::where('station_id', $stationId)
            ->whereNotNull('aspects')
            ->whereRaw("JSON_EXTRACT(aspects, '$.{$aspect}') IS NOT NULL")
            ->avg("JSON_EXTRACT(aspects, '$.{$aspect}')");
    }

    // الحصول على أحدث التقييمات
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // الحصول على التقييمات مع التعليقات فقط
    public function scopeWithComments($query)
    {
        return $query->whereNotNull('comment');
    }

    // الحصول على التقييمات حسب عدد النجوم
    public function scopeWithStars($query, $stars)
    {
        return $query->where('rating', $stars);
    }
} 