<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Meta\Meta;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaPropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use Override;

abstract class ChoiceField extends FormElement
{
    public function __construct(
        string $name,
        public readonly string $label,
        public readonly OptionCollection $options,
        bool $isRequired = false,
        public readonly ?string $help = null,
        public readonly ?LabelTranslationCollection $labelTranslations = null,
    ) {
        if (count($options) < 1) {
            throw new InvalidArgumentException(
                ucfirst($this->fieldType()->value) . ' field requires at least one option.',
            );
        }
        // If the value is set and the field type is a string, the value must be one of the options
        if ($this->value() !== null && $this->schemaPropertyType() === SchemaPropertyType::STRING) {
            if (!in_array($this->value(), $this->options->getKeys())) {
                throw new InvalidArgumentException(
                    ucfirst(
                        $this->fieldType()->value,
                    ) . " field value must be one of its options. Invalid option: '{$this->value()}'",
                );
            }
        }

        parent::__construct($name, $isRequired);
    }

    abstract protected function fieldType(): MetaFieldType;

    #[Override]
    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::STRING;
    }

    #[Override]
    public function toJsonSchemaProperty(): SchemaProperty
    {
        return new SchemaProperty(
            name: $this->name,
            type: $this->schemaPropertyType(),
            description: $this->label,
            enum: $this->options->getKeys(),
            meta: new Meta(
                help: $this->help,
                fieldType: $this->fieldType(),
                labelTranslations: $this->labelTranslations?->toArray(),
                enumLabels: $this->options->getLabels(),
                enumLabelTranslations: $this->options->getLabelTranslations(),
            ),
        );
    }
}
