<?php

declare(strict_types=1);

namespace Tests\Form;

use MyParcelCom\JsonSchema\FormBuilder\Form\Checkbox;
use MyParcelCom\JsonSchema\FormBuilder\Form\FormElementCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\Group;
use MyParcelCom\JsonSchema\FormBuilder\Form\Number;
use MyParcelCom\JsonSchema\FormBuilder\Form\Text;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslation;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\Locale;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class GroupTest extends TestCase
{
    public function test_it_converts_into_an_array_with_translations(): void
    {
        $group = new Group(
            name: 'test_group',
            label: 'Test Group',
            children: new FormElementCollection(
                new Text('name_1', 'Label 1'),
                new Checkbox('name_2', 'Label 2'),
            ),
            help: 'Test help',
            labelTranslations: new LabelTranslationCollection(
                new LabelTranslation(Locale::NL_NL, 'Test Groep'),
                new LabelTranslation(Locale::DE_DE, 'Test Gruppe'),
            ),
        );

        assertEquals([
            'test_group' => [
                'type'        => 'object',
                'description' => 'Test Group',
                'properties'  => [
                    'name_1' => [
                        'type'        => 'string',
                        'description' => 'Label 1',
                    ],
                    'name_2' => [
                        'type'        => 'boolean',
                        'description' => 'Label 2',
                    ],
                ],
                'meta'        => [
                    'label_translations' => [
                        'nl-NL' => 'Test Groep',
                        'de-DE' => 'Test Gruppe',
                    ],
                    'help'               => 'Test help',
                ],
            ],
        ], $group->toJsonSchemaProperty()->toArray());
    }

    public function test_it_converts_into_an_array_with_required(): void
    {
        $group = new Group(
            name: 'test_group',
            label: 'Test Group',
            children: new FormElementCollection(
                new Text('name_1', 'Label 1', isRequired: true),
                new Checkbox('name_2', 'Label 2'),
            ),
            help: 'Test help',
        );

        assertEquals([
            'test_group' => [
                'type'        => 'object',
                'description' => 'Test Group',
                'properties'  => [
                    'name_1' => [
                        'type'        => 'string',
                        'description' => 'Label 1',
                    ],
                    'name_2' => [
                        'type'        => 'boolean',
                        'description' => 'Label 2',
                    ],
                ],
                'required'    => ['name_1'],
                'meta'        => [
                    'help' => 'Test help',
                ],
            ],
        ], $group->toJsonSchemaProperty()->toArray());

    }

    public function test_it_converts_into_an_array_nested_group(): void
    {
        $group = new Group(
            name: 'test_group',
            label: 'Test Group',
            children: new FormElementCollection(
                new Text('name_1', 'Label 1'),
                new Checkbox('name_2', 'Label 2'),
                new Group(
                    name: 'nested_group',
                    label: 'Nested Group',
                    children: new FormElementCollection(
                        new Text('name_3', 'Label 3'),
                        new Number('name_4', 'Label 4'),
                    ),
                ),
            ),
            help: 'Test help',
        );

        assertEquals([
            'test_group' => [
                'type'        => 'object',
                'description' => 'Test Group',
                'properties'  => [
                    'name_1'       => [
                        'type'        => 'string',
                        'description' => 'Label 1',
                    ],
                    'name_2'       => [
                        'type'        => 'boolean',
                        'description' => 'Label 2',
                    ],
                    'nested_group' => [
                        'type'        => 'object',
                        'description' => 'Nested Group',
                        'properties'  => [
                            'name_3' => [
                                'type'        => 'string',
                                'description' => 'Label 3',
                            ],
                            'name_4' => [
                                'type'        => 'number',
                                'description' => 'Label 4',
                            ],
                        ],
                    ],
                ],
                'meta'        => [
                    'help' => 'Test help',
                ],
            ],
        ], $group->toJsonSchemaProperty()->toArray());
    }
}
