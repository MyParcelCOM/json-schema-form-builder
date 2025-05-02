<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Form\AbstractChoiceField;
use MyParcelCom\JsonSchema\FormBuilder\Form\ChoiceFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class AbstractChoiceFieldTest extends TestCase
{
    public function test_it_converts_a_choice_field_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $field = new class(
            name: $name,
            label: $label,
            help: 'Help text',
            options: new OptionCollection(
                new Option('1'),
                new Option('2'),
                new Option('3'),
            ),
        ) extends AbstractChoiceField {
            protected ChoiceFieldType $fieldType = ChoiceFieldType::SELECT;
        };

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'enum'        => ['1', '2', '3'],
                'meta'        => [
                    'help' => 'Help text',
                    'field_type' => 'select'
                ],
            ],
        ], $field->toJsonSchemaProperty()->toArray());
    }

    public function test_it_throws_an_invalid_argument_exception_without_options(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio field property requires at least one option.');

        $faker = Factory::create();

        new class(
            name: $faker->word,
            label: $faker->words(asText: true),
            options: new OptionCollection(),
        ) extends AbstractChoiceField {
            protected ChoiceFieldType $fieldType = ChoiceFieldType::RADIO;
        };
    }
}
