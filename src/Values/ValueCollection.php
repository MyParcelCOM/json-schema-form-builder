<?php

declare(strict_types=1);

namespace MyParcelCom\Integration\Configuration\Values;

use ArrayObject;

/**
 *  @extends ArrayObject<array-key,Value>
 */
class ValueCollection extends ArrayObject
{
    public function toArray(): array
    {
        return array_map(static fn (Value $entry) => $entry->toArray(), (array) $this);
    }
}
