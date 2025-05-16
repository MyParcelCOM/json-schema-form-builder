<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaPropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use Override;

class Password extends Field
{
    public function __construct(
        string $name,
        string $label,
        bool $isRequired = false,
        ?string $help = null,
        ?LabelTranslationCollection $labelTranslations = null,
        private readonly ?string $initialValue = null,
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
        return SchemaPropertyType::STRING;
    }

    #[Override]
    public function isPassword(): bool
    {
        return true;
    }

    #[Override]
    public function value(): ?string
    {
        return $this->initialValue;
    }
}
