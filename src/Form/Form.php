<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use ArrayObject;
use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;
use MyParcelCom\JsonSchema\FormBuilder\Form\Exceptions\FormValidationException;

/**
 * @extends ArrayObject<array-key, FormElement>
 */
class Form extends FormElementCollection
{
    public function toJsonSchema(): array
    {
        return [
            '$schema'              => 'https://json-schema.org/draft/2020-12/schema',
            'additionalProperties' => false,
            'required'             => $this->getRequired(),
            'properties'           => $this->getProperties()->toArray(),
        ];
    }

    /**
     * Validate form values against the JSON Schema form
     * @param array<string, mixed> $values a key value array of form values
     * @throws FormValidationException
     */
    public function validate(array $values): void
    {
        /**
         * CHECK_MODE_TYPE_CAST: Enable fuzzy type checking for associative arrays and objects
         * src: https://github.com/jsonrainbow/json-schema?tab=readme-ov-file#configuration-options
         **/
        $validator = new Validator;
        $validator->validate($values, $this->toJsonSchema(), Constraint::CHECK_MODE_TYPE_CAST);
        if (!$validator->isValid()) {
            $errorMessages = array_map(
                fn ($error) => "[{$error['property']}] {$error['message']}",
                $validator->getErrors(),
            );
            throw new FormValidationException("Form validation failed", $validator->getErrors());
        }
    }
}
