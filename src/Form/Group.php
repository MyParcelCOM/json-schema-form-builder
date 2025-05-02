<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\JsonSchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\PropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

class Group implements FormElement
{
    public function __construct(
        public readonly string $name,
        public readonly string $label,
        public readonly FormElementCollection $children,
        public readonly ?string $help = null,
        public ?LabelTranslationCollection $labelTranslations = null,
    ) {
    }
    public function toJsonSchemaProperty(): JsonSchemaProperty
    {
        return new JsonSchemaProperty(
            name: $this->name,
            type: PropertyType::OBJECT,
            description: $this->label,
            help: $this->help,
            children: $this->children,
            labelTranslations: $this->labelTranslations,
        );
    }
}
