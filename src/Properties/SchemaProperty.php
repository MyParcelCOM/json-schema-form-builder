<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Properties;

use MyParcelCom\JsonSchema\FormBuilder\Properties\Items\Items;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\Meta;

class SchemaProperty
{
    /**
     * @param string                          $name              The name of the property. Corresponds to the field name the value will associate to.
     * @param SchemaPropertyType              $type              The JSON Schema property type.
     * @param string                          $description       A description of the property. Used to hold the label of the field
     */

    public function __construct(
        public readonly string $name,
        public readonly SchemaPropertyType $type,
        public readonly string $description,
        public readonly ?array $enum = null,
        public readonly ?array $required = null,
        public readonly ?Items $items = null,
        public readonly ?SchemaPropertyCollection $properties = null,
        public readonly ?Meta $meta = null
    ) {
    }

    public function toArray(): array
    {
        return [
            $this->name => array_filter([
                'type'        => $this->type->value,
                'description' => $this->description,
                'items'       => $this->items?->toArray(),
                'required'    => $this->required,
                'enum'        => $this->enum,
                'properties'  => $this->properties?->toArray(),
                'meta'        => $this->meta?->toArray(),
            ]),
        ];
    }
}
