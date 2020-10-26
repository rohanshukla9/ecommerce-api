<?php

namespace App\Cart\Payments;

use App\Models\PaymentMethod;
use App\Models\User;

interface GatewayCustomer
{
  public function charge(PaymentMethod $card, $amount);

  public function addCard($token);

  public function id();
}
