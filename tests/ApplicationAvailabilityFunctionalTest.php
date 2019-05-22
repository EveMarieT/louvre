<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url, $exceptedStatusCode)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertEquals($client->getResponse()->getStatusCode(), $exceptedStatusCode);
    }

    public function urlProvider()
    {
        yield ['/', 200];
        yield ['/contact', 200];
        yield ['/faq', 200];
        yield ['/recapitulatif', 404];
        yield ['/finalisation', 404];
        yield ['/saisir-vos-billets', 404];
        yield ['/initialiser-commande', 200];
    }
}