<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Meta;

class Meta
{
    public function __construct(
        private readonly ?string $help = null,
        private readonly ?bool $password = null,
        private readonly ?MetaFieldType $fieldType = null,
        private readonly ?array $labelTranslations = null,
        private readonly ?array $enumLabels = null,
        private readonly ?array $enumLabelTranslations = null,
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'help'                    => $this->help,
            'password'                => $this->password,
            'field_type'              => $this->fieldType?->value,
            'label_translations'      => $this->labelTranslations,
            'enum_labels'             => $this->enumLabels,
            'enum_label_translations' => $this->enumLabelTranslations,
        ]);
    }
}
