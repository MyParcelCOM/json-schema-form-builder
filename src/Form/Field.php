<?php

declare(strict_types=1);

namespace MyParcelCom\Integration\Configuration\Form;

use MyParcelCom\Integration\Configuration\Properties\JsonSchemaProperty;

interface Field
{
    public function toJsonSchemaProperty(): JsonSchemaProperty;
}
