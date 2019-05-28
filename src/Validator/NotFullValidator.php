<?php

namespace App\Validator;

use App\Entity\Booking;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NotFullValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\NotFull */

        if(!$value instanceof  Booking){
            throw new UnexpectedTypeException();
        }

//        $value->

        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
