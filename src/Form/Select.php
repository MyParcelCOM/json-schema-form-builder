<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use Override;

class Select extends ChoiceField
{
    public function __construct(
        string $name,
        string $label,
        OptionCollection $options,
        bool $isRequired = false,
        ?string $help = null,
        ?LabelTranslationCollection $labelTranslations = null,
        private readonly ?string $initialValue = null,
    ) {
        // If the value is set and the field type is a string, the value must be one of the options
        if ($this->initialValue !== null && !in_array($this->initialValue, $options->getKeys())) {
            throw new InvalidArgumentException(
                "Select field value must be one of its options. Invalid option: '{$this->initialValue}'",
            );
        }
        parent::__construct(
            name: $name,
            label: $label,
            options: $options,
            isRequired: $isRequired,
            help: $help,
            labelTranslations: $labelTranslations,
        );
    }

    #[Override]
    protected function fieldType(): MetaFieldType
    {
        return MetaFieldType::SELECT;
    }

    public function value(): ?string
    {
        return $this->initialValue;
    }
}
