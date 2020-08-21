<?php

namespace App\Cart;

use Money\Money as INRMoney;
use Money\Currency;
use Money\Currencies\ISOCurrencies;
use NumberFormatter;
use Money\Formatter\IntlMoneyFormatter;

class Money
{
    protected $money;


    public function __construct($value)
    {
        $this->money = new INRMoney($value, new Currency('INR'));
    }

    public function amount()
    {
        return $this->money->getAmount();
    }

    public function formatted()
    {
        $numberFormatter = new NumberFormatter('en_INR', NumberFormatter::CURRENCY);

        $formatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return $formatter->format($this->money);
    }

    public function add(Money $money)
    {
        $this->money = $this->money->add($money->instance());

        return $this;
    }

    public function instance()
    {
        return $this->money;
    }
}
