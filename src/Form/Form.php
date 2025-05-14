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
            '$schema'              => 'http://json-schema.org/draft-04/schema#',
            'additionalProperties' => false,
            'required'             => $this->getRequired(),
            'properties'           => $this->getProperties()->toArray(),
        ];
    }
}
