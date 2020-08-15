<?php

namespace App\Models;

use App\Cart\Money;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const PAYMENT_FAILED = 'payment_failed';
    const COMPLETED = 'completed';

    protected $fillable = [
        'status',
        'address_id',
        'subtotal',
        'unique_id',
    ];

    public static function boot()
    {
        # code...
        parent::boot();

        static::creating(function ($order) {
            $order->status = self::PENDING;
            $order->unique_id = 'bh-order-' . Str::random(6);
        });
    }

    public function getSubtotalAttribute($subtotal)
    {
        return new Money($subtotal);
    }

    public function total()
    {
        return $this->subtotal;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function products()
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_order')->withPivot(['quantity'])->withTimestamps();
    }
}
