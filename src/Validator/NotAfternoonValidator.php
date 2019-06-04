<?php

namespace App\Validator;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NotAfternoonValidator extends ConstraintValidator
{

    public function validate($booking, Constraint $constraint)
    {
        /* @var $constraint NotAfternoon */

        if (!$booking instanceof Booking) {
            throw new UnexpectedTypeException;
        }

        $date = new \DateTime();
        $currentHour = (int) $date->format('H');

        if($booking->getPeriod() === Booking::TYPE_DAY &&
           $currentHour >= Booking::NOT_AFTERNOON_HOUR &&
            $date->format('d/m/Y') == $booking->getDateOfVisit()->format('d/m/Y')
        ) {

            $this->context->buildViolation($constraint->message)
                ->atPath('period')
                ->addViolation();
        }
    }


}
