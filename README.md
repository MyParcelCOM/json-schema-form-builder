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

The following describes how to use this library. The following functionalities are available:

1. Constructing forms and rendering them as a JSON Schema.
2. Creating simple fields such as `Text`, `Number` and `Checkbox`.
3. Creating choice fields such as `Select`, `Radio` and `MultiSelect`.
4. Adding translations to form elements using the `LabelTranslationCollection` class. This includes:
    - Field label translations (for all fields).
    - Option labels (for fields with a finite set of options such as `Select` and `Radio`).
5. Grouping form elements into sections using the `Group` class.
6. Defining values for form fields using the `ValueCollection` class.

NOTE: As the following examples show, all fields that are not part of the JSON Schema specification are stored as `meta`
fields.

#### Example: Constructing a Form with some elements and Converting it to a JSON Schema

```php
use MyParcelCom\JsonSchema\FormBuilder\Form\Form;
use MyParcelCom\JsonSchema\FormBuilder\Form\Text;
use MyParcelCom\JsonSchema\FormBuilder\Form\Select;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;

$textField = new Text(
    name: 'example_text',
    label: 'Example Text Field',
    isRequired: true,
    help: 'Please enter some text.',
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
);

$form = new Form($textField, $checkboxField, $selectField);
$form->toJsonSchema();
```

The resulting JSON Schema will look as follows:

```json
{
  "$schema": "http://json-schema.org/draft-04/schema#",
  "additionalProperties": false,
  "required": [
    "example_text",
    "example_select"
  ],
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
      "enum": [
        "option_1_key",
        "option_2_key"
      ],
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

#### Example: Adding translations to a form element

```php
use MyParcelCom\JsonSchema\FormBuilder\Form\Text;
use MyParcelCom\JsonSchema\FormBuilder\Form\Checkbox;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslation;
use MyParcelCom\JsonSchema\FormBuilder\Translations\Locale

$textField = new Text(
    name: 'example_text',
    label: 'Example Text Field',
    help: 'Please enter some text.',
    labelTranslations: new LabelTranslationCollection(
        new LabelTranslation(Locale::DE_DE, 'Beispiel Textfeld'),
        new LabelTranslation(Locale::EL_GR, 'Παράδειγμα πεδίου κειμένου'),
        new LabelTranslation(Locale::EN_GB, 'Example Text Field'),
        new LabelTranslation(Locale::ES_ES, 'Campo de texto de ejemplo'),
        new LabelTranslation(Locale::FR_FR, 'Champ de texte exemple')
        new LabelTranslation(Locale::IT_IT, 'Campo di testo di esempio'),
        new LabelTranslation(Locale::NL_NL, 'Voorbeeld tekstveld'),
        new LabelTranslation(Locale::PL_PL, 'Przykładowe pole tekstowe'),
        new LabelTranslation(Locale::PT_PT, 'Campo de texto de exemplo'),
    )
);
```

The resulting JSON Schema property will look as follows:

```json
{
  "example_text": {
    "type": "string",
    "description": "Example Text Field",
    "meta": {
      "help": "Please enter some text.",
      "label_translations": {
        "de-DE": "Beispiel Textfeld",
        "el-GR": "Παράδειγμα πεδίου κειμένου",
        "en-GB": "Example Text Field",
        "es-ES": "Campo de texto de ejemplo",
        "fr-FR": "Champ de texte exemple",
        "it-IT": "Campo di testo di esempio",
        "nl-NL": "Voorbeeld tekstveld",
        "pl-PL": "Przykładowe pole tekstowe",
        "pt-PT": "Campo de texto de exemplo"
      }
    }
  }
}
```

#### Example: Adding Option translations to a Form Element

```php
use MyParcelCom\JsonSchema\FormBuilder\Form\RadioButtons;
use MyParcelCom\JsonSchema\FormBuilder\Form\OptionCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\Option;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslation;

$radioField = new RadioButtons(
    name: 'example_radio',
    label: 'Example Radio Field',
    labelTranslations: new LabelTranslationCollection(
        new LabelTranslation(
            locale: Locale::DE_DE,
            label: 'Beispiel Radiofeld'
        ),
        new LabelTranslation(
            locale: Locale::EL_GR,
            label: 'Παράδειγμα πεδίου ραδιοφώνου'
        ),
        new LabelTranslation(
            locale: Locale::EN_GB,
            label: 'Example Radio Field'
        ),
        // ...
    )
    options: new OptionCollection(
        new Option(
            key: 'option_1_key',
            label: 'Option 1 Label',
            labelTranslations: new LabelTranslationCollection(
                new LabelTranslation(
                    locale: Locale::DE_DE,
                    label: 'Option 1 Beschriftung'
                ),
                new LabelTranslation(
                    locale: Locale::EL_GR,
                    label: 'Επιλογή 1 Ετικέτα'
                )
                new LabelTranslation(
                    locale: Locale::EN_GB,
                    label: 'Option 1 Label'
                ),
                // ...
            )
        ),
        new Option(
            key: 'option_2_key',
            label: 'Option 2 Label',
            labelTranslations: new LabelTranslationCollection(
                new LabelTranslation(
                    locale: Locale::DE_DE,
                    label: 'Option 2 Beschriftung'
                ),
                new LabelTranslation(
                    locale: Locale::EL_GR,
                    label: 'Επιλογή 2 Ετικέτα'
                )
                new LabelTranslation(
                    locale: Locale::EN_GB,
                    label: 'Option 2 Label'
                ),
                // ...
            )
        )
    ),
    help: 'Please select an option.',
```

The resulting JSON Schema property will looks as follows:

```json
{
  "example_radio": {
    "type": "string",
    "description": "Example Radio Field",
    "enum": [
      "option_1_key",
      "option_2_key"
    ],
    "meta": {
      "help": "Please select an option.",
      "enum_labels": {
        "option_1_key": "Option 1 Label",
        "option_2_key": "Option 2 Label"
      },
      "label_translations": {
        "de-DE": "Beispiel Radiofeld",
        "el-GR": "Παράδειγμα πεδίου ραδιοφώνου",
        "en-GB": "Example Radio Field"
      },
      "enum_label_translations": {
        "option_1_key": {
          "en-GB": "Option 1 Label EN",
          "de-DE": "Option 1 Label DE",
          "el-GR": "Option 1 Label EL"
        },
        "option_2_key": {
          "en-GB": "Option 2 Label EN",
          "de-DE": "Option 2 Label DE",
          "el-GR": "Option 2 Label EL"
        }
      }
    }
  }
}
```

#### Example MultiSelect

```php

```
