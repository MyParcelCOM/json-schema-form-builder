<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use MyParcelCom\Integration\Configuration\Form\Password;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class PasswordTest extends TestCase
{
    public function test_it_converts_a_password_property_into_an_array(): void
    {
        $faker = Factory::create();

        $name = $faker->word();
        $label = $faker->words(asText: true);

        $password = new Password(
            name: $name,
            label: $label,
        );

        assertEquals([
            $name => [
                'type'        => 'string',
                'description' => $label,
                'meta'        => [
                    'password' => true,
                ],
            ],
        ], $password->toJsonSchemaProperty()->toArray());
    }
}
