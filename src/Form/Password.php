<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

class Password extends AbstractField
{
    protected FieldType $fieldType = FieldType::STRING;
    protected bool $isPassword = true;
}
