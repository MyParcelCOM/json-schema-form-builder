<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Items;

use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaPropertyType;

class Items
{
    private const SchemaPropertyType TYPE = SchemaPropertyType::STRING;

    /**
     * @param array<string> $enum
     */
    public function __construct(
        private readonly array $enum,
    ) {
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE->value,
            'enum' => $this->enum,
        ];
    }
}
