<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;
use Override;

class RadioButtons extends ChoiceField
{
    #[Override]
    protected function fieldType(): MetaFieldType
    {
        return MetaFieldType::RADIO;
    }
}
