<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Properties;

use MyParcelCom\JsonSchema\FormBuilder\Form\FieldType;

enum SchemaPropertyType: string
{
    case STRING = 'string';
    case NUMBER = 'number';
    case BOOLEAN = 'boolean';
    case OBJECT = 'object';
    case ARRAY = 'array';
}
