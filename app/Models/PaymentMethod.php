<?php

namespace App\Models;

use App\Models\Traits\IsDefault;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    //

    use IsDefault;

    protected $fillable = [
        'card_type',
        'last_four',
        'provider_id',
        'default'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
