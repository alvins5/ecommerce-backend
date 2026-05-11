<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'brand_name',
        'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
