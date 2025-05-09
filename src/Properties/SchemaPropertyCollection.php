<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Properties;

use ArrayObject;
use Illuminate\Support\Arr;

class SchemaPropertyCollection extends ArrayObject
{
    public function __construct(SchemaProperty ...$schemaProperties)
    {
        parent::__construct($schemaProperties);
    }
    public function toArray(): array
    {
        return Arr::collapse(
            Arr::map(
                (array) $this,
                static fn (SchemaProperty $property) => $property->toArray(),
            ),
        );
    }
}
