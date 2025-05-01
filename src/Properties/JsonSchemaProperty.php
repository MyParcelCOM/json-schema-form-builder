<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Properties;

use MyParcelCom\JsonSchema\FormBuilder\Form\ChoiceFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslation;

class JsonSchemaProperty
{
    public function __construct(
        public readonly string $name,
        public readonly PropertyType $type,
        public readonly string $description,
        public readonly bool $isRequired = false,
        public readonly bool $isPassword = false,
        public readonly ?OptionCollection $options = null,
        public readonly ?string $help = null,
        public readonly ?ChoiceFieldType $fieldType = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            $this->name => array_filter([
                'type'        => $this->type->value,
                'description' => $this->description,
                'enum'        => $this->options?->getKeys(),
                'meta'        => array_filter([
                    'help'        => $this->help,
                    'password'    => $this->isPassword,
                    'field_type'  => $this->fieldType?->value,
                    'enum_labels' => isset($this->options) ? array_filter($this->options?->getLabels()) : null,
                    'enum_label_translations' => $this->options?->getLabelTranslations(),
                ]),
            ]),
        ];
    }
}
