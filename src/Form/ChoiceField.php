<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Items\Items;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\Meta;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

abstract class ChoiceField extends FormElement
{
    public function __construct(
        public readonly string $name,
        public readonly string $label,
        public readonly OptionCollection $options,
        public readonly bool $isRequired = false,
        public readonly ?string $help = null,
        public readonly ?LabelTranslationCollection $labelTranslations = null,
    ) {
        if (count($options) < 1) {
            throw new InvalidArgumentException(
                ucfirst($this->fieldType()->value) . ' field property requires at least one option.',
            );
        }
        parent::__construct($isRequired);
    }

    abstract protected function fieldType(): MetaFieldType;

    protected function enum(): ?array
    {
        return $this->schemaPropertyType() === SchemaPropertyType::ARRAY
            ? null
            : $this->options->getKeys();
    }

    protected function items(): ?Items
    {
        return $this->schemaPropertyType() === SchemaPropertyType::ARRAY
            ? new Items(enum: $this->options->getKeys())
            : null;
    }

    public function toJsonSchemaProperty(): SchemaProperty
    {
        return new SchemaProperty(
            name: $this->name,
            type: $this->schemaPropertyType(),
            description: $this->label,
            enum: $this->enum(),
            items: $this->items(),
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
