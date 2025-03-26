<?php

declare(strict_types=1);

namespace Tests\Http\Responses;

use Faker\Factory;
use Illuminate\Http\Request;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use MyParcelCom\Integration\Configuration\Form\Checkbox;
use MyParcelCom\Integration\Configuration\Form\Form;
use MyParcelCom\Integration\Configuration\Form\Number;
use MyParcelCom\Integration\Configuration\Form\Password;
use MyParcelCom\Integration\Configuration\Form\Select;
use MyParcelCom\Integration\Configuration\Form\Text;
use MyParcelCom\Integration\Configuration\Http\Responses\ConfigurationResponse;
use MyParcelCom\Integration\Configuration\Properties\PropertyType;
use MyParcelCom\Integration\Configuration\Values\Value;
use MyParcelCom\Integration\Configuration\Values\ValueCollection;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class ConfigurationResponseTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_it_creates_a_configuration_response_with_minimal_data(): void
    {
        $form = Mockery::mock(Form::class, [
            'toArray'     => [],
            'getRequired' => [],
        ]);

        $configuration = new ConfigurationResponse($form);

        assertEquals(
            [
                'configuration_schema' =>
                    [
                        '$schema'              => 'http://json-schema.org/draft-04/schema#',
                        'additionalProperties' => false,
                        'required'             => [],
                        'properties'           => [],
                    ],
            ],
            $configuration->toResponse(Mockery::mock(Request::class))->getData(true),
        );
    }

    public function test_it_creates_a_configuration_response_with_values(): void
    {
        $form = Mockery::mock(Form::class, [
            'toArray'     => [],
            'getRequired' => [],
        ]);

        $faker = Factory::create();

        $name = $faker->word();
        $value = $faker->word();

        $valueObject = new Value($name, $value);

        $configuration = new ConfigurationResponse($form, new ValueCollection($valueObject));

        assertEquals(
            [
                'configuration_schema' => [
                    '$schema'              => 'http://json-schema.org/draft-04/schema#',
                    'additionalProperties' => false,
                    'required'             => [],
                    'properties'           => [],
                ],
                'values'               => [
                    [
                        'name'  => $name,
                        'value' => $value,
                    ],
                ],
            ],
            $configuration->toResponse(Mockery::mock(Request::class))->getData(true),
        );
    }

    public function test_it_creates_a_configuration_response_with_all_data(): void
    {
        $faker = Factory::create();

        [$nameText, $nameNumber, $nameCheckbox, $namePassword, $nameSelect] = [
            $faker->word(),
            $faker->word(),
            $faker->word(),
            $faker->word(),
            $faker->word(),
        ];
        $label = $faker->words(asText: true);

        $text = new Text(
            name: $nameText,
            label: $label,
            isRequired: true,
        );
        $number = new Number(
            name: $nameNumber,
            label: $label,
            isRequired: true,
        );
        $checkbox = new Checkbox(
            name: $nameCheckbox,
            label: $label,
            isRequired: true,
            help: 'A help for this property',
        );
        $password = new Password(
            name: $namePassword,
            label: $label,
            isRequired: true,
        );
        $select = new Select(
            name: $nameSelect,
            type: PropertyType::STRING,
            label: $label,
            isRequired: true,
            enum: ['1', '2', '3'],
        );
        $form = new Form(
            $text,
            $number,
            $checkbox,
            $password,
            $select,
        );

        $name = $faker->word();
        $value = $faker->word();

        $valueObject = new Value($name, $value);

        $configuration = new ConfigurationResponse($form, new ValueCollection($valueObject));

        assertEquals(
            [
                'configuration_schema' => [
                    '$schema'              => 'http://json-schema.org/draft-04/schema#',
                    'additionalProperties' => false,
                    'required'             => [$nameText, $nameNumber, $nameCheckbox, $namePassword, $nameSelect],
                    'properties'           => [
                        $nameText     => [
                            'type'        => 'string',
                            'description' => $label,
                        ],
                        $nameNumber   => [
                            'type'        => 'number',
                            'description' => $label,
                        ],
                        $nameCheckbox => [
                            'type'        => 'boolean',
                            'description' => $label,
                            'meta'        => [
                                'help' => 'A help for this property',
                            ],
                        ],
                        $namePassword => [
                            'type'        => 'string',
                            'description' => $label,
                            'meta'        => [
                                'password' => true,
                            ],
                        ],
                        $nameSelect   => [
                            'type'        => 'string',
                            'description' => $label,
                            'enum'        => [
                                '1',
                                '2',
                                '3',
                            ],
                        ],
                    ],
                ],
                'values'               => [
                    [
                        'name'  => $name,
                        'value' => $value,
                    ],
                ],
            ],
            $configuration->toResponse(Mockery::mock(Request::class))->getData(true),
        );
    }
}
