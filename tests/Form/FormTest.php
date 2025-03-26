<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use MyParcelCom\Integration\Configuration\Form\Form;
use MyParcelCom\Integration\Configuration\Form\Text;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class FormTest extends TestCase
{
    public function test_get_required_property_names(): void
    {
        $faker = Factory::create();

        [$nameOne, $nameTwo] = [$faker->word(), $faker->word()];
        $label = $faker->words(asText: true);

        $propertyOne = new Text(
            name: $nameOne,
            label: $label,
        );
        $propertyTwo = new Text(
            name: $nameTwo,
            label: $label,
            isRequired: true,
        );

        $form = new Form($propertyOne, $propertyTwo);

        assertEquals([$nameTwo], $form->getRequired());
    }
}
