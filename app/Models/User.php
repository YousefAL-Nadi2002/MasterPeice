<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    // التحقق من صلاحيات المشرف
    public function isAdmin()
    {
        return $this->is_admin;
    }

    // التحقق من حالة الحساب
    public function isActive()
    {
        return $this->is_active;
    }

    // التحقق من صلاحية إدارة المحطات
    public function canManageStations()
    {
        return $this->isAdmin();
    }

    // التحقق من صلاحية إدارة الحجوزات
    public function canManageBookings()
    {
        return $this->isAdmin() || $this->isActive();
    }

    // التحقق من صلاحية إدارة طلبات الصيانة
    public function canManageMaintenanceRequests()
    {
        return $this->isAdmin();
    }

    // التحقق من صلاحية إدارة المستخدمين
    public function canManageUsers()
    {
        return $this->isAdmin();
    }

    // التحقق من صلاحية تعديل حجز معين
    public function canModifyBooking(Booking $booking)
    {
        return $this->isAdmin() || $booking->user_id === $this->id;
    }

    // الحصول على الحجوزات النشطة للمستخدم
    public function activeBookings()
    {
        return $this->bookings()->whereIn('status', ['pending', 'confirmed']);
    }

    // الحصول على الحجوزات المكتملة للمستخدم
    public function completedBookings()
    {
        return $this->bookings()->where('status', 'completed');
    }

    // الحصول على طلبات الصيانة النشطة للمستخدم
    public function activeMaintenanceRequests()
    {
        return $this->maintenanceRequests()->whereIn('status', ['pending', 'in_progress']);
    }
}
