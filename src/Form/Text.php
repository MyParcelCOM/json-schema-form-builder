<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;

class Text extends AbstractField
{
    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::STRING;
    }
}
