<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ticket;
use App\Form\TicketType;
use App\Form\BookingType;

class BookingStepsController extends AbstractController
{

    /**
     * @Route("/initialiser-commande", name="order_step_1")
     */
    public function init(SessionInterface $session)
    {
        $ticket = new Ticket();
        $form   = $this->createForm(TicketType::class, $ticket);

        return $this->render('ticket/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/saisir-vos-billets", name="order_step_2")
     */
    public function index(SessionInterface $session)
    {

        $ticket = new Ticket();
        $form   = $this->createForm(TicketType::class, $ticket);

        return $this->render('ticket/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
