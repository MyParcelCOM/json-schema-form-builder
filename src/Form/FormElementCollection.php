<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use ArrayObject;
use Illuminate\Support\Arr;
use MyParcelCom\JsonSchema\FormBuilder\SchemaProperties\SchemaPropertyCollection;

class FormElementCollection extends ArrayObject
{
    public function __construct(FormElement ...$formElements)
    {
        parent::__construct($formElements);
    }

    public function getProperties(): SchemaPropertyCollection
    {
        $properties = Arr::map(
            (array) $this,
            static fn (FormElement $formElement) => $formElement->toJsonSchemaProperty(),
        );

        return new SchemaPropertyCollection(...$properties);
    }

    /**
     * @return array<string>
     */
    public function getRequired(): array
    {
        $requiredProperties = array_values(
            array_filter(
                (array) $this,
                static fn (FormElement $field) => $field->isRequired,
            ),
        );

        return Arr::map(
            $requiredProperties,
            static fn (FormElement $field) => $field->name,
        );
    }

    public function getValues(): array
    {
        return array_filter(
            Arr::collapse(
                Arr::map(
                    (array) $this,
                    static fn (FormElement $formElement) => [
                        $formElement->name => $formElement->value(),
                    ],
                ),
            ),
        );
    }

    public function getMissingRequiredValues(array $values): array
    {
        return array_filter(
            (array) $this,
            fn ($field) => $field->isRequired && !array_key_exists($field->name, $values),
        );
    }
}
