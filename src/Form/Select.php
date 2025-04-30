<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

class Select extends AbstractChoiceField
{
    protected ChoiceFieldType $fieldType = ChoiceFieldType::SELECT;
}
