<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use Override;

class RadioButtons extends ChoiceField
{
    public function __construct(
        string $name,
        string $label,
        OptionCollection $options,
        bool $isRequired = false,
        ?string $help = null,
        ?LabelTranslationCollection $labelTranslations = null,
        public ?string $initialValue = null,
    ) {
        parent::__construct($name, $label, $options, $isRequired, $help, $labelTranslations);
    }

    #[Override]
    protected function fieldType(): MetaFieldType
    {
        return MetaFieldType::RADIO;
    }

    public function value(): ?string
    {
        return $this->initialValue;
    }
}
