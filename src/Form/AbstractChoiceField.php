<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Properties\JsonSchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\PropertyType;

abstract class AbstractChoiceField implements Field
{
    protected ChoiceFieldType $fieldType;

    public function __construct(
        public readonly string $name,
        public readonly PropertyType $type,
        public readonly string $label,
        public readonly OptionCollection $options,
        public readonly bool $isRequired = false,
        public readonly ?string $help = null,
    ) {
        if (count($options) < 1) {
            throw new InvalidArgumentException($this->fieldType->value . ' field property requires at least one enum value.');
        }
    }

    public function toJsonSchemaProperty(): JsonSchemaProperty
    {
        return new JsonSchemaProperty(
            name: $this->name,
            type: $this->type,
            description: $this->label,
            isRequired: $this->isRequired,
            options: $this->options,
            help: $this->help,
            fieldType: $this->fieldType,
        );
    }
}
