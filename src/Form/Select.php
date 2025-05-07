<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

class Select extends AbstractChoiceField
{
    protected ChoiceFieldType $fieldType = ChoiceFieldType::SELECT;

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
}
