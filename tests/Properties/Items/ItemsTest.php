<?php

declare(strict_types=1);

namespace Tests\Properties\Items;

use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Items\Items;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class ItemsTest extends TestCase
{
    public function test_it_converts_into_an_array(): void
    {
        $items = new Items(
            enum: ['value_1', 'value_2', 'value_3'],
        );
        assertEquals([
            'type' => 'string',
            'enum' => ['value_1', 'value_2', 'value_3'],
        ], $items->toArray());
    }
}
