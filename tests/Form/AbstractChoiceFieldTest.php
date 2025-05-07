<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Form\AbstractChoiceField;
use MyParcelCom\JsonSchema\FormBuilder\Form\ChoiceFieldType;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslation;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\Locale;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class AbstractChoiceFieldTest extends TestCase
{
    public function test_it_converts_into_an_array(): void
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
                    'help'       => 'Help text',
                    'field_type' => 'select',
                ],
            ],
        ], $field->toJsonSchemaProperty()->toArray());
    }

    public function test_it_converts_into_an_array_with_option_labels(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $field = new class(
            name: $name,
            label: $label,
            help: 'Help text',
            options: new OptionCollection(
                new Option('a', 'A'),
                new Option('b', 'B'),
                new Option('c', 'B'),
            ),
        ) extends AbstractChoiceField {
            protected ChoiceFieldType $fieldType = ChoiceFieldType::RADIO;
        };

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'enum'        => ['a', 'b', 'c'],
                'meta'        => [
                    'field_type'  => 'radio',
                    'help'        => 'Help text',
                    'enum_labels' => [
                        'a' => 'A',
                        'b' => 'B',
                        'c' => 'B',
                    ],
                ],
            ],
        ], $field->toJsonSchemaProperty()->toArray());
    }

    public function test_it_converts_into_an_array_with_option_labels_and_translations(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $field = new class(
            name: $name,
            label: $label,
            options: new OptionCollection(
                new Option(
                    'a', 'A', new LabelTranslationCollection(
                    new LabelTranslation(locale: Locale::EN_GB, label: 'A'),
                    new LabelTranslation(locale: Locale::NL_NL, label: 'A in het Nederlands'),
                    new LabelTranslation(locale: Locale::DE_DE, label: 'A in Deutsch'),
                ),
                ),
                new Option(
                    'b', 'B', new LabelTranslationCollection(
                    new LabelTranslation(locale: Locale::EN_GB, label: 'B'),
                    new LabelTranslation(locale: Locale::NL_NL, label: 'B in het Nederlands'),
                    new LabelTranslation(locale: Locale::DE_DE, label: 'B in Deutsch'),
                ),
                ),
                new Option(
                    'c', 'C', new LabelTranslationCollection(
                    new LabelTranslation(locale: Locale::EN_GB, label: 'C'),
                    new LabelTranslation(locale: Locale::NL_NL, label: 'C in het Nederlands'),
                    new LabelTranslation(locale: Locale::DE_DE, label: 'C in Deutsch'),
                ),
                ),
            ),
            labelTranslations: new LabelTranslationCollection(
                new LabelTranslation(locale: Locale::EN_GB, label: 'English label'),
                new LabelTranslation(locale: Locale::NL_NL, label: 'Nederlands label'),
                new LabelTranslation(locale: Locale::DE_DE, label: 'Deutsches Etikett'),
            ),
        ) extends AbstractChoiceField {
            protected ChoiceFieldType $fieldType = ChoiceFieldType::RADIO;
        };

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
                    'label_translations'      => [
                        'en-GB' => 'English label',
                        'nl-NL' => 'Nederlands label',
                        'de-DE' => 'Deutsches Etikett',
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

    public function test_it_converts_into_an_array_multiple_values(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $select = new class(
            name: $name,
            label: $label,
            options: new OptionCollection(
                new Option('1', 'One'),
                new Option('2', 'Two'),
                new Option('3', 'Three'),
            ),
            multipleValues: true,
        ) extends AbstractChoiceField {
            protected ChoiceFieldType $fieldType = ChoiceFieldType::RADIO;
        };

        assertEquals([
            $name => [
                'type'        => 'array',
                'description' => $label,
                'items'       => [
                    'type' => 'string',
                    'enum' => ['1', '2', '3'],
                ],
                'meta'        => [
                    'field_type'  => 'radio',
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
