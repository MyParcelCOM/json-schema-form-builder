<?php

declare(strict_types=1);

namespace MyParcelCom\Integration\Configuration\Values;


use ArrayObject;

/**
 *  @template K
 *  @extends ArrayObject<K,Value>
 * /
 */
class ValueCollection extends ArrayObject
{
    /**
     * @param Value ...$items
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
