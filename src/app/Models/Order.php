<?php

namespace App\Models;

use App\Traits\HasCode;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasCode;
    protected $fillable = [

        'order_code',

        'fullname',

        'phone',

        'email',

        'address',

        'note',

        'payment_method',

        'subtotal',

        'shipping',

        'discount',

        'total',

        'status'

    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    protected static function booted()
    {
        static::created(function ($order) {

            $order->update([
                'order_code' => self::generateCode('DH', $order->id)
            ]);

        });
    }
}