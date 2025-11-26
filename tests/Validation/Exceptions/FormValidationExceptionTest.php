<?php

declare(strict_types=1);

namespace Tests\Validation\Exceptions;

use Mockery;
use MyParcelCom\JsonSchema\FormBuilder\Validation\Exceptions\FormValidationException;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Errors\ValidationError;
use Opis\JsonSchema\ValidationResult;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class FormValidationExceptionTest extends TestCase
{
    public function test_it_renders(): void
    {
        $resultMock = Mockery::mock(ValidationResult::class);
        $errorMock = Mockery::mock(ValidationError::class);
        $errorFormatterMock = Mockery::mock(ErrorFormatter::class);

        $resultMock->expects('error')->andReturn($errorMock);

        $errorFormatterMock->expects('format')->with($errorMock)->andReturn(['foo.bar' => 'Foo is required', 'bar.foo' => 'Bar is required']);

        $exception = new FormValidationException($resultMock, 'What a failure', $errorFormatterMock);

        $response = $exception->render();

        assertEquals(422, $response->getStatusCode());
        assertEquals($response->getData(true), [
            'message' => 'What a failure',
            'errors'  => [
                'foo.bar' => 'Foo is required',
                'bar.foo' => 'Bar is required',
            ],
        ]);
    }
}
