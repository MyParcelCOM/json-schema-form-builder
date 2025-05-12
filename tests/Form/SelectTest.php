<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\Select;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class SelectTest extends TestCase
{
    public function test_it_converts_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $select = new Select(
            name: $name,
            label: $label,
            options: new OptionCollection(
                new Option('1', 'One'),
                new Option('2', 'Two'),
                new Option('3', 'Three'),
            ),
        );

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'enum'        => ['1', '2', '3'],
                'meta'        => [
                    'field_type' => 'select',
                    'enum_labels' => [
                        '1' => 'One',
                        '2' => 'Two',
                        '3' => 'Three',
                    ],
                ],
            ],
        ], $select->toJsonSchemaProperty()->toArray());
    }

    public function test_it_converts_into_an_array_multi_select(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $select = new Select(
            name: $name,
            label: $label,
            options: new OptionCollection(
                new Option('1', 'One'),
                new Option('2', 'Two'),
                new Option('3', 'Three'),
            ),
            isMultiSelect: true,
        );

        assertEquals([
            $name => [
                'type'        => 'array',
                'description' => $label,
                'items'       => [
                    'type' => 'string',
                    'enum' => ['1', '2', '3'],
                ],
                'meta'        => [
                    'field_type'  => 'select',
                    'enum_labels' => [
                        '1' => 'One',
                        '2' => 'Two',
                        '3' => 'Three',
                    ],
                ],
            ],
        ], $select->toJsonSchemaProperty()->toArray());
    }
}
