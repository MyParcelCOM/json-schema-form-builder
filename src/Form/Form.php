<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use ArrayObject;

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

    public function validate(): void
    {
        // TODO: Use 3rd party library for validation of the schema + update the $schema to latest draft version
    }
}
