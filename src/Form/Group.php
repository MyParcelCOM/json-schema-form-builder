<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Meta\Meta;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaPropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use Override;

class Group extends FormElement
{
    public function __construct(
        string $name,
        public readonly string $label,
        public readonly FormElementCollection $children,
        public readonly ?string $help = null,
        public ?LabelTranslationCollection $labelTranslations = null,
    ) {
        // A group is required if any of its children are required.
        $isRequired = !empty($this->children->getRequired());
        parent::__construct($name, $isRequired);
    }

    #[Override]
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
                labelTranslations: $this->labelTranslations?->toArray(),
            ),
        );
    }

    #[Override]
    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::OBJECT;
    }

    #[Override]
    public function value(): ?array
    {
        $values = $this->children->getValues();

        return empty($values) ? null : $values;
    }
}
