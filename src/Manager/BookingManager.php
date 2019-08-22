<?php

namespace App\Manager;


use App\Entity\Booking;
use App\Entity\Ticket;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookingManager
{


    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var StripeManager
     */
    private $stripeManager;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(SessionInterface $session, StripeManager $stripeManager, EntityManagerInterface $entityManager, Mailer $mailer)
    {

        $this->session = $session;
        $this->stripeManager = $stripeManager;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
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

    /**
     * @param Booking $booking
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function doPayment(Booking $booking)
    {
        $reference = $this->stripeManager->pay("Commmande billets", $booking->getPrice());

        if ($reference) {
            $booking->setReference($reference);
            $booking->setCreatedAt(new \DateTime());
            $this->entityManager->persist($booking);
            $this->entityManager->flush();


            $this->mailer->sendMessage($booking);

            return true;
        }


        return false;
    }

}