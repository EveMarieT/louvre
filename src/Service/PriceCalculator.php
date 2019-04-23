<?php
namespace  App\Service;


use App\Entity\Booking;
use App\Entity\Ticket;


class PriceCalculator
{
    public function computeBookingPrice(Booking $booking)
    {

        foreach ($booking->getTickets() as $ticket){
            $totalPrice +=  $this->computeTicketPrice($ticket);
    dump($totalPrice);
        }

        return $booking;
    }


    /**
     * @param Ticket $ticket
     * @return int
     */
    public function computeTicketPrice(Ticket $ticket) :int
    {

        // selon l'âge tel tarif s'applique
        $age = $ticket->getAge();
        $price = $ticket->getPrice();

        // si $age est compris entre 0 et 3 alors $age = const FREE
        // si $age est compris entre 4 et 11 alors $age = const CHILD_DAY
        // si $age est compris entre 12 et 59 alors $age = const NORMAL_DAY
        // si $age est supérieur ou égal à 60 alors $age = const SENIOR_DAY
        if ($age < 4) {
            $price = Booking::FREE;
        } elseif ($age > 3 && $age < 12) {
            $price = Booking::CHILD_DAY;
        } elseif ($age > 11 && $age < 60) {
            $price = Booking::NORMAL_DAY;
        } elseif ($age > 59) {
            $price = Booking::SENIOR_DAY;
        } else {
            echo "Il semble qu'une erreur se soit produite, merci de vérifier votre date de naissance";
        }


        return $price;
    }

}