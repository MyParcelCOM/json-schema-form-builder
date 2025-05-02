# Json Schema Form Builder
This library provides an object-oriented API for constructing forms, which can be converted into a JSON Schema. 

This package includes:
- Classes that can be used to outline simple forms.
- Functionality to render these forms into JSON Schema.
- Support for translations of form elements and options.
- Defining corresponding values for form elements.

## PHP 8
The minimum PHP version is `8.4`. To update dependencies on a system without PHP 8 use:
```shell
docker run --rm --mount type=bind,source="$(pwd)",target=/app composer:2 composer update
```

## Run tests
You can run the test through docker:
```shell
docker run -v $(pwd):/app --rm -w /app php:8.4-cli vendor/bin/phpunit
```

## Usage
The following describes how to use this library, this includes:
1. Constructing forms and rendering them as a JSON Schema using the `Form` class.
2. Associating a form with values by Creating a `ValueCollection`.
3. Add translations to form element labels and option labels (if applicable).

#### Example: Creating a Form and Converting it to a JSON Schema
```php
use MyParcelCom\JsonSchema\FormBuilder\Form\Form;
use MyParcelCom\JsonSchema\FormBuilder\Form\Select;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;

$textField = new Text(
    name: 'example_text',
    label: 'Example Text Field',
    isRequired: true,
    help: 'Please enter some text.',
    placeholder: 'Enter text here'
);

$checkboxField = new Checkbox(
    name: 'example_checkbox',
    label: 'Example Checkbox Field',
    help: 'Check this box if applicable.'
);

$selectField = new Select(
    name: 'example_select',
    label: 'Example Select Field',
    options: new OptionCollection(
    new Option('option_1_key', 'Option 1 Label'),
    new Option('option_2_key', 'Option 2 Label')
),
    isRequired: true,
    help: 'Please select an option.',
    isMultiSelect: false
);

$form = new Form($textField, $checkboxField, $selectField);
$form->toJsonSchema();
```
The resulting JSON Schema will look as follows:
```json
{
  "$schema": "http://json-schema.org/draft-04/schema#",
  "additionalProperties": false,
  "required": ["example_text", "example_select"],
  "properties": {
    "example_text": {
      "type": "string",
      "description": "Example Text Field",
      "meta": {
        "help": "Please enter some text."
      }
    },
    "example_checkbox": {
      "type": "boolean",
      "description": "Example Checkbox Field",
        "meta": {
            "help": "Check this box if applicable."
        }
    },
    "example_select": {
      "type": "string",
      "description": "Example Select Field",
      "enum": ["option_1_key", "option_2_key"],
      "meta": {
        "help": "Please select an option.",
        "enum_labels": {
          "option_1_key": "Option 1 Label",
          "option_2_key": "Option 2 Label"
        }
      }
    }
  }
}
```
