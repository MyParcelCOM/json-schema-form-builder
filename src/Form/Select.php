<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

class Select extends AbstractChoiceField
{
    public function __construct(
        string $name,
        string $label,
        OptionCollection $options,
        bool $isRequired = false,
        ?string $help = null,
        ?LabelTranslationCollection $labelTranslations = null,
        bool $isMultiSelect = false,
    ) {
        parent::__construct(
            name: $name,
            label: $label,
            options: $options,
            isRequired: $isRequired,
            help: $help,
            labelTranslations: $labelTranslations,
            multipleValues: $isMultiSelect,
        );
    }

    protected function fieldType(): MetaFieldType
    {
        return MetaFieldType::SELECT;
    }

    protected function schemaPropertyType(): SchemaPropertyType
    {
        if($this->multipleValues) {
            return SchemaPropertyType::ARRAY;
        }
        return SchemaPropertyType::STRING;
    }
}
