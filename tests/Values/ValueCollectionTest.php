<?php

declare(strict_types=1);

namespace Tests\Values;

use Faker\Factory;
use MyParcelCom\Integration\Configuration\Values\Value;
use MyParcelCom\Integration\Configuration\Values\ValueCollection;
use PHPUnit\Framework\TestCase;

class ValueCollectionTest extends TestCase
{
    public function test_value_collection()
    {
        $faker = Factory::create();

        $name1 = $faker->word();
        $value1 = $faker->word();

        $name2 = $faker->word();
        $value2 = $faker->word();

        $valueObject1 = new Value($name1, $value1);
        $valueObject2 = new Value($name2, $value2);

        $valueCollection = new ValueCollection($valueObject1, $valueObject2);

        $this->assertEquals([
            [
                'name' => $name1,
                'value' => $value1,
            ],
            [
                'name' => $name2,
                'value' => $value2,
            ],
        ], $valueCollection->toArray());
    }
}
