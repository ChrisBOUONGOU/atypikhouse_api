<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class DateRange extends Constraint
{
    /*
     * Error message of the custom validation @DateRange
     */
    public $message = 'The startDate "{{ startDate }}" should be before the endDate "{{ endDate }}".';
    public $startDateField = "startDate";
    public $endDateField = "endDate";

    /**
     * This Annotation will be used on Entity level
     */
    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}
