<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

abstract class AbstractChoiceField implements FormElement
{
    protected ChoiceFieldType $fieldType;

    public function __construct(
        public readonly string $name,
        public readonly string $label,
        public readonly OptionCollection $options,
        public readonly bool $isRequired = false,
        public readonly ?string $help = null,
        public ?LabelTranslationCollection $labelTranslations = null,
        protected bool $multipleValues = false
    ) {
        if (count($options) < 1) {
            throw new InvalidArgumentException(
                ucfirst($this->fieldType->value) . ' field property requires at least one option.',
            );
        }
    }
    public function toJsonSchemaProperty(): SchemaProperty
    {
        return new SchemaProperty(
            name: $this->name,
            type: $this->getType(),
            description: $this->label,
            isRequired: $this->isRequired,
            options: $this->options,
            help: $this->help,
            fieldType: $this->fieldType,
            labelTranslations: $this->labelTranslations,
        );
    }
    private function getType(): SchemaPropertyType
    {
        return $this->multipleValues
            ? SchemaPropertyType::ARRAY
            : SchemaPropertyType::STRING;
    }
}
