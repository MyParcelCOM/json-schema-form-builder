<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
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
        ?float $initialValue = null,
    ) {
        parent::__construct($name, $label, $isRequired, $help, $labelTranslations, $initialValue);
    }

    #[Override]
    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::NUMBER;
    }

    #[Override]
    public function value(): ?float
    {
        return $this->initialValue;
    }
}
