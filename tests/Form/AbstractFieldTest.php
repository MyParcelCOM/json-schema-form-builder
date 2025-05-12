<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use MyParcelCom\JsonSchema\FormBuilder\Form\AbstractField;
use MyParcelCom\JsonSchema\FormBuilder\Properties\SchemaPropertyType;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class AbstractFieldTest extends TestCase
{
    public function test_it_converts_a_field_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $field = new class(
            name: $name,
            label: $label,
            help: 'Help text',
        ) extends AbstractField {
            public function isPassword(): bool
            {
                return true;
            }
            protected function schemaPropertyType(): SchemaPropertyType
            {
                return SchemaPropertyType::STRING;
            }
        };

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'meta' => [
                    'help'       => 'Help text',
                    'password' => true,
                ],
            ],
        ], $field->toJsonSchemaProperty()->toArray());
    }
}
