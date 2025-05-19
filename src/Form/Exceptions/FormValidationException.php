<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Throwable;

class FormValidationException extends Exception
{
    public function __construct(
        string $message = 'Form validation failed',
        private readonly array $errors = [],
        ?Throwable $previous = null,
    ) {
        parent::__construct(message: $message, previous: $previous);
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
        $errorMapping = Arr::collapse(array_map(
            fn ($error) => [
                $error['property'] => $error['message'],
            ],
            $this->errors,
        ));
        return new JsonResponse([
            'message' => $this->getMessage(),
            'errors' => $errorMapping,
        ], 422);
    }

    /**
     * Get the list of property-to-error mappings.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}
