<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

class Option
{
    public function __construct(
        public string $key,
        public string $label,
        public ?LabelTranslationCollection $labelTranslations = null,
    ) {
    }
}
