<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotHolidayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\NotHoliday */

        if (!$value instanceof \DateTimeInterface) {
            throw new UnexpectedTypeException($value, \DateTimeInterface::class);
        }


        $holiday = array(
            mktime(0, 0, 0, 5, 1),
            mktime(0, 0, 0, 11, 1),
            mktime(0, 0, 0, 12, 25)
        );

        if ($value = $holiday) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
