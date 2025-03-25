<?php

declare(strict_types=1);

namespace MyParcelCom\Commons\Configuration\Properties;

enum PropertyType: string
{
    case STRING = 'string';
    case NUMBER = 'number';
    case BOOLEAN = 'boolean';
}
