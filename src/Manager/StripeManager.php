<?php

namespace App\Manager;

use Stripe\Stripe;

class StripeManager
{
    public function getKey()
    {
        $key =  \Stripe\Stripe::setApiKey($stripePrivateKey);

        return $key;
    }
}