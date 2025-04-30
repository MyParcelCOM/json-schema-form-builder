<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

/**
 * Used to render the `field_type` meta-field in the JsonSchemaProperty::toArray() method.
 * This property is necessary to differentiate between choice fields, as they are otherwise identical in their behavior within the JSON schema.
 */
enum ChoiceFieldType: string
{
    case SELECT = 'select';
    case RADIO = 'radio';
}
