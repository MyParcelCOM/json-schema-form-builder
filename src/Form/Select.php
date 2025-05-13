<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;

class Select extends ChoiceField
{
    protected function fieldType(): MetaFieldType
    {
        return MetaFieldType::SELECT;
    }

    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::STRING;
    }
}
