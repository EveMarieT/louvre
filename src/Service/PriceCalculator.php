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

        return $booking;
    }


    public function computeTicketPrice(Ticket $ticket): integer
    {
        // il faut que je récupère la date de visite
        // il faut que je récupère la date de naissance
        // la soustraction des deux me donne l'âge du visiteur
        // selon l'âge tel tarif s'applique






        return 0;
    }


}