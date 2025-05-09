<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Properties\Meta;

/**
 * Used to render the `field_type` meta-field in the SchemaProperty::toArray() method.
 * This property is necessary to differentiate between choice fields, as they are otherwise identical in their behavior within the JSON schema.
 */
enum MetaFieldType: string
{
    case SELECT = 'select';
    case RADIO = 'radio';
}
