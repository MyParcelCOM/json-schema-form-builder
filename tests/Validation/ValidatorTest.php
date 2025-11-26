<?php

declare(strict_types=1);

namespace Tests\Validation;

use MyParcelCom\JsonSchema\FormBuilder\Validation\Exceptions\FormValidationException;
use MyParcelCom\JsonSchema\FormBuilder\Validation\Validator;
use Opis\JsonSchema\Errors\ErrorFormatter;
use PHPUnit\Framework\TestCase;

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
        $validationResult = Validator::validate([
            'name_1' => 'value',
            'name_2' => false,
            'name_3' => 'a',
            'name_4' => [
                'name_1' => 'value',
                'name_2' => false,
                'name_3' => 'a',
            ],
        ], $this->schema);

        $this->assertTrue($validationResult->isValid());
        $this->assertFalse($validationResult->hasError());
        $this->assertNull($validationResult->error());

        $validationResult = Validator::validate([
            'name_1' => 'value',
            'name_2' => false,
            'name_3' => 'a',
        ], $this->schema);

        $this->assertTrue($validationResult->isValid());
        $this->assertFalse($validationResult->hasError());
        $this->assertNull($validationResult->error());
    }

    public function test_it_fails_to_validate_required_missing(): void
    {
        $validationResult = Validator::validate([
            'name_1' => 'value',
            'name_2' => false,
            'name_4' => [
                'name_1' => 'value',
                'name_3' => 'a',
            ],
        ], $this->schema);

        $errors = $this->formatErrorsFromValidationResult($validationResult);

        $this->assertFalse($validationResult->isValid());
        $this->assertContains('The required properties (name_3) are missing', $errors['/']);
    }

    public function test_it_fails_to_validate_wrong_property_type(): void
    {
        $validationResult = Validator::validate([
            'name_1' => 5,
            'name_2' => 'hello',
            'name_3' => 'a',
            'name_4' => [
                'name_1' => 'value',
                'name_3' => 'a',
            ],
        ], $this->schema);

        $errors = $this->formatErrorsFromValidationResult($validationResult);

        $this->assertFalse($validationResult->isValid());
        $this->assertContains('The data (integer) must match the type: string', $errors['/name_1']);
    }

    public function test_it_fails_to_validate_invalid_enum_value(): void
    {
        $validationResult = Validator::validate([
            'name_1' => 'value',
            'name_2' => true,
            'name_3' => 'x',
            'name_4' => [
                'name_1' => 'value',
                'name_2' => true,
                'name_3' => 'y',
            ],
        ], $this->schema);

        $errors = $this->formatErrorsFromValidationResult($validationResult);

        $this->assertFalse($validationResult->isValid());
        $this->assertContains('The data should match one item from enum', $errors['/name_3']);
    }

    /**
     * Helper function to format errors from a ValidationResult as described in opis/json-schema (used in FormValidationException).
     * @param $validationResult
     * @return array
     */
    private function formatErrorsFromValidationResult($validationResult): array
    {
        $errorFormatter ??= new ErrorFormatter();
        return $errorFormatter->format($validationResult->error());
    }
}
