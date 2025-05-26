<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'status',
        'latitude',
        'longitude',
        'available_ports',
        'total_ports',
        'charging_types',
        'operating_hours',
        'amenities',
        'description'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'available_ports' => 'integer',
        'total_ports' => 'integer',
        'charging_types' => 'array',
        'operating_hours' => 'array',
        'amenities' => 'array'
    ];

    protected $appends = ['average_rating', 'total_ratings'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    // العلاقة مع التقييمات
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // الحصول على متوسط التقييم
    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    // الحصول على عدد التقييمات
    public function getTotalRatingsAttribute()
    {
        return $this->ratings()->count();
    }

    // الحصول على التقييمات مع التعليقات
    public function getReviews()
    {
        return $this->ratings()
            ->with('user')
            ->whereNotNull('comment')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // الحصول على توزيع التقييمات (عدد كل نجمة)
    public function getRatingDistribution()
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $this->ratings()->where('rating', $i)->count();
        }
        return $distribution;
    }

    // الحصول على متوسط تقييمات الجوانب المختلفة
    public function getAspectsAverages()
    {
        $aspects = ['cleanliness', 'service', 'availability', 'location'];
        $averages = [];
        
        foreach ($aspects as $aspect) {
            $averages[$aspect] = Rating::getAspectAverage($this->id, $aspect);
        }
        
        return $averages;
    }

    // التحقق من توفر المحطة في وقت معين
    public function isAvailable($datetime = null)
    {
        if (!$datetime) {
            $datetime = Carbon::now();
        }

        // التحقق من حالة المحطة
        if ($this->status !== 'active') {
            return false;
        }

        // التحقق من ساعات العمل
        if (!$this->isOpenAt($datetime)) {
            return false;
        }

        // التحقق من توفر المنافذ
        return $this->available_ports > 0;
    }

    // التحقق من ساعات العمل
    public function isOpenAt($datetime)
    {
        if (!$this->operating_hours) {
            return true; // إذا لم يتم تحديد ساعات العمل، نفترض أنها تعمل 24/7
        }

        $dayType = $this->getDayType($datetime);
        $hours = $this->operating_hours[$dayType] ?? '24/7';

        if ($hours === '24/7') {
            return true;
        }

        list($start, $end) = explode(' - ', $hours);
        $startTime = Carbon::parse($start);
        $endTime = Carbon::parse($end);
        $checkTime = Carbon::parse($datetime)->format('H:i');

        return Carbon::parse($checkTime)->between($startTime, $endTime);
    }

    // تحديد نوع اليوم (يوم عمل، عطلة نهاية الأسبوع، عطلة رسمية)
    private function getDayType($datetime)
    {
        $dayOfWeek = Carbon::parse($datetime)->dayOfWeek;

        // اعتبار الجمعة والسبت عطلة نهاية الأسبوع
        if ($dayOfWeek === 5 || $dayOfWeek === 6) {
            return 'weekend';
        }

        // يمكن إضافة منطق للتحقق من العطل الرسمية هنا
        return 'weekdays';
    }

    // البحث عن المحطات القريبة
    public function scopeNearby($query, $latitude, $longitude, $radius = 5)
    {
        $haversine = "(6371 * acos(cos(radians($latitude)) 
                     * cos(radians(latitude)) 
                     * cos(radians(longitude) - radians($longitude)) 
                     + sin(radians($latitude)) 
                     * sin(radians(latitude))))";
        
        return $query->selectRaw("*, $haversine AS distance")
                    ->having('distance', '<=', $radius)
                    ->orderBy('distance');
    }

    // البحث عن المحطات حسب نوع الشاحن
    public function scopeWithChargerType($query, $chargerType)
    {
        return $query->whereJsonContains('charging_types', $chargerType);
    }

    // البحث عن المحطات النشطة
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // البحث عن المحطات التي تحتوي على مرافق معينة
    public function scopeWithAmenities($query, $amenities)
    {
        foreach ((array) $amenities as $amenity) {
            $query->whereJsonContains('amenities', $amenity);
        }
        return $query;
    }

    // تحديث عدد المنافذ المتاحة
    public function updateAvailablePorts()
    {
        $activeBookings = $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('end_time', '>', now())
            ->count();

        $this->available_ports = max(0, $this->total_ports - $activeBookings);
        $this->save();
    }
}