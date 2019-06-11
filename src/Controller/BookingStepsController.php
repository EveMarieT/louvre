<?php

namespace App\Controller;

use App\Form\BookingTicketsType;
use App\Entity\Ticket;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Manager\BookingManager;
use App\Manager\StripeManager;
use App\Service\PriceCalculator;
use App\Service\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class BookingStepsController extends AbstractController
{

    /**
     * @Route("/initialiser-commande", name="order_step_1")
     */
    public function init(Request $request, BookingManager $bookingManager)
    {
        $booking = $bookingManager->initBooking();

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $bookingManager->generateEmptyTickets($booking);

            return $this->redirectToRoute('order_step_2');
        }

        return $this->render('booking/step_one.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/saisir-vos-billets", name="order_step_2")
     */
    public function fillTickets(PriceCalculator $calculator, BookingManager $bookingManager, Request $request)
    {

        $booking = $bookingManager->getCurrentBooking();

        $form = $this->createForm(BookingTicketsType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $calculator->computeBookingPrice($booking);

            return $this->redirectToRoute('order_step_3');
        }

        return $this->render('booking/step_two.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/recapitulatif", name="order_step_3")
     * @param BookingManager $bookingManager
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */

    public function summary(BookingManager $bookingManager, Request $request)
    {

        $booking = $bookingManager->getCurrentBooking();

        if ($request->isMethod('POST')) {

            if ($bookingManager->doPayment($booking)) {
                return $this->redirectToRoute('finish');
            }


        }

        return $this->render('booking/step_three.html.twig', [
            'booking' => $booking
        ]);


    }

    /**
     * @Route("/finalisation", name="finish", methods={"GET"})
     */

    public function finish(BookingManager $bookingManager, Request $request)
    {
        $booking = $bookingManager->getAndRemoveCurrentBooking();


        return $this->render('booking/finish.html.twig', array(
            'booking' => $booking,

        ));

    }

}
