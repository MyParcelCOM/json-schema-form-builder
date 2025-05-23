<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use ArrayObject;

class OptionCollection extends ArrayObject
{
    public function __construct(Option ...$items)
    {
        parent::__construct($items);
    }

    public function getKeys(): array
    {
        return array_map(fn (Option $entry) => $entry->key, (array) $this);
    }

    public function getLabels(): array
    {
        $labelMapping = [];
        /** @var Option $option */
        foreach ($this as $option) {
            $labelMapping[$option->key] = $option->label;
        }

        return array_filter($labelMapping);
    }

    public function getLabelTranslations(): array|null
    {
        $labelTranslations = [];
        /** @var Option $option */
        foreach ($this as $option) {
            if (!$option->labelTranslations) {
                continue;
            }
            foreach ($option->labelTranslations as $translation) {
                $labelTranslations[$option->key][$translation->locale->value] = $translation->label;
            }
        }

        return empty($labelTranslations) ? null : $labelTranslations;
    }
}
