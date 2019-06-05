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
            throw new UnexpectedTypeException;
        }

        $date = new \DateTime();
        $closedHourDay = (int)$date->format('H:m');
        $closeHourNight = (int)$date->format('H');

        if ($booking->getPeriod() === Booking::TYPE_DAY || Booking::TYPE_HALF_DAY &&
            $closedHourDay <= Booking::TOO_LATE_HOUR_DAY || $closeHourNight <= Booking::TOO_LATE_HOUR_NIGHT &&
            $date->format('d/m/Y') == $booking->getDateOfVisit()->format('d/m/Y')
        ) {

            $this->context->buildViolation($constraint->message)
                ->atPath('dateOfVisit')
                ->addViolation();
        }
    }
}
