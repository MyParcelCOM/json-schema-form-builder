<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Validation;

use Opis\JsonSchema\Helper;
use Opis\JsonSchema\ValidationResult;
use Opis\JsonSchema\Validator as JsonSchemaValidator;

class Validator
{
    /**
     * Validate form values against a JSON Schema. Returns a ValidationResult.
     */
    public static function validate(array $values, array $schema): ValidationResult
    {
        $validator = new JsonSchemaValidator();

        return $validator->validate(Helper::toJSON($values), Helper::toJSON($schema));
    }
}
