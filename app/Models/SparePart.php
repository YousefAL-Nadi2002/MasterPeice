<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'image', 'stock', 'status',
        'part_type', 'condition', 'compatible_with', 'extra_description',
        'seller_name', 'location', 'phone', 'whatsapp', 'email', 'images'
    ];
}
