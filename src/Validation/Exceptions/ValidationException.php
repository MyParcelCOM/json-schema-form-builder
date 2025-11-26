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
class ValidationException extends Exception
{
    private array $errors;
    public function __construct(
        ValidationResult $validationResult,
        string $message = 'Form validation failed',
        ?ErrorFormatter $errorFormatter = null,
    ) {
        parent::__construct(message: $message);
        $errorFormatter ??= new ErrorFormatter();
        $this->errors = $errorFormatter->format($validationResult->error());
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
