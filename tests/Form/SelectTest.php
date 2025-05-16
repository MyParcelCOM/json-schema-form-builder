<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use InvalidArgumentException;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\RadioButtons;
use MyParcelCom\JsonSchema\FormBuilder\Form\Select;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslation;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\Locale;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class SelectTest extends TestCase
{
    public function test_it_converts_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $field = new Select(
            name: $name,
            label: $label,
            options: new OptionCollection(
                new Option('a', 'A'),
                new Option('b', 'B'),
                new Option('c', 'C'),
            ),
            help: 'Help text',
        );


        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'enum'        => ['a', 'b', 'c'],
                'meta'        => [
                    'field_type'  => 'select',
                    'help'        => 'Help text',
                    'enum_labels' => [
                        'a' => 'A',
                        'b' => 'B',
                        'c' => 'C',
                    ],
                ],
            ],
        ], $field->toJsonSchemaProperty()->toArray());
    }

    public function test_it_gets_is_required(): void
    {
        $requiredField = new RadioButtons(
            name: 'name',
            label: 'label',
            options: new OptionCollection(
                new Option('a', 'A'),
                new Option('b', 'B'),
                new Option('c', 'C'),
            ),
            isRequired: true,
        );

        $nonRequiredField = new RadioButtons(
            name: 'name',
            label: 'label',
            options: new OptionCollection(
                new Option('a', 'A'),
                new Option('b', 'B'),
                new Option('c', 'C'),
            ),
        );

        assertTrue($requiredField->isRequired);
        assertFalse($nonRequiredField->isRequired);
    }

    public function test_it_gets_value(): void
    {
        $field = new Select(
            name: 'name',
            label: 'label',
            options: new OptionCollection(
                new Option('a', 'A'),
                new Option('b', 'B'),
                new Option('c', 'C'),
            ),
        );
        assertNull($field->value());

        $field = new Select(
            name: 'name',
            label: 'label',
            options: new OptionCollection(
                new Option('a', 'A'),
                new Option('b', 'B'),
                new Option('c', 'C'),
            ),
            value: 'b',
        );

        assertEquals('b', $field->value());
    }

    public function test_it_converts_into_an_array_with_translations(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $field = new Select(
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
        );

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'enum'        => ['a', 'b', 'c'],
                'meta'        => [
                    'field_type'              => 'select',
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

    public function test_it_throws_invalid_argument_exception_without_options(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Select field requires at least one option.');

        new Select(
            name: 'name',
            label: 'label',
            options: new OptionCollection(),
        );
    }

    public function test_it_throws_invalid_argument_exception_when_initial_value_is_invalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Select field value must be one of its options. Invalid option: \'invalid\'');

        new Select(
            name: 'name',
            label: 'label',
            options: new OptionCollection(
                new Option('a', 'A'),
                new Option('b', 'B'),
                new Option('c', 'C'),
            ),
            value: 'invalid',
        );
    }
}
