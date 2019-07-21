<?php


namespace App\Tests\Entity;


use App\Entity\Booking;
use App\Entity\Ticket;

use PHPUnit\Framework\TestCase;


class TicketTest extends TestCase
{
    public function testGetAge()
    {
        $ticket = new Ticket();
        $booking = new Booking();
        $booking->setDateOfVisit(new \DateTime());
        $ticket->setBooking($booking);
        $ticket->setDateOfBirth(new \DateTime('- 20 year'));

        $this->assertSame(20, $ticket->getAge());

    }


}