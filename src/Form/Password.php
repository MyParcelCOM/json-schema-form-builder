<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use Override;

class Password extends Field
{
    #[Override]
    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::STRING;
    }

    #[Override]
    public function isPassword(): bool
    {
        return true;
    }
}
