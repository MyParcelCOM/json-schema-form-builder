<?php

declare(strict_types=1);

namespace MyParcelCom\Commons\Configuration\Form;

use Illuminate\Support\Arr;
use MyParcelCom\Integration\Collection;
use MyParcelCom\Integration\Configuration\Field;

/**
 * @extends Collection<array-key, Field>
 */
class Form extends Collection
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
