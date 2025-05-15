<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use Override;

class Number extends Field
{
    private ?int $value = null;

    #[Override]
    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::NUMBER;
    }

    public function value(): ?int
    {
        return $this->value;
    }
}
