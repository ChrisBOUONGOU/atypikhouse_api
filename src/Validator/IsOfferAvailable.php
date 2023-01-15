<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class IsOfferAvailable extends Constraint
{
    public $message = "L'offre {{ offer }} est déjà réservée.";

    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}
