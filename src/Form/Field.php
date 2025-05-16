<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Meta\Meta;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use Override;

abstract class Field extends FormElement
{
    public function __construct(
        string $name,
        public readonly string $label,
        bool $isRequired = false,
        public readonly ?string $help = null,
        public ?LabelTranslationCollection $labelTranslations = null,
    ) {
        parent::__construct(name: $name, isRequired: $isRequired);
    }

    public function isPassword(): bool
    {
        return false;
    }

    #[Override]
    public function toJsonSchemaProperty(): SchemaProperty
    {
        return new SchemaProperty(
            name: $this->name,
            type: $this->schemaPropertyType(),
            description: $this->label,
            meta: new Meta(
                help: $this->help,
                password: $this->isPassword(),
                labelTranslations: $this->labelTranslations?->toArray(),
            ),
        );
    }
}
