<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

class RadioButtons extends AbstractChoiceField
{
    protected ChoiceFieldType $fieldType = ChoiceFieldType::RADIO;
}
