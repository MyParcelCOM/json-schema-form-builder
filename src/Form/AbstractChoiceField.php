<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Items\Items;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\Meta;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

abstract class AbstractChoiceField extends FormElement
{
    public function __construct(
        public readonly string $name,
        public readonly string $label,
        public readonly OptionCollection $options,
        public readonly bool $isRequired = false,
        public readonly ?string $help = null,
        public ?LabelTranslationCollection $labelTranslations = null,
        protected bool $multipleValues = false,
    ) {
        if (count($options) < 1) {
            throw new InvalidArgumentException(
                ucfirst($this->fieldType()->value) . ' field property requires at least one option.',
            );
        }
        parent::__construct($isRequired);
    }

    abstract protected function fieldType(): MetaFieldType;

    public function toJsonSchemaProperty(): SchemaProperty
    {
        return new SchemaProperty(
            name: $this->name,
            type: $this->schemaPropertyType(),
            description: $this->label,
            enum: $this->options->getKeys(),
            items: new Items(enum: $this->options->getKeys()),
            meta: new Meta(
                help: $this->help,
                fieldType: $this->fieldType(),
                labelTranslations: $this->labelTranslations->toArray(),
                enumLabels: $this->options->getLabels(),
                enumLabelTranslations: $this->options->getLabelTranslations(),
            )
        );
    }
}
