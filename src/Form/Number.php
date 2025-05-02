<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;

class Number extends AbstractField
{
    protected FieldType $fieldType = FieldType::NUMBER;
}
