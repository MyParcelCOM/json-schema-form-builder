<?php

declare(strict_types=1);

namespace Tests\Properties;

use Faker\Factory;
use MyParcelCom\JsonSchema\FormBuilder\Form\ChoiceFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
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
        $options = new OptionCollection(
            new Option(
                key: 'option_1',
                label: 'Option 1',
            ),
            new Option(
                key: 'option_2',
                label: 'Option 2',
            ),
            new Option(
                key: 'option_3',
                label: 'Option 3',
            ),

        );
        $help = $faker->words(asText: true);

        $property = new JsonSchemaProperty(
            name: $name,
            type: $type,
            description: $description,
            isRequired: true,
            isPassword: true,
            options: $options,
            help: $help,
            fieldType: ChoiceFieldType::SELECT,
        );

        assertTrue($property->isRequired);
        assertEquals([
            $name => [
                'type'        => $type->value,
                'description' => $description,
                'enum'        => ['option_1', 'option_2', 'option_3'],
                'meta'        => [
                    'help'        => $help,
                    'password'    => true,
                    'field_type'  => 'select',
                    'enum_labels' => [
                        'option_1' => 'Option 1',
                        'option_2' => 'Option 2',
                        'option_3' => 'Option 3',
                    ],
                ],
            ],
        ], $property->toArray());
    }
}
