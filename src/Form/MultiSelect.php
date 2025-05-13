<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\Items\Items;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\Meta;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use Override;

class MultiSelect extends ChoiceField
{
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
}
