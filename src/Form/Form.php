<?php

declare(strict_types=1);

namespace MyParcelCom\Integration\Configuration\Form;

use Illuminate\Support\Arr;
use MyParcelCom\Integration\Configuration\Values\ValueCollection;

/**
 * @extends ValueCollection<array-key, Field>
 */
class Form extends ValueCollection
{
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
