<?php

namespace App\Manager;

use Stripe\Error\Card;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class StripeManager
{

    public function __construct(RequestStack $requestStack, $stripePrivateKey)
    {
        $this->stripePrivateKey = $stripePrivateKey;
        $this->request = $requestStack->getCurrentRequest();
    }


    public function pay(string $description, float $amount): ?string
    {
        \Stripe\Stripe::setApiKey($this->stripePrivateKey);

        try{

            $token = $this->request->get('stripeToken');
            $charge = \Stripe\Charge::create([
                'amount' => $amount * 100,
                'currency' => 'eur',
                'description' => $description,
                'source' => $token,
            ]);

        }catch (Card $exception){
            return null;
        }

        return $charge['id'];
    }
}