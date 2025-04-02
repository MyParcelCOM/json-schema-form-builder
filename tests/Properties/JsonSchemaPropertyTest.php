<?php

declare(strict_types=1);

namespace Tests\Properties;

use Faker\Factory;
use MyParcelCom\JsonSchema\FormBuilder\Properties\JsonSchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\PropertyType;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class JsonSchemaPropertyTest extends TestCase
{
    public function test_it_converts_property_with_minimal_properties_into_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $description = $faker->words(asText: true);
        $type = $faker->randomElement(PropertyType::cases());

        $property = new JsonSchemaProperty(
            name: $name,
            type: $type,
            description: $description,
        );

        assertFalse($property->isRequired);
        assertEquals([
            $name => [
                'type'        => $type->value,
                'description' => $description,
            ],
        ], $property->toArray());
    }

    public function test_it_converts_property_with_all_properties_into_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $type = $faker->randomElement(PropertyType::cases());
        $description = $faker->words(asText: true);
        $enum = [
            $faker->word(),
            $faker->word(),
            $faker->word(),
        ];
        $help = $faker->words(asText: true);

        $property = new JsonSchemaProperty(
            name: $name,
            type: $type,
            description: $description,
            isRequired: true,
            isPassword: true,
            enum: $enum,
            help: $help,
        );

        assertTrue($property->isRequired);
        assertEquals([
            $name => [
                'type'        => $type->value,
                'description' => $description,
                'enum'        => $enum,
                'meta'        => [
                    'help'     => $help,
                    'password' => true,
                ],
            ],
        ], $property->toArray());
    }
}
