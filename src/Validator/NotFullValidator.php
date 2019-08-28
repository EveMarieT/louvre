<?php

namespace App\Validator;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NotFullValidator extends ConstraintValidator
{

    /**
     * @var BookingRepository
     */
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint NotFull */

        if(!$value instanceof  Booking){
            throw new UnexpectedTypeException();
        }

        $bookingEntries = $this->bookingRepository->countNbOfTicketsPerDay($value->getDateOfVisit());

        $remainingEntries = Booking::MAX_PER_DAY - $bookingEntries;

        if($value->getNumberOfPeople() > $remainingEntries){
            $this->context->buildViolation($constraint->message)
                ->setParameter("NBENTRIES", $remainingEntries)
                ->atPath('numberOfPeople')
                ->addViolation();

        }


    }
}
