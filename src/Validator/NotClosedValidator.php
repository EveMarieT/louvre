<?php

namespace App\Validator;


use App\Entity\Booking;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NotClosedValidator extends ConstraintValidator
{

    public function validate($booking, Constraint $constraint)
    {
        /* @var $constraint NotClosed */

        if (!$booking instanceof Booking) {
            throw new UnexpectedTypeException($booking,Booking::class);
        }

        $date = new \DateTime();
        $currentHour = $date->format('H:m');
        $nocturne = in_array($date->format('w'),[4,5]);
        $limit = ($nocturne) ? Booking::TOO_LATE_HOUR_NIGHT : Booking::TOO_LATE_HOUR_DAY;


        if (
            $currentHour >=  $limit &&
            $date->format('d/m/Y') == $booking->getDateOfVisit()->format('d/m/Y')
        ) {

            $this->context->buildViolation($constraint->message)
                ->atPath('dateOfVisit')
                ->addViolation();
        }
    }
}
