<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class OfferDynamicProperty extends Constraint
{
    public $messageCompatible = "La propriété dynamique {{ dynamicProperty }} ne concerne pas le type d'offre {{ offerType }}.";
    public $messageMandatory = "La propriété dynamique {{ dynamicProperty }} est obligatoire pour le type d'offre {{ offerType }}.";

    public $targetField = "dynamicPropertyValues";

    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}
