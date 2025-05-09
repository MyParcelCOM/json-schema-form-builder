<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Properties;

use MyParcelCom\JsonSchema\FormBuilder\Form\FormElementCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

class SchemaProperty
{
    /**
     * @param string                          $name              The name of the property. Corresponds to the field name the value will associate to.
     * @param SchemaPropertyType              $type              The JSON Schema property type.
     * @param string                          $description       A description of the property. Used to hold the label of the field
     * @param bool                            $isRequired        Whether the property is required.
     * @param bool                            $isPassword        Whether the property is a password field.
     * @param OptionCollection|null           $options           The options for the property, Only applicable for choice fields.
     * @param string|null                     $help              Help text for the property.
     * @param MetaFieldType|null              $metaFieldType     Populates the meta-field, `field_type` of the property. Used to differentiate between choice fields.
     * @param FormElementCollection|null      $properties        The child elements of the property, Only applicable for rendering groups (type => 'object').
     * @param LabelTranslationCollection|null $labelTranslations Translations for the label (description field).
     */

    // TODO: get rid is isRequired, introduce required array, change children to properties. Goal: make more aligned with JSON schema
    public function __construct(
        public readonly string $name,
        public readonly SchemaPropertyType $type,
        public readonly string $description,
        public readonly bool $isRequired = false,
        public readonly bool $isPassword = false,
        public readonly ?OptionCollection $options = null,
        public readonly ?string $help = null,
        public readonly ?MetaFieldType $metaFieldType = null,
        public readonly ?FormElementCollection $properties = null,
        public readonly ?LabelTranslationCollection $labelTranslations = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            $this->name => array_filter([
                'type'        => $this->type->value,
                'items'       => $this->type === SchemaPropertyType::ARRAY ? [
                    'type' => SchemaPropertyType::STRING->value,
                    'enum' => $this->options?->getKeys(),
                ] : null,
                'description' => $this->description,
                // enum values are set on the `items` property when the type of the property is an array
                'enum'        => $this->type === SchemaPropertyType::ARRAY ? null : $this->options?->getKeys(),
                'properties'  => $this->properties?->toArray(),
                'meta'        => array_filter([
                    'help'                    => $this->help,
                    'password'                => $this->isPassword,
                    'field_type'              => $this->metaFieldType?->value,
                    'label_translations'      => $this->labelTranslations?->toArray(),
                    'enum_labels'             => isset($this->options) ? array_filter(
                        $this->options?->getLabels(),
                    ) : null,
                    'enum_label_translations' => $this->options?->getTranslationsArray(),
                ]),
            ]),
        ];
    }
}
