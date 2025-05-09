<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\Meta;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

class Group extends FormElement
{
    public function __construct(
        public readonly string $name,
        public readonly string $label,
        public readonly FormElementCollection $children,
        public readonly ?string $help = null,
        public ?LabelTranslationCollection $labelTranslations = null,
    ) {
        parent::__construct(false);
    }

    public function toJsonSchemaProperty(): SchemaProperty
    {
        return new SchemaProperty(
            name: $this->name,
            type: SchemaPropertyType::OBJECT,
            description: $this->label,
            required: $this->children->getRequired(),
            properties: $this->children->getProperties(),
            meta: new Meta(
                help: $this->help,
                labelTranslations: $this->labelTranslations,
            )
        );
    }

    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::OBJECT;
    }
}
