<?php


namespace App\Tests\Service;


use App\Entity\Booking;
use App\Entity\Ticket;

use App\Service\PriceCalculator;
use PHPUnit\Framework\TestCase;


class PriceCalculatorTest extends TestCase
{

    /**
     * @param $isReduce
     * @param $birthDate
     * @param $period
     * @param $expectedPrice
     * @throws \Exception
     *
     * @dataProvider computeTicketPriceProvider
     */

    public function testComputeTicketPrice($isReduce, $birthDate, $period, $expectedPrice)
    {
        $ticket = new Ticket();
        $ticket->setReducedPrice($isReduce);
        $ticket->setDateOfBirth(new \DateTime($birthDate));

        $booking = new Booking();
        $booking->setDateOfVisit(new \DateTime('2020/01/01'));
        $booking->setPeriod($period);

        $booking->addTicket($ticket);

        $priceCalculator = new PriceCalculator();

        $this->assertEquals($expectedPrice, $priceCalculator->computeTicketPrice($ticket));
    }

    public function computeTicketPriceProvider()
    {

        yield [false, '2000/01/01', Booking::TYPE_DAY, Booking::NORMAL_DAY];
        yield [true, '2000/01/01', Booking::TYPE_DAY, Booking::REDUCED_PRICE];
        yield [true, '2000/01/01', Booking::TYPE_HALF_DAY, Booking::REDUCED_PRICE*Booking::HALF_DAY_COEFF];
        yield [false, '1955/10/05', Booking::TYPE_DAY, booking::SENIOR_DAY,];
    }

    /**
     * @param $period
     * @param $isReduce
     * @param $birthDate
     * @param $expectedPrice
     * @throws \Exception
     *
     * @dataProvider computeTicketPriceProvider
     */
    public function testComputeBookingPrice($isReduce, $birthDate, $period, $expectedPrice)
    {
        $booking = new Booking();
        $booking->setDateOfVisit(new \DateTime('2020/01/01'));
        $booking->setPeriod($period);
        for ($i=0; $i<4; $i++){

            $ticket = new Ticket();
            $ticket->setReducedPrice($isReduce);
            $ticket->setDateOfBirth(new \DateTime($birthDate));

            $booking->addTicket($ticket);
        }

        $totalPrice = new PriceCalculator();
        $totalPrice->computeBookingPrice($booking);

        $this->assertEquals($expectedPrice * 4, $booking->getPrice());

    }

}