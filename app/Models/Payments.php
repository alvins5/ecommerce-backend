<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'payment_method_id',
        'amount',
        'payment_date',
        'status',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethods::class, 'payment_method_id');
    }
}
