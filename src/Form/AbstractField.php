<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
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

    public function toJsonSchemaProperty(): SchemaProperty
    {
        return new SchemaProperty(
            name: $this->name,
            type: SchemaPropertyType::fromFieldType($this->fieldType),
            description: $this->label,
            isRequired: $this->isRequired,
            isPassword: $this->isPassword,
            help: $this->help,
            labelTranslations: $this->labelTranslations,
        );
    }
}
