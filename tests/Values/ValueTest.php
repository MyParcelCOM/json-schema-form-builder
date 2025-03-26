<?php

declare(strict_types=1);

namespace Tests\Values;

use Faker\Factory;
use MyParcelCom\Integration\Configuration\Values\Value;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class ValueTest extends TestCase
{
    public function test_value(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $value = $faker->word();

        $valueObject = new Value($name, $value);

        assertEquals([
            'name'  => $name,
            'value' => $value,
        ], $valueObject->toArray());
    }
}
