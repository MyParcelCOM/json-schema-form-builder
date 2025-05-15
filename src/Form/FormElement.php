<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Values\Value;

abstract class FormElement
{
    public function __construct(
        private readonly bool $required,
    ) {
    }

    abstract protected function schemaPropertyType(): SchemaPropertyType;

    abstract public function toJsonSchemaProperty(): SchemaProperty;

    abstract public function value(): mixed;

    public function isRequired(): bool
    {
        return $this->required;
    }
}
