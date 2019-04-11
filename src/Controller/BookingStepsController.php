<?php

namespace App\Controller;

use App\Form\BookingTicketsType;
use App\Service\PriceCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Ticket;
use App\Entity\Booking;
use App\Form\TicketType;
use App\Form\BookingType;

class BookingStepsController extends AbstractController
{

    /**
     * @Route("/initialiser-commande", name="order_step_1")
     */
    public function init(SessionInterface $session, Request $request)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // TODO voir comment faire pour ajouter n ticket


            $session->set('booking', $booking);

            return $this->redirectToRoute('order_step_2');
        }

        return $this->render('booking/step_one.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/saisir-vos-billets", name="order_step_2")
     */
    public function index(PriceCalculator $calculator, SessionInterface $session, Request $request)
    {

        $booking = $session->get('booking');
        $form = $this->createForm(BookingTicketsType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //TODO calcul du prix
            $calculator->computePrice($booking);

            return $this->redirectToRoute('order_step_3');
        }

        return $this->render('booking/step_two.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/recapitulatif", name="order_step_3")
     */

    public function summary(SessionInterface $session, Request $request)
    {
        return $this->render('booking/step_three.html.twig');
    }

}
