<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;

class RadioButtons extends ChoiceField
{
    protected function fieldType(): MetaFieldType
    {
        return MetaFieldType::RADIO;
    }
}
