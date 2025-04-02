<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\JsonSchemaProperty;

interface Field
{
    public function toJsonSchemaProperty(): JsonSchemaProperty;
}
