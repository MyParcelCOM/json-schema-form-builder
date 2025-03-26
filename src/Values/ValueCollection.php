<?php

declare(strict_types=1);

namespace MyParcelCom\Integration\Configuration\Values;

use MyParcelCom\Integration\Configuration\Collection;

/**
 *  @extends Collection<Value>
 */
class ValueCollection extends Collection
{
    public function toArray(): array
    {
        return array_map(static fn (Value $entry) => $entry->toArray(), (array) $this);
    }
}
