<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShippingMethod;

class Country extends Model
{
    //

    public function shippingMethods()
    {
        return $this->belongsToMany(ShippingMethod::class);
    }
}
