<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use ArrayObject;
use Illuminate\Support\Arr;

/**
 * @extends ArrayObject<array-key, FormElement>
 */
class Form extends ArrayObject
{
    public function __construct(FormElement ...$items)
    {
        parent::__construct($items);
    }

    public function getProperties(): array
    {
        return Arr::collapse(
            Arr::map(
                (array) $this,
                static fn (FormElement $field) => $field->toJsonSchemaProperty()->toArray(),
            ),
        );
    }

    public function getRequired(): array
    {
        $requiredProperties = array_filter(
            (array) $this,
            static fn (FormElement $field) => $field->toJsonSchemaProperty()->isRequired,
        );

        return array_values(
            Arr::map(
                $requiredProperties,
                static fn (FormElement $field) => $field->name,
            ),
        );
    }

    public function toJsonSchema(): array
    {
        return [
            '$schema'              => 'http://json-schema.org/draft-04/schema#',
            'additionalProperties' => false,
            'required'             => $this->getRequired(),
            'properties'           => $this->getProperties(),
        ];
    }
}
