<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use MyParcelCom\JsonSchema\FormBuilder\Form\Password;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslation;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\Locale;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class PasswordTest extends TestCase
{
    public function test_it_converts_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $field = new Password(
            name: $name,
            label: $label,
            help: 'Help text',
        );

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'meta'        => [
                    'help'     => 'Help text',
                    'password' => true,
                ],
            ],
        ], $field->toJsonSchemaProperty()->toArray());
    }

    public function test_it_gets_is_required(): void
    {
        $requiredField = new Password(
            name: 'name',
            label: 'label',
            isRequired: true,
        );

        $nonRequiredField = new Password(
            name: 'name',
            label: 'label',
        );

        assertTrue($requiredField->isRequired);
        assertFalse($nonRequiredField->isRequired);
    }

    public function test_it_gets_value(): void
    {
        $field = new Password(
            name: 'name',
            label: 'label',
        );
        assertNull($field->value());

        $field = new Password(
            name: 'name',
            label: 'label',
            value: 'It is a secret :X',
        );

        assertEquals('It is a secret :X', $field->value());
    }

    public function test_it_converts_into_an_array_with_translations(): void
    {
        $field = new Password(
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
                'type'        => 'string',
                'description' => 'label',
                'meta'        => [
                    'help'               => 'Help text',
                    'password'           => true,
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
