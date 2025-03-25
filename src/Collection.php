<?php

declare(strict_types=1);

namespace MyParcelCom\Commons\Configuration;
use ArrayObject;

/**
 * @template K
 * @template V
 * @extends ArrayObject<K,V>
 */
class Collection extends ArrayObject
{
    /**
     * @param V ...$items
     */
    public function __construct(...$items)
    {
        parent::__construct($items);
    }

    public function toArray(): array
    {
        return array_map(static fn ($entry) => $entry->toArray(), (array) $this);
    }
}
