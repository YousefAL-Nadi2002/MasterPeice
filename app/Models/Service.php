<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'type', 'is_active', 'image', 'price', 'sort_order'
    ];

    public function providers()
    {
        return $this->belongsToMany(ServiceProvider::class, 'provider_service');
    }
}
