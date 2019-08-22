<?php

namespace App\Validator;

use App\Repository\BookingRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NotTuesdayValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint NotTuesday */

        if (!$value instanceof \DateTimeInterface) {
            throw new UnexpectedTypeException($value, \DateTimeInterface::class);
        }

        if ($value->format('w') === '2' ){
        $this->context->buildViolation($constraint->message)
            ->addViolation();
        }

    }
}
