<?php

namespace App\Manager;


use App\Entity\Booking;
use App\Entity\Ticket;
use App\Service\PriceCalculator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookingManager
{


    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {

        $this->session = $session;
    }


    /**
     * @return Booking
     */
    public function getCurrentBooking(): Booking
    {
        $booking = $this->session->get('booking', null);


        if (!$booking) {
            throw  new NotFoundHttpException("Pas de commande en cours merci de recommencer");
        }

        return $booking;
    }

    public function initBooking()
    {
        $booking = new Booking();
        $this->session->set('booking', $booking);
        return $booking;
    }

    public function generateEmptyTickets(Booking $booking)
    {
        for ($i = 0; $i < $booking->getNumberOfPeople(); $i++) {
            $booking->addTicket(new Ticket());
        }
    }

    public function getAndRemoveCurrentBooking()
    {

        $booking = $this->getCurrentBooking();

        $this->removeCurrentBooking();

        return $booking;
    }

    private function removeCurrentBooking()
    {
        $this->session->remove('booking');
    }


}