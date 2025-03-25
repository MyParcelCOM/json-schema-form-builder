<?php

declare(strict_types=1);

namespace MyParcelCom\Integration\Configuration\Form;

use MyParcelCom\Integration\Configuration\Properties\JsonSchemaProperty;
use MyParcelCom\Integration\Configuration\Properties\PropertyType;

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
