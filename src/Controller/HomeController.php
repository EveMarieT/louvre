<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/Contact", name="contact")
     */
    public function showContact()
    {
        return $this->render('pages/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/Faq", name="faq")
     */
    public function showFaq()
    {
        return $this->render('pages/faq.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/CGV", name="cgv")
     */
    public function showCgv()
    {
        return $this->render('pages/cgv.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
