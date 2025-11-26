<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use ArrayObject;
use MyParcelCom\JsonSchema\FormBuilder\Validation\Exceptions\ValidationException;
use MyParcelCom\JsonSchema\FormBuilder\Validation\Validator;

/**
 * @extends ArrayObject<array-key, FormElement>
 */
class Form extends FormElementCollection
{
    public function toJsonSchema(): array
    {
        return [
            '$schema'              => 'https://json-schema.org/draft/2020-12/schema',
            'type'                 => 'object',
            'additionalProperties' => false,
            'required'             => $this->getRequired(),
            'properties'           => $this->getProperties()->toArray(),
        ];
    }

    /**
     * Validate form values against the JSON Schema form
     * @param array<string, mixed> $values a key value array of form values
     * @throws ValidationException
     */
    public function validate(array $values): void
    {
        $result = Validator::validate($values, $this->toJsonSchema());
        if(!$result->isValid()) {
            throw new ValidationException($result);
        }
    }
}
