<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Properties\Meta;

use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

class Meta
{
    public function __construct(
        private readonly ?string $help,
        private readonly ?bool $password,
        private readonly ?MetaFieldType $fieldType,
        private readonly ?LabelTranslationCollection $labelTranslations,
        private readonly ?OptionCollection $options,
    ) {
    }
    public function toArray(): array
    {
        return array_filter([
            'help'                    => $this->help,
            'password'                => $this->password,
            'field_type'              => $this->fieldType?->value,
            'label_translations'      => $this->labelTranslations?->toArray(),
            'enum_labels'             => isset($this->options) ? array_filter(
                $this->options?->getLabels(),
            ) : null,
            'enum_label_translations' => $this->options?->getTranslationsArray(),
        ]);
    }
}
