<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Validation;

use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Helper;
use Opis\JsonSchema\ValidationResult;
use Opis\JsonSchema\Validator as JsonSchemaValidator;

class Validator
{
    private ValidationResult $validationResult;
    public function __construct(
        private readonly array $values,
        private readonly array $schema,
    ) {
        $jsonSchemaValidator = new JsonSchemaValidator();
        $this->validationResult = $jsonSchemaValidator->validate(Helper::toJSON($this->values), Helper::toJSON($this->schema));
    }

    /**
     * Validates the form values against the JSON Schema.
     */
    public function isValid(): bool
    {
        return $this->validationResult->isValid();
    }
    public function getErrors(): array
    {
        return $this->validationResult->hasError()
            ? new ErrorFormatter()->format($this->validationResult->error())
            : [];
    }
}
