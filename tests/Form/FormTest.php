<?php

declare(strict_types=1);

namespace Tests\Form;

use MyParcelCom\JsonSchema\FormBuilder\Form\Checkbox;
use MyParcelCom\JsonSchema\FormBuilder\Form\Exceptions\FormValidationException;
use MyParcelCom\JsonSchema\FormBuilder\Form\Form;
use MyParcelCom\JsonSchema\FormBuilder\Form\FormElementCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\Group;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\RadioButtons;
use MyParcelCom\JsonSchema\FormBuilder\Form\Text;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class FormTest extends TestCase
{
    protected Form $form;
    protected Form $nestedForm;

    protected function setUp(): void
    {
        parent::setUp();

        $propertyOne = new Text(
            name: 'name_1',
            label: 'Label 1',
        );
        $propertyTwo = new Checkbox(
            name: 'name_2',
            label: 'Label 2',
            isRequired: true,
            help: 'Assistance is required',
        );
        $propertyThree = new RadioButtons(
            name: 'name_3',
            label: 'Label 3',
            options: new OptionCollection(
                new Option('a', 'A'),
                new Option('b', 'B'),
            ),
            isRequired: true,
            help: 'This field has no purpose',

        );
        $this->form = new Form(
            $propertyOne,
            $propertyTwo,
            $propertyThree,
            new Group(
                name: 'name_4',
                label: 'Label 4',
                children: new FormElementCollection(
                    $propertyOne,
                    $propertyTwo,
                    $propertyThree,
                ),
            ),
        );
    }

    public function test_it_gets_required(): void
    {
        assertEquals(['name_2', 'name_3'], $this->form->getRequired());
    }

    public function test_it_gets_properties(): void
    {
        assertEquals([
            'name_1' => [
                'type'        => 'string',
                'description' => 'Label 1',
            ],
            'name_2' => [
                'type'        => 'boolean',
                'description' => 'Label 2',
                'meta'        => [
                    'help' => 'Assistance is required',
                ],
            ],
            'name_3' => [
                'type'        => 'string',
                'description' => 'Label 3',
                'enum'        => ['a', 'b',],
                'meta'        => [
                    'field_type'  => 'radio',
                    'help'        => 'This field has no purpose',
                    'enum_labels' => [
                        'a' => 'A',
                        'b' => 'B',
                    ],
                ],
            ],
            'name_4' => [
                'type'        => 'object',
                'description' => 'Label 4',
                'required'    => [
                    'name_2',
                    'name_3',
                ],
                'properties'  => [
                    'name_1' => [
                        'type'        => 'string',
                        'description' => 'Label 1',
                    ],
                    'name_2' => [
                        'type'        => 'boolean',
                        'description' => 'Label 2',
                        'meta'        => [
                            'help' => 'Assistance is required',
                        ],
                    ],
                    'name_3' => [
                        'type'        => 'string',
                        'description' => 'Label 3',
                        'enum'        => ['a', 'b',],
                        'meta'        => [
                            'field_type'  => 'radio',
                            'help'        => 'This field has no purpose',
                            'enum_labels' => [
                                'a' => 'A',
                                'b' => 'B',
                            ],
                        ],
                    ],
                ],
            ],
        ], $this->form->getProperties()->toArray());
    }

    public function test_it_converts_to_json_schema(): void
    {
        assertEquals([
            '$schema'              => 'https://json-schema.org/draft/2020-12/schema',
            'type'                 => 'object',
            'additionalProperties' => false,
            'required'             => ['name_2', 'name_3'],
            'properties'           => [
                'name_1' => [
                    'type'        => 'string',
                    'description' => 'Label 1',
                ],
                'name_2' => [
                    'type'        => 'boolean',
                    'description' => 'Label 2',
                    'meta'        => [
                        'help' => 'Assistance is required',
                    ],
                ],
                'name_3' => [
                    'type'        => 'string',
                    'description' => 'Label 3',
                    'enum'        => ['a', 'b',],
                    'meta'        => [
                        'field_type'  => 'radio',
                        'help'        => 'This field has no purpose',
                        'enum_labels' => [
                            'a' => 'A',
                            'b' => 'B',
                        ],
                    ],
                ],
                'name_4' => [
                    'type'        => 'object',
                    'description' => 'Label 4',
                    'required'    => [
                        'name_2',
                        'name_3',
                    ],
                    'properties'  => [
                        'name_1' => [
                            'type'        => 'string',
                            'description' => 'Label 1',
                        ],
                        'name_2' => [
                            'type'        => 'boolean',
                            'description' => 'Label 2',
                            'meta'        => [
                                'help' => 'Assistance is required',
                            ],
                        ],
                        'name_3' => [
                            'type'        => 'string',
                            'description' => 'Label 3',
                            'enum'        => ['a', 'b',],
                            'meta'        => [
                                'field_type'  => 'radio',
                                'help'        => 'This field has no purpose',
                                'enum_labels' => [
                                    'a' => 'A',
                                    'b' => 'B',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ], $this->form->toJsonSchema());
    }

    public function test_it_gets_values(): void
    {
        $text = new Text(
            name: '1001',
            label: 'Label 1',
            value: 'Initial text',
        );
        $checkbox = new Checkbox(
            name: '1002',
            label: 'Label 2',
            value: true,
        );
        $radioButtons = new RadioButtons(
            name: 'name_3',
            label: 'Label 3',
            options: new OptionCollection(
                new Option('a', 'A'),
                new Option('b', 'B'),
            ),
        );
        $group = new Group(
            name: 'name_4',
            label: 'Group',
            children: new FormElementCollection(
                $text,
                $checkbox,
                $radioButtons,
            ),
        );
        $form = new Form(
            $text,
            $checkbox,
            $radioButtons,
            $group,
        );

        assertEquals([
            1001 => 'Initial text',
            1002 => true,
            'name_4' => [
                1001 => 'Initial text',
                1002 => true,
            ],
        ], $form->getValues());
    }

    /**
     * @throws FormValidationException
     */
    public function test_it_validates(): void
    {
        $this->expectNotToPerformAssertions();
        $this->form->validate([
            'name_1' => 'value',
            'name_2' => false,
            'name_3' => 'a',
            'name_4' => [
                'name_1' => 'value',
                'name_2' => false,
                'name_3' => 'a',
            ],
        ]);

        $this->form->validate([
            'name_1' => 'value',
            'name_2' => false,
            'name_3' => 'a',
        ]);
    }

    public function test_it_fails_to_validate_required_missing(): void
    {
        $this->expectException(FormValidationException::class);
        $this->form->validate([
            'name_1' => 'value',
            'name_2' => false,
            'name_4' => [
                'name_1' => 'value',
                'name_3' => 'a',
            ],
        ]);
    }

    public function test_it_fails_to_validate_wrong_property_type(): void
    {
        $this->expectException(FormValidationException::class);
        $this->form->validate([
            'name_1' => 5,
            'name_2' => 'hello',
            'name_3' => 'a',
            'name_4' => [
                'name_1' => 'value',
                'name_3' => 'a',
            ],
        ]);
    }

    public function test_it_fails_to_validate_invalid_enum_value(): void
    {
        $this->expectException(FormValidationException::class);
        $this->form->validate([
            'name_1' => 'value',
            'name_2' => true,
            'name_3' => 'x',
            'name_4' => [
                'name_1' => 'value',
                'name_2' => true,
                'name_3' => 'y',
            ],
        ]);
    }
}
