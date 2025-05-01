<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\Select;
use MyParcelCom\JsonSchema\FormBuilder\Properties\PropertyType;
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
            label: $label,
            options: new OptionCollection(
                new Option('1'),
                new Option('2'),
                new Option('3')
            ),
        );

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'enum'        => ['1', '2', '3'],
                'meta' => ['field_type' => 'select']
            ],
        ], $select->toJsonSchemaProperty()->toArray());
    }

    public function test_it_throws_an_invalid_argument_exception_without_options(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Select field property requires at least one option.');

        $faker = Factory::create();

        new Select(
            name: $faker->word,
            label: $faker->words(asText: true),
            options: new OptionCollection(),
        );
    }
}
