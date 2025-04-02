<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use MyParcelCom\JsonSchema\FormBuilder\Form\Number;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class NumberTest extends TestCase
{
    public function test_it_converts_a_number_property_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $number = new Number(
            name: $name,
            label: $label,
        );

        assertEquals([
            $name => [
                'type'        => 'number',
                'description' => $label,
            ],
        ], $number->toJsonSchemaProperty()->toArray());
    }
}
