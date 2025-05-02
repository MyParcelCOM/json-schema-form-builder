<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\JsonSchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\PropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

abstract class AbstractField implements FormElement
{
    protected FieldType $fieldType;
    protected bool $isPassword = false;

    public function __construct(
        public readonly string $name,
        public readonly string $label,
        public readonly bool $isRequired = false,
        public readonly ?string $help = null,
        public ?LabelTranslationCollection $labelTranslations = null,
    ) {
    }

    public function toJsonSchemaProperty(): JsonSchemaProperty
    {
        return new JsonSchemaProperty(
            name: $this->name,
            type: PropertyType::from($this->fieldType->value),
            description: $this->label,
            isRequired: $this->isRequired,
            isPassword: $this->isPassword,
            help: $this->help,
            labelTranslations: $this->labelTranslations,
        );
    }
}
