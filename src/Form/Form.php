<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use ArrayObject;
use Illuminate\Support\Arr;

/**
 * @extends ArrayObject<array-key, FormElement>
 */
class Form extends FormElementCollection
{
    public function __construct(FormElement ...$items)
    {
        parent::__construct($items);
    }

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
