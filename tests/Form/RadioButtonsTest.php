<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\RadioButtons;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslation;
use MyParcelCom\JsonSchema\FormBuilder\Translations\Locale;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class RadioButtonsTest extends TestCase
{
    public function test_it_converts_into_an_array_basic(): void
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
                new Option('c'),
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
                ],
            ],
        ], $radio->toJsonSchemaProperty()->toArray());
    }

    public function test_it_converts_into_an_array_with_enum_labels(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $radio = new RadioButtons(
            name: $name,
            label: $label,
            options: new OptionCollection(
                new Option('a', 'A'),
                new Option('b', 'B'),
                new Option('c', 'B'),
            ),
        );

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'enum'        => ['a', 'b', 'c'],
                'meta'        => [
                    'field_type'  => 'radio',
                    'enum_labels' => [
                        'a' => 'A',
                        'b' => 'B',
                        'c' => 'B',
                    ],
                ],
            ],
        ], $radio->toJsonSchemaProperty()->toArray());
    }

    public function test_it_converts_into_an_array_with_enum_labels_and_translations(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $radio = new RadioButtons(
            name: $name,
            label: $label,
            options: new OptionCollection(
                new Option('a', 'A', [
                    new LabelTranslation(locale: Locale::EN_GB, label: 'A'),
                    new LabelTranslation(locale: Locale::NL_NL, label: 'A in het Nederlands'),
                    new LabelTranslation(locale: Locale::DE_DE, label: 'A in Deutsch'),
                ]),
                new Option('b', 'B', [
                    new LabelTranslation(locale: Locale::EN_GB, label: 'B'),
                    new LabelTranslation(locale: Locale::NL_NL, label: 'B in het Nederlands'),
                    new LabelTranslation(locale: Locale::DE_DE, label: 'B in Deutsch'),
                ]),
                new Option('c', 'C', [
                    new LabelTranslation(locale: Locale::EN_GB, label: 'C'),
                    new LabelTranslation(locale: Locale::NL_NL, label: 'C in het Nederlands'),
                    new LabelTranslation(locale: Locale::DE_DE, label: 'C in Deutsch'),
                ]),
            ),
        );

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'enum'        => ['a', 'b', 'c'],
                'meta'        => [
                    'field_type'              => 'radio',
                    'enum_labels'             => [
                        'a' => 'A',
                        'b' => 'B',
                        'c' => 'C',
                    ],
                    'enum_label_translations' => [
                        'a' => [
                            'en-GB' => 'A',
                            'nl-NL' => 'A in het Nederlands',
                            'de-DE' => 'A in Deutsch',
                        ],
                        'b' => [
                            'en-GB' => 'B',
                            'nl-NL' => 'B in het Nederlands',
                            'de-DE' => 'B in Deutsch',
                        ],
                        'c' => [
                            'en-GB' => 'C',
                            'nl-NL' => 'C in het Nederlands',
                            'de-DE' => 'C in Deutsch',
                        ],
                    ],
                ],
            ],
        ], $radio->toJsonSchemaProperty()->toArray());
    }

    public function test_it_throws_an_invalid_argument_exception_without_options(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio field property requires at least one option.');

        $faker = Factory::create();

        new RadioButtons(
            name: $faker->word,
            label: $faker->words(asText: true),
            options: new OptionCollection(),
        );
    }
}
