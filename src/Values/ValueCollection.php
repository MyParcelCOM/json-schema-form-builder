<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Values;

use ArrayObject;

/**
 * @extends ArrayObject<array-key,Value>
 */
class ValueCollection extends ArrayObject
{
    public function __construct(...$items)
    {
        parent::__construct($items);
    }

    public function toArray(): array
    {
        return array_map(static fn (Value $entry) => $entry->toArray(), (array) $this);
    }
}
