<?php

declare(strict_types=1);

namespace Tests\Validation;

use Mockery;
use MyParcelCom\JsonSchema\FormBuilder\Validation\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private array $schema;
    protected function setUp(): void
    {
        parent::setUp();
        $this->schema = [
            '$schema'              => 'https://json-schema.org/draft/2020-12/schema',
            'type'                 => 'object',
            'additionalProperties' => false,
            'required'             => ['name_2', 'name_3'],
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

    public function test_it_validates_success(): void
    {
        $values = [
            'name_1' => 'value',
            'name_2' => false,
            'name_3' => 'a',
            'name_4' => [
                'name_1' => 'value',
                'name_2' => false,
                'name_3' => 'a',
            ],
        ];

        $validator = new Validator($values, $this->schema);
        self::assertTrue($validator->isValid());
        self::assertEquals([], $validator->getErrors());
    }

    public function test_it_validates_failure(): void
    {
        $values = [
            'name_1' => 'value',
            'name_3' => 'a',
            'name_4' => [
                'name_1' => 'value',
                'name_2' => false,
                'name_3' => 'a',
            ],
        ];

        $validator = new Validator($values, $this->schema);
        self::assertFalse($validator->isValid());
        self::assertContains(
            ['The required properties (name_2) are missing'],
            $validator->getErrors()
        );
    }
}
