<?php

declare(strict_types=1);

namespace Tests\Properties;

use Faker\Factory;
use MyParcelCom\JsonSchema\FormBuilder\Form\FieldType;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class SchemaPropertyTest extends TestCase
{
    public function test_it_converts_property_with_minimal_properties_into_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $description = $faker->words(asText: true);
        $fieldType = $faker->randomElement(FieldType::cases());

        $property = new SchemaProperty(
            name: $name,
            type: SchemaPropertyType::from($fieldType->value),
            description: $description,
        );

        assertFalse($property->isRequired);
        assertEquals([
            $name => [
                'type'        => $fieldType->value,
                'description' => $description,
            ],
        ], $property->toArray());
    }

    public function test_it_converts_property_with_all_properties_into_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $type = $faker->randomElement(FieldType::cases());
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

        $property = new SchemaProperty(
            name: $name,
            type: SchemaPropertyType::from($type->value),
            description: $description,
            isRequired: true,
            isPassword: true,
            options: $options,
            help: $help,
            metaFieldType: MetaFieldType::SELECT,
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
