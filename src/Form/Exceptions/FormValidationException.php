<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form\Exceptions;

use Exception;
use Throwable;

class FormValidationException extends Exception
{
    public function __construct(
        string $message = 'Form validation failed',
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
