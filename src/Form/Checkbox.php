<?php

declare(strict_types=1);

namespace MyParcelCom\Commons\Configuration\Form;

class Checkbox implements Field
{
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
            type: PropertyType::BOOLEAN,
            description: $this->label,
            isRequired: $this->isRequired,
            help: $this->help,
        );
    }
}
