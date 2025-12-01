<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Validation;

use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Helper;
use Opis\JsonSchema\ValidationResult;
use Opis\JsonSchema\Validator as JsonSchemaValidator;

class Validator
{
    public function __construct(
        private readonly array $values,
        private readonly array $schema,
    ) {
    }

    /**
     * Validate the form values against the JSON Schema. Returns a ValidationResult.
     */
    public function isValid(): bool
    {
        return $this->getValidationResult()->isValid();
    }
    public function getErrors(): array
    {
        return $this->getValidationResult()->hasError()
            ? new ErrorFormatter()->format($this->getValidationResult()->error())
            : [];
    }

    private function getValidationResult(): ValidationResult
    {
        $validator = new JsonSchemaValidator();

        return $validator->validate(Helper::toJSON($this->values), Helper::toJSON($this->schema));
    }
}
