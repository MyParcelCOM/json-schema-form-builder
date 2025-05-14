<?php

declare(strict_types=1);

namespace MyParcelCom\JsonSchema\FormBuilder\Translations;

/**
 * Enum representing the locales supported by MyParcelCom.
 */
enum Locale: string
{
    case DE_DE = 'de-DE';
    case EL_GR = 'el-GR';
    case EN_GB = 'en-GB';
    case ES_ES = 'es-ES';
    case FR_FR = 'fr-FR';
    case IT_IT = 'it-IT';
    case NL_NL = 'nl-NL';
    case PL_PL = 'pl-PL';
    case PT_PT = 'pt-PT';
}
