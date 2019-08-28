<?php
namespace  App\Service;


use App\Entity\Booking;
use App\Entity\Ticket;


class PriceCalculator
{


    const AGE_CHILD = 4;
    const AGE_ADULT = 12;
    const AGE_SENIOR = 60;

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


        $age = $ticket->getAge();

        if ($age < self::AGE_CHILD) {
            $price = Booking::FREE;
        } elseif ($age < self::AGE_ADULT ) {
            $price = Booking::CHILD_DAY;
        } elseif($age < self::AGE_SENIOR){
            $price = Booking::NORMAL_DAY;
        }  else {
            $price = Booking::SENIOR_DAY;
        }

        if($ticket->getReducedPrice() &&
          $price > Booking::REDUCED_PRICE) {
            $price = Booking::REDUCED_PRICE;
        }


        if($ticket->getBooking()->getPeriodLabel() === Booking::TYPE_LABEL_HALF_DAY){
            $price = $price * Booking::HALF_DAY_COEFF;
        }
        $ticket->setPrice($price);


        return $price;
    }

}