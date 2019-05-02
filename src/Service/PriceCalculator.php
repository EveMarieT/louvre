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
            $booking->setPrice($totalPrice);

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
        $price = 0;
        $age = $ticket->getAge();
        $free = $age < 4;
        $child = $age > 3 && $age < 12;
        $normal = $age > 11 && $age < 60;
        $senior = $age > 59;

        $period = $ticket->getBooking()->getPeriodLabel();

        if ($free) {
            $price = Booking::FREE;
        } elseif ($child && $period === Booking::TYPE_LABEL_DAY) {
            $price = Booking::CHILD_DAY;
        } elseif ($child && $period === Booking::TYPE_LABEL_HALF_DAY) {
            $price = Booking::CHILD_HALF_DAY;
        } elseif ($normal && $period === Booking::TYPE_LABEL_DAY) {
            $price = Booking::NORMAL_DAY;
        } elseif ($normal && $period === Booking::TYPE_LABEL_HALF_DAY) {
            $price = Booking::NORMAL_HALF_DAY;
        } elseif ($senior && $period === Booking::TYPE_LABEL_DAY) {
            $price = Booking::SENIOR_DAY;
        } elseif ($senior && $period === Booking::TYPE_LABEL_HALF_DAY) {
            $price = Booking::SENIOR_HALF_DAY;
        } else {
            echo "Il semble qu'une erreur se soit produite, merci de vérifier votre date de naissance";
        }

        $ticket->setPrice($price);


        return $price;
    }

}