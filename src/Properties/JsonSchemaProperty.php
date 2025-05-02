<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Properties;

use MyParcelCom\JsonSchema\FormBuilder\Form\ChoiceFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Form\FormElement;
use MyParcelCom\JsonSchema\FormBuilder\Form\FormElementCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

class JsonSchemaProperty
{
    /**
     * @param string $name The name of the property. Corresponds to the field name the value will associate to.
     * @param PropertyType $type The type of the property. Corresponds to a JSON Schema type.
     * @param string $description A description of the property. Used to hold the label of the field
     * @param bool $isRequired Whether the property is required.
     * @param bool $isPassword Whether the property is a password field.
     * @param OptionCollection|null $options The options for the property, Only applicable for choice fields.
     * @param string|null $help Help text for the property.
     * @param ChoiceFieldType|null $fieldType The meta-field, `field_type` of the property. Used to differentiate between choice fields.
     * @param PropertyType|null $itemsType The type of items in an array, Only applicable for multi-select.
     * @param FormElementCollection|null $children The child elements of the property, Only applicable for rendering groups (type => 'object').
     * @param LabelTranslationCollection|null $labelTranslations Translations for the label (description field).
     */
    public function __construct(
        public readonly string $name,
        public readonly PropertyType $type,
        public readonly string $description,
        public readonly bool $isRequired = false,
        public readonly bool $isPassword = false,
        public readonly ?OptionCollection $options = null,
        public readonly ?string $help = null,
        public readonly ?ChoiceFieldType $fieldType = null,
        public readonly ?PropertyType $itemsType = null,
        public readonly ?FormElementCollection $children = null,
        public readonly ?LabelTranslationCollection $labelTranslations = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            $this->name => array_filter([
                'type'        => $this->type->value,
                'items' => isset($this->itemsType) ? [
                    'type' => $this->itemsType->value,
                ] : null,
                'description' => $this->description,
                'enum'        => $this->options?->getKeys(),
                'properties' => isset($this->children) ? array_map(
                    fn (FormElement $el) => $el->toJsonSchemaProperty(),
                    $this->children->getArrayCopy()
                ) : null,
                'meta'        => array_filter([
                    'help'        => $this->help,
                    'password'    => $this->isPassword,
                    'field_type'  => $this->fieldType?->value,
                    'label_translations' => $this->labelTranslations?->toArray(),
                    'enum_labels' => isset($this->options) ? array_filter($this->options?->getLabels()) : null,
                    'enum_label_translations' => $this->options?->getTranslationsArray(),
                ]),
            ]),
        ];
    }
}
