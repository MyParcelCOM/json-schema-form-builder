<?php

declare(strict_types=1);

namespace Tests\Validation;

use Mockery;
use MyParcelCom\JsonSchema\FormBuilder\Validation\Validator;
use Opis\JsonSchema\ValidationResult;
use PHPUnit\Framework\TestCase;
use Opis\JsonSchema\Validator as JsonSchemaValidator;

class ValidatorTest extends TestCase
{
    protected array $schema;
    protected function setUp(): void
    {
        parent::setUp();
        $this->schema = [
            '$schema'              => 'https://json-schema.org/draft/2020-12/schema',
            'type'                 => 'object',
            'additionalProperties' => false,
            'required'             => [
                0 => 'name_2',
                1 => 'name_3',
            ],
            'properties'           => [
                'name_1' => [
                    'type'        => 'string',
                    'description' => 'Label 1',
                ],
                'name_2' => [
                    'type'        => 'boolean',
                    'description' => 'Label 2',
                    'meta'        => [
                        'help' => 'Assistance is required',
                    ],
                ],
                'name_3' => [
                    'type'        => 'string',
                    'description' => 'Label 3',
                    'enum'        => [
                        'a',
                        'b',
                    ],
                    'meta'        => [
                        'help'        => 'This field has no purpose',
                        'field_type'  => 'radio',
                        'enum_labels' => [
                            'a' => 'A',
                            'b' => 'B',
                        ],
                    ],
                ],
                'name_4' => [
                    'type'        => 'object',
                    'description' => 'Label 4',
                    'required'    => [
                        0 => 'name_2',
                        1 => 'name_3',
                    ],
                    'properties'  => [
                        'name_1' => [
                            'type'        => 'string',
                            'description' => 'Label 1',
                        ],
                        'name_2' => [
                            'type'        => 'boolean',
                            'description' => 'Label 2',
                            'meta'        => [
                                'help' => 'Assistance is required',
                            ],
                        ],
                        'name_3' => [
                            'type'        => 'string',
                            'description' => 'Label 3',
                            'enum'        => [
                                'a',
                                'b',
                            ],
                            'meta'        => [
                                'help'        => 'This field has no purpose',
                                'field_type'  => 'radio',
                                'enum_labels' => [
                                    'a' => 'A',
                                    'b' => 'B',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     */
    public function test_it_validates(): void
    {
        $this->expectNotToPerformAssertions();
        $validationResult = Mockery::mock(ValidationResult::class);
        $validationResult->expects('isValid');
        $validationResult->expects('error');

        $jsonSchemaValidator = Mockery::mock(JsonSchemaValidator::class);
        $jsonSchemaValidator->expects('validate')->andReturn($validationResult);

        Validator::validate([
            'name_1' => 'value',
            'name_2' => false,
            'name_3' => 'a',
            'name_4' => [
                'name_1' => 'value',
                'name_2' => false,
                'name_3' => 'a',
            ],
        ], $this->schema, $jsonSchemaValidator);
    }
}
