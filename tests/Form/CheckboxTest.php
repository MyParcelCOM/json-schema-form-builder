<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use MyParcelCom\JsonSchema\FormBuilder\Form\Checkbox;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslation;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\Locale;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class CheckboxTest extends TestCase
{
    public function test_it_converts_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $field = new Checkbox(
            name: $name,
            label: $label,
            help: 'Help text',
        );

        assertEquals([
            $name => [
                'type'        => 'boolean',
                'description' => $label,
                'meta'        => [
                    'help' => 'Help text',
                ],
            ],
        ], $field->toJsonSchemaProperty()->toArray());
    }

    public function test_it_gets_is_required(): void
    {
        $requiredField = new Checkbox(
            name: 'name',
            label: 'label',
            isRequired: true,
        );

        $nonRequiredField = new Checkbox(
            name: 'name',
            label: 'label',
        );

        assertTrue($requiredField->isRequired);
        assertFalse($nonRequiredField->isRequired);
    }

    public function test_it_gets_value(): void
    {
        $field = new Checkbox(
            name: 'name',
            label: 'label',
        );
        assertNull($field->value());

        $field = new Checkbox(
            name: 'name',
            label: 'label',
            value: true,
        );
        assertTrue($field->value());

        $field = new Checkbox(
            name: 'name',
            label: 'label',
            value: false,
        );
        assertFalse($field->value());
    }

    public function test_it_converts_into_an_array_with_translations(): void
    {
        $field = new Checkbox(
            name: 'name',
            label: 'label',
            help: 'Help text',
            labelTranslations: new LabelTranslationCollection(
                new LabelTranslation(locale: Locale::EN_GB, label: 'English label'),
                new LabelTranslation(locale: Locale::NL_NL, label: 'Nederlands label'),
                new LabelTranslation(locale: Locale::DE_DE, label: 'Deutsches Etikett'),
            ),
        );

        assertEquals([
            'name' => [
                'type'        => 'boolean',
                'description' => 'label',
                'meta'        => [
                    'help'               => 'Help text',
                    'label_translations' => [
                        'en-GB' => 'English label',
                        'nl-NL' => 'Nederlands label',
                        'de-DE' => 'Deutsches Etikett',
                    ],
                ],
            ],
        ], $field->toJsonSchemaProperty()->toArray());
    }
}
