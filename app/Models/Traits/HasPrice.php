<?php
namespace App\Models\Traits;
use Money\Currencies\ISOCurrencies;

use App\Cart\Money;
use Money\Currency;
use NumberFormatter;
use Money\Formatter\IntlMoneyFormatter;

trait HasPrice
{
    public function getPriceAttribute($value)
    {
        return new Money($value);
    }

    public function getformattedPriceAttribute()
    {
        return $this->price->formatted();
    }
}