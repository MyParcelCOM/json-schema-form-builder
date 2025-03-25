<?php

declare(strict_types=1);

namespace MyParcelCom\Commons\Configuration\Form;

use MyParcelCom\Commons\Configuration\Properties\JsonSchemaProperty;

interface Field
{
    public function toJsonSchemaProperty(): JsonSchemaProperty;
}
