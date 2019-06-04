<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotAfternoon extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Vous ne pouvez pas prendre une entrée journée, veuillez choisir la période demi-journée.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
