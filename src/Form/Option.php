<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Form;

use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslation;

class Option
{
    /**
     * @param array<LabelTranslation>|null $labelTranslations
     */
    public function __construct(
        public int|string $key,
        public ?string $label = null,
        public ?array $labelTranslations = null,
    ) {
    }
}
