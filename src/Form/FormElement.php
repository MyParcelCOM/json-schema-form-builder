<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaPropertyType;

abstract class FormElement
{
    public function __construct(
        public readonly string $name,
        public readonly bool $isRequired,
    ) {
    }

    abstract protected function schemaPropertyType(): SchemaPropertyType;

    abstract public function toJsonSchemaProperty(): SchemaProperty;

    abstract public function value(): mixed;
}
