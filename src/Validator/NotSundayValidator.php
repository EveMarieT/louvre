<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NotSundayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint NotSunday */

        if (!$value instanceof \DateTimeInterface) {
            throw new UnexpectedTypeException($value, \DateTimeInterface::class);
        }

        if ($value->format('w') === '0' ) {

            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
