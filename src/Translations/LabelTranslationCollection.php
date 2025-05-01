<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Translations;

use ArrayObject;

class LabelTranslationCollection extends ArrayObject
{
    public function __construct(LabelTranslation ...$labelTranslations) {
        parent::__construct($labelTranslations);
    }
    public function toArray(): array
    {
        $labelTranslations = [];
        foreach ($this as $translation) {
            $labelTranslations[$translation->locale->value] = $translation->label;
        }
        return $labelTranslations;
    }
}
