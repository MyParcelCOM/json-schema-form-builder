<?php

declare(strict_types=1);

namespace Tests\Form;

use Faker\Factory;
use Faker\Generator;
use MyParcelCom\JsonSchema\FormBuilder\Form\Checkbox;
use MyParcelCom\JsonSchema\FormBuilder\Form\Form;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\RadioButtons;
use MyParcelCom\JsonSchema\FormBuilder\Form\Text;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class FormTest extends TestCase
{
    protected Form $form;
    protected function setUp(): void
    {
        parent::setUp();
        $faker = Factory::create();

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
            isRequired: false,
            help: 'This field has no purpose',

        );

        $this->form = new Form($propertyOne, $propertyTwo, $propertyThree);
    }

    public function test_it_gets_required(): void
    {
        assertEquals(['name_2'], $this->form->getRequired());
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
                'meta' => [
                    'help' => 'Assistance is required',
                ],
            ],
            'name_3' => [
                'type'        => 'string',
                'description' => 'Label 3',
                'enum'       => ['a', 'b',],
                'meta' => [
                    'field_type' => 'radio',
                    'help' => 'This field has no purpose',
                    'enum_labels' => [
                        'a' => 'A',
                        'b' => 'B',
                    ],
                ],
            ]
        ], $this->form->getProperties());
    }

    public function test_it_converts_to_json_schema(): void
    {
        assertEquals([
            '$schema'              => 'http://json-schema.org/draft-04/schema#',
            'additionalProperties' => false,
            'required'             => ['name_2'],
            'properties'           => [
                'name_1' => [
                    'type'        => 'string',
                    'description' => 'Label 1',
                ],
                'name_2' => [
                    'type'        => 'boolean',
                    'description' => 'Label 2',
                    'meta' => [
                        'help' => 'Assistance is required',
                    ],
                ],
                'name_3' => [
                    'type'        => 'string',
                    'description' => 'Label 3',
                    'enum'       => ['a', 'b',],
                    'meta' => [
                        'field_type' => 'radio',
                        'help' => 'This field has no purpose',
                        'enum_labels' => [
                            'a' => 'A',
                            'b' => 'B',
                        ],
                    ],
                ]
            ]
        ], $this->form->toJsonSchema());
    }
}
