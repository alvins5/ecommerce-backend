<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'brand_id',
        'image_url'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
