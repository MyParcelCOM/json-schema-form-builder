<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use ArrayObject;

class FormElementCollection extends ArrayObject
{
    public function __construct(FormElement ...$formElements) {
        parent::__construct($formElements);
    }
}
