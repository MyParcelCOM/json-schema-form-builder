<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;

class Number extends Field
{
    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::NUMBER;
    }
}
