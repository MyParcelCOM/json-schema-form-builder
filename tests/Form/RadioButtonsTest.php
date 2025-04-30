<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\RadioButtons;
use MyParcelCom\JsonSchema\FormBuilder\Properties\PropertyType;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class RadioButtonsTest extends TestCase
{
    public function test_it_converts_a_radio_property_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $radio = new RadioButtons(
            name: $name,
            label: $label,
            options: new OptionCollection(
                new Option('a'),
                new Option('b'),
                new Option('c')
            ),
        );

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'enum'        => ['a', 'b', 'c'],
                'meta' => ['field_type' => 'radio']
            ],
        ], $radio->toJsonSchemaProperty()->toArray());
    }

    public function test_it_throws_an_invalid_argument_exception_without_enum_values(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio field property requires at least one enum value.');

        $faker = Factory::create();

        new RadioButtons(
            name: $faker->word,
            label: $faker->words(asText: true),
            options: new OptionCollection(),
        );
    }
}
