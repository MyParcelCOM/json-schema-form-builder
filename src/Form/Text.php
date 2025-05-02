<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

class Text extends AbstractField
{
    protected FieldType $fieldType = FieldType::STRING;
}
