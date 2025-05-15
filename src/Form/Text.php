<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use Override;

class Text extends Field
{
    public function __construct(
        string $name,
        string $label,
        bool $isRequired = false,
        ?string $help = null,
        ?LabelTranslationCollection $labelTranslations = null,
        protected readonly ?string $initialValue = null,
    ) {
        parent::__construct($name, $label, $isRequired, $help, $labelTranslations);
    }

    #[Override]
    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::STRING;
    }

    #[Override]
    public function value(): ?string
    {
        return $this->initialValue;
    }
}
