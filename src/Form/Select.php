<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;
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
        protected ?string $initialValue = null,
    ) {
        parent::__construct($name, $label, $options, $isRequired, $help, $labelTranslations);
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
