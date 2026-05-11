<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'tracking_number',
        'courier',
        'shipped_date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
