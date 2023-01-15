<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class ValidDynamicPropertyValue extends Constraint
{
    public $messageType = 'Le type de la propriété dynamique "{{ dynamicProperty }}" doit être {{ type }}.';
    public $messageMandatory = 'La valeur de la propriété dynamique "{{ dynamicProperty }}" est obligatoire.';

    public $targetField = 'value';

    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}
