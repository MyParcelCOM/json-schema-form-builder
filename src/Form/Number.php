<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaPropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use Override;

class Number extends Field
{
    public function __construct(
        string $name,
        string $label,
        bool $isRequired = false,
        ?string $help = null,
        ?LabelTranslationCollection $labelTranslations = null,
        private readonly ?float $value = null,
    ) {
        parent::__construct(
            name: $name,
            label: $label,
            isRequired: $isRequired,
            help: $help,
            labelTranslations: $labelTranslations,
        );
    }

    #[Override]
    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::NUMBER;
    }

    #[Override]
    public function value(): ?float
    {
        return $this->value;
    }
}
