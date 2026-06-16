<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'category',
        'brand',
        'price',
        'stock',
        'description',
        'specifications',
        'image_path',
        'is_recommended'
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_recommended' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
