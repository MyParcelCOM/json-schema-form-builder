<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\RadioButtons;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslation;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\Locale;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class RadioButtonsTest extends TestCase
{
    public function test_it_converts_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $radio = new RadioButtons(
            name: $name,
            label: $label,
            options: new OptionCollection(
                new Option('a', 'Option A'),
                new Option('b', 'Option B'),
                new Option('c', 'Option C'),
            ),
            isRequired: true,
            help: 'This is a help text',
        );

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'enum'        => ['a', 'b', 'c'],
                'meta'        => [
                    'field_type' => 'radio',
                    'help'       => 'This is a help text',
                    'enum_labels' => [
                        'a' => 'Option A',
                        'b' => 'Option B',
                        'c' => 'Option C',
                    ],
                ],
            ],
        ], $radio->toJsonSchemaProperty()->toArray());
    }
}
