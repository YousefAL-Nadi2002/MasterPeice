<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'user_id',
        'type',
        'description',
        'status',
        'priority',
        'scheduled_date',
        'completed_date'
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'completed_date' => 'datetime'
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}