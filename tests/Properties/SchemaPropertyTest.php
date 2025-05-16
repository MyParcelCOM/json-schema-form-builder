<?php

declare(strict_types=1);

namespace Tests\Properties;

use Faker\Factory;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Items\Items;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Meta\Meta;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\Meta\MetaFieldType;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaPropertyCollection;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaPropertyType;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class SchemaPropertyTest extends TestCase
{
    public function test_it_converts_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $description = $faker->words(asText: true);
        $type = $faker->randomElement(SchemaPropertyType::cases());

        $property = new SchemaProperty(
            name: $name,
            type: $type,
            description: $description,
        );

        assertEquals([
            $name => [
                'type'        => $type->value,
                'description' => $description,
            ],
        ], $property->toArray());
    }

    public function test_it_converts_into_an_array_with_all_properties(): void
    {
        $property = new SchemaProperty(
            name: 'test_group',
            type: SchemaPropertyType::OBJECT,
            description: 'Some Description',
            enum: ['option_1', 'option_2', 'option_3'],
            required: ['option_1'],
            items: new Items(enum: ['option_1', 'option_2', 'option_3']),
            properties: new SchemaPropertyCollection(
                new SchemaProperty(
                    name: 'name_1',
                    type: SchemaPropertyType::STRING,
                    description: 'Label 1',
                    meta: new Meta(
                        help: 'help property 1',
                    ),
                ),
                new SchemaProperty(
                    name: 'name_2',
                    type: SchemaPropertyType::BOOLEAN,
                    description: 'Label 2',
                ),
            ),
            meta: new Meta(
                help: 'help me!',
                password: true,
                fieldType: MetaFieldType::SELECT,
                enumLabels: [
                    'option_1' => 'Option 1',
                    'option_2' => 'Option 2',
                    'option_3' => 'Option 3',
                ],
            ),
        );

        assertEquals([
            'test_group' => [
                'type'        => 'object',
                'description' => 'Some Description',
                'enum'        => ['option_1', 'option_2', 'option_3'],
                'required'    => ['option_1'],
                'meta'        => [
                    'help'        => 'help me!',
                    'password'    => true,
                    'field_type'  => 'select',
                    'enum_labels' => [
                        'option_1' => 'Option 1',
                        'option_2' => 'Option 2',
                        'option_3' => 'Option 3',
                    ],
                ],
                'items'       => [
                    'type' => 'string',
                    'enum' => ['option_1', 'option_2', 'option_3'],
                ],
                'properties'  => [
                    'name_1' => [
                        'type'        => 'string',
                        'description' => 'Label 1',
                        'meta'        => [
                            'help' => 'help property 1',
                        ],
                    ],
                    'name_2' => [
                        'type'        => 'boolean',
                        'description' => 'Label 2',
                    ],
                ],
            ],
        ], $property->toArray());
    }
}
