<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use ArrayObject;
use Illuminate\Support\Arr;

class FormElementCollection extends ArrayObject
{
    public function __construct(FormElement ...$formElements) {
        parent::__construct($formElements);
    }
    public function toArray(): array
    {
        return Arr::collapse(array_map(
            fn (FormElement $el) => $el->toJsonSchemaProperty()->toArray(),
            $this->getArrayCopy()
        ));
    }
}
