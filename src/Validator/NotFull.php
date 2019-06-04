<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotFull extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Il reste NBENTRIES place(s) disponible(s) pour cette journée';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }


}
