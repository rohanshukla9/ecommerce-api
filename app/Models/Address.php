<?php

namespace App\Models;

use App\Models\Traits\IsDefault;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //

    use IsDefault;

    protected $fillable = [
        'name',
        'address_1',
        'pin_code',
        'country_id',
        'default'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($address) {
            if ($address->default) {
                $address->newQuery()->where('user_id', $address->user->id)->update([
                    'default' => false
                ]);
            }
        });
    }

    public function setDefaultAttribute($value)
    {
        $this->attributes['default'] = ($value === 'true' || $value ? true : false);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
