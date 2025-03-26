<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use InvalidArgumentException;
use MyParcelCom\Integration\Configuration\Form\Select;
use MyParcelCom\Integration\Configuration\Properties\PropertyType;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class SelectTest extends TestCase
{
    public function test_it_converts_a_select_property_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $select = new Select(
            name: $name,
            type: PropertyType::STRING,
            label: $label,
            enum: [
                1,
                2,
                3,
            ],
        );

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'enum'        => [
                    1,
                    2,
                    3,
                ],
            ],
        ], $select->toJsonSchemaProperty()->toArray());
    }

    public function test_it_throws_an_invalid_argument_exception_without_enum_values(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Select property requires at least one enum value.');

        $faker = Factory::create();

        new Select(
            name: $faker->word,
            type: PropertyType::STRING,
            label: $faker->words(asText: true),
            enum: [],
        );
    }
}
