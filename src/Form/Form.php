<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use ArrayObject;
use Illuminate\Support\Arr;

/**
 *  @extends ArrayObject<array-key, Field>
 */
class Form extends ArrayObject
{
    public function __construct(...$items)
    {
        parent::__construct($items);
    }
    public function toArray(): array
    {
        return Arr::map(
            (array) $this,
            static fn (Field $field) => $field->toJsonSchemaProperty()->toArray(),
        );
    }

    public function getRequired(): array
    {
        $requiredProperties = array_filter(
            (array) $this,
            static fn (Field $field) => $field->toJsonSchemaProperty()->isRequired,
        );

        return array_values(
            Arr::map(
                $requiredProperties,
                static fn (Field $field) => $field->name,
            ),
        );
    }
}
