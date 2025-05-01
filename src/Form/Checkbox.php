<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Properties\JsonSchemaProperty;
use MyParcelCom\JsonSchema\FormBuilder\Properties\PropertyType;

class Checkbox extends AbstractField
{
   protected PropertyType $propertyType = PropertyType::BOOLEAN;
}
