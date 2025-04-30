<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Translations;

class LabelTranslation
{
    public function __construct(
      public Locale $locale,
      public string $label,
    ) {
    }
}
