<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\JsonSchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\PropertyType;

abstract class AbstractField implements FormElement
{
    protected PropertyType $propertyType;
    protected bool $isPassword = false;

    public function __construct(
        public readonly string $name,
        public readonly string $label,
        public readonly bool $isRequired = false,
        public readonly ?string $help = null,
    ) {
    }
    public function toJsonSchemaProperty(): JsonSchemaProperty
    {
        return new JsonSchemaProperty(
            name: $this->name,
            type: $this->propertyType,
            description: $this->label,
            isRequired: $this->isRequired,
            isPassword: $this->isPassword,
            help: $this->help,
        );
    }
}
