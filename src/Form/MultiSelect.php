<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\Items\Items;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\Meta;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use Override;

class MultiSelect extends ChoiceField
{
    /**
     * @param array<string>|null $initialValue
     */
    public function __construct(
        string $name,
        string $label,
        OptionCollection $options,
        bool $isRequired = false,
        ?string $help = null,
        ?LabelTranslationCollection $labelTranslations = null,
        protected ?array $initialValue = null,
    ) {
        parent::__construct($name, $label, $options, $isRequired, $help, $labelTranslations, $initialValue);
    }

    #[Override]
    protected function fieldType(): MetaFieldType
    {
        return MetaFieldType::SELECT;
    }

    #[Override]
    protected function schemaPropertyType(): SchemaPropertyType
    {
        return SchemaPropertyType::ARRAY;
    }

    #[Override]
    public function toJsonSchemaProperty(): SchemaProperty
    {
        return new SchemaProperty(
            name: $this->name(),
            type: $this->schemaPropertyType(),
            description: $this->label,
            items: new Items($this->options->getKeys()),
            meta: new Meta(
                help: $this->help,
                fieldType: $this->fieldType(),
                labelTranslations: $this->labelTranslations?->toArray(),
                enumLabels: $this->options->getLabels(),
                enumLabelTranslations: $this->options->getLabelTranslations(),
            ),
        );
    }


    #[Override]
    public function value(): ?array
    {
        return $this->initialValue;
    }
}
