<?php


namespace Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingStepsControllerTest extends WebTestCase
{

    public function testFormIsOk()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/initialiser-commande');

        $form = $crawler->selectButton('Valider')->form();

        $form['booking[dateOfVisit]'] = '2020-08-14';
        $form['booking[period]'] = 1;
        $form['booking[numberOfPeople]'] = 2;
        $form['booking[email]'] = 'test@test.fr';
        $client->submit($form);

       $this->assertTrue($client->getResponse()->isRedirect('/saisir-vos-billets'));
    }
}