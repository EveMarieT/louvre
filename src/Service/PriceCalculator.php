<?php
namespace  App\Service;


use App\Entity\Booking;
use App\Entity\Ticket;


class PriceCalculator
{
    public function computeBookingPrice(Booking $booking)
    {
        $totalPrice = 0;
        foreach ($booking->getTickets() as $ticket){
            $totalPrice +=  $this->computeTicketPrice($ticket);

        }
        $booking->setPrice($totalPrice);

        return $booking;
    }


    /**
     * @param Ticket $ticket
     * @return int
     */
    public function computeTicketPrice(Ticket $ticket) :int
    {

        // selon l'âge tel tarif s'applique
        $price = 0;
        $age = $ticket->getAge();
        $free = $age < 4;
        $child = $age >= 4 && $age < 12;
        $normal = $age >=12 && $age < 60;
        $senior = $age >= 60;

        $period = $ticket->getBooking()->getPeriodLabel();

        if ($free) {
            $price = Booking::FREE;
        } elseif ($child ) {
            $price = Booking::CHILD_DAY;
        } elseif($normal){
            $price = Booking::NORMAL_DAY;
        }  elseif ($senior) {
            $price = Booking::SENIOR_DAY;
        }


        //if()  TODO gestion du tarif reduit

        if($period === Booking::TYPE_LABEL_HALF_DAY){
            $price = $price * Booking::HALF_DAY_COEFF;
        }

        $ticket->setPrice($price);


        return $price;
    }

}