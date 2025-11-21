<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Validation;

use MyParcelCom\JsonSchema\FormBuilder\Validation\Exceptions\ValidationException;
use Opis\JsonSchema\Helper;
use Opis\JsonSchema\Validator as JsonSchemaValidator;

class Validator
{
    /**
     * Validate form values against a JSON Schema
     * @throws ValidationException
     */
    public static function validate(array $values, array $schema): void
    {
        $validator = new JsonSchemaValidator();
        $result = $validator->validate(Helper::toJSON($values), Helper::toJSON($schema));
        if (!$result->isValid()) {
            throw new ValidationException($result);
        }
    }
}
