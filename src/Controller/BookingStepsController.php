<?php

namespace App\Controller;

use App\Form\BookingTicketsType;
use App\Entity\Ticket;
use App\Entity\Booking;
use App\Form\BookingType;
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
    public function init(SessionInterface $session, Request $request)
    {
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            for ($i = 0; $i < $booking->getNumberOfPeople(); $i++) {
                $booking->addTicket(new Ticket());
            }
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


            $calculator->computeBookingPrice($booking);

            return $this->redirectToRoute('order_step_3');
        }

        return $this->render('booking/step_two.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/recapitulatif", name="order_step_3")
     * @Method("POST")
     */

    public function summary(SessionInterface $session, Request $request, $stripePrivateKey, Mailer $mailer)
    {
        /** @var Booking $booking */
        $booking = $session->get('booking');

        if ($request->isMethod('POST')) {
            $token = $request->request->get('stripeToken');

            \Stripe\Stripe::setApiKey($stripePrivateKey);


            $token = $_POST['stripeToken'];
            $charge = \Stripe\Charge::create([
                'amount' => $booking->getPrice() * 100,
                'currency' => 'eur',
                'description' => 'Commande billets',
                'source' => $token,
            ]);

            $booking->setReference($charge['id']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();


            $mailer->sendMessage($booking);


            return $this->redirectToRoute('finish');

        }

        return $this->render('booking/step_three.html.twig', [
            'booking' => $booking
        ]);


    }

    /**
     * @Route("/finalisation", name="finish")
     * @Method("GET")
     */

    public function finish(SessionInterface $session, Request $request)
    {
        $booking = $session->get('booking');


        return $this->render('booking/finish.html.twig', array(
            'booking' => $booking,

        ));

    }

    /**
     * @Route("/registration", name="registration")
     */
    public function emailShow(SessionInterface $session, Request $request)
    {

        $booking = $session->get('booking');

        return $this->render('emails/registration.html.twig', [
            'booking' => $booking,
        ]);
    }
}
