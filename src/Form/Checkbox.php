<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use Override;

class Checkbox extends Field
{
    #[Override]
    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::BOOLEAN;
    }
}
