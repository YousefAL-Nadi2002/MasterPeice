<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'whatsapp', 'email', 'location'
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'provider_service');
    }
} 