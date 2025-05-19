<?php

declare(strict_types=1);

namespace Tests\Form\Exceptions;

use MyParcelCom\JsonSchema\FormBuilder\Form\Exceptions\FormValidationException;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class FormValidationExceptionTest extends TestCase
{
    public function test_it_renders(): void
    {
        $exception = new FormValidationException(
            message: 'Form validation failed',
            errors: [
                [
                    'property' => 'foo.bar',
                    'message'  => 'Foo is required',
                ],
                [
                    'property' => 'bar.foo',
                    'message'  => 'Bar is required',
                ],
            ],
        );

        $response = $exception->render();

        assertEquals(422, $response->getStatusCode());
        assertEquals($response->getData(true), [
            'message' => 'Form validation failed',
            'errors'  => [
                'foo.bar' => 'Foo is required',
                'bar.foo' => 'Bar is required',
            ],
        ]);
    }
}
