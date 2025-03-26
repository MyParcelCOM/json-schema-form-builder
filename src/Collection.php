<?php

declare(strict_types=1);

namespace MyParcelCom\Integration\Configuration;


use ArrayObject;

/**
 *  @template V
 *  @extends ArrayObject<array-key,V>
 * /
 */
abstract class Collection extends ArrayObject
{
    /**
     * @param V ...$items
     */
    public function __construct(...$items)
    {
        parent::__construct($items);
    }
    abstract public function toArray();
}
