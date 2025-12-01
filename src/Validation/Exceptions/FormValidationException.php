<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Validation\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\ValidationResult;

/**
 * Exception thrown when form validation fails.
 */
class FormValidationException extends Exception
{
    public function __construct(
        string $message = 'Form validation failed',
        private readonly ?array $errors = null,
    ) {
        parent::__construct($message);
    }

    /**
     * Prevent the exception from being reported.
     */
    public function report(): bool
    {
        return false;
    }

    public function render(): JsonResponse
    {
        return new JsonResponse(array_filter([
            'message' => $this->getMessage(),
            'errors' => $this->errors,
        ]), 422);
    }

    /**
     * Get the list of property-to-error mappings.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}
