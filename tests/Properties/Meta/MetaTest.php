<?php

declare(strict_types=1);

namespace Tests\Properties\Meta;

use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\Meta;
use MyParcelCom\JsonSchema\FormBuilder\Properties\Meta\MetaFieldType;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class MetaTest extends TestCase
{
    public function test_it_converts_into_an_array(): void
    {
        $meta = new Meta(
            help: 'Help text',
            password: true,
            fieldType: MetaFieldType::RADIO,
            labelTranslations: [
                'nl-NL' => 'Label NL',
                'de-DE' => 'Label DE',
            ],
            enumLabels: [
                'value_1' => 'Label 1',
                'value_2' => 'Label 2',
            ],
            enumLabelTranslations: [
                'value_1' => [
                    'nl-NL' => 'Label 1 NL',
                    'de-DE' => 'Label 1 DE',
                ],
                'value_2' => [
                    'nl-NL' => 'Label 2 NL',
                    'de-DE' => 'Label 2 DE',
                ],
            ]
        );

        assertEquals([
            'help'                    => 'Help text',
            'password'                => true,
            'field_type'              => 'radio',
            'label_translations'      => [
                'nl-NL' => 'Label NL',
                'de-DE' => 'Label DE',
            ],
            'enum_labels'             => [
                'value_1' => 'Label 1',
                'value_2' => 'Label 2',
            ],
            'enum_label_translations' => [
                'value_1' => [
                    'nl-NL' => 'Label 1 NL',
                    'de-DE' => 'Label 1 DE',
                ],
                'value_2' => [
                    'nl-NL' => 'Label 2 NL',
                    'de-DE' => 'Label 2 DE',
                ],
            ],
        ], $meta->toArray());
    }
}
