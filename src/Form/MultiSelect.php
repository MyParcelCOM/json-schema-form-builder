<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Items\Items;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Meta\Meta;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaPropertyType;
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
        private readonly ?array $initialValue = null,
    ) {
        if ($initialValue !== null) {
            $invalidValues = array_diff($initialValue, $options->getKeys());
            if (!empty($invalidValues)) {
                throw new InvalidArgumentException(
                    'MultiSelect Initial value must only contain valid options. Invalid options: ' . implode(
                        ', ',
                        array_map(fn ($value) => "'{$value}'", $invalidValues),
                    ),
                );
            }
        }
        parent::__construct(
            name: $name,
            label: $label,
            options: $options,
            isRequired: $isRequired,
            help: $help,
            labelTranslations: $labelTranslations,
        );
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
            name: $this->name,
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
