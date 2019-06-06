<?php

namespace App\Manager;

use Stripe\Stripe;
use Stripe\Charge;
use App\Entity\Booking;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class StripeManager
{

    public function __construct(SessionInterface $session, $stripePrivateKey)
    {
        $this->session = $session;
        $this->stripePrivateKey = $stripePrivateKey;
    }



//    public function getStripePayment($stripePrivateKey, Booking $booking)
//    {
//        \Stripe\Stripe::setApiKey($stripePrivateKey);
//
//        $token = $_POST['stripeToken'];
//        $charge = \Stripe\Charge::create([
//            'amount' => $booking->getPrice() * 100,
//            'currency' => 'eur',
//            'description' => 'Commande billets',
//            'source' => $token,
//        ]);
//
//        return $charge;
//    }
}