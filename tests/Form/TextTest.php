<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use MyParcelCom\Integration\Configuration\Form\Text;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class TextTest extends TestCase
{
    public function test_it_converts_a_text_property_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $text = new Text(
            name: $name,
            label: $label,
        );

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
            ],
        ], $text->toJsonSchemaProperty()->toArray());
    }
}
