<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Values;

class Value
{
    public function __construct(
        public readonly string $name,
        public readonly string $value,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name'  => $this->name,
            'value' => $this->value,
        ];
    }
}
