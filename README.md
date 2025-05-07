# Json Schema Form Builder

This library provides an object-oriented API for constructing forms, which can be converted into a JSON Schema.

This package includes the following functionalities:

1. Constructing forms and rendering them as a JSON Schema.
2. Creating simple fields such as `text`, `number` and `checkbox`.
3. Creating choice fields such as `select`, `radio` and `multi-select`.
4. Grouping form fields (`group` element).
5. Adding translations to form elements using the `LabelTranslationCollection` class. This includes:
    - Field label translations (for all fields and groups).
    - Option labels (for fields with a finite set of options such as `Select` and `Radio`).
6. Defining values for form fields using the `ValueCollection` class.

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

### Meta Fields

All properties that are not part of the JSON Schema specification will be stored as `meta`
fields.

The following fields are used in this library:

- `help`: A string that describes the purpose of the field.
- `label_translations`: Translations for the label of the field. (the non-translated label is stored as the
  `description` property)
- `field_type`: Used to differentiate between fields that have the same JSON Schema format. **Only used for choice
  fields at the moment**
- `enum_labels`: Used to define labels for field options. (The keys are stored in the `enum` property) **Only for choice
  fields**
- `enum_label_translations`: Used to define translations for labels of field options. **Only for choice fields**

### Example: Constructing a Form and Converting it to a JSON Schema

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

### Example: Grouping elements

```php
use MyParcelCom\JsonSchema\FormBuilder\Form\Form;
use MyParcelCom\JsonSchema\FormBuilder\Form\Group;
use MyParcelCom\JsonSchema\FormBuilder\Form\FormElementCollection;
use MyParcelCom\JsonSchema\FormBuilder\Form\Text;
use MyParcelCom\JsonSchema\FormBuilder\Form\Checkbox;
use MyParcelCom\JsonSchema\FormBuilder\Form\Number;
use MyParcelCom\JsonSchema\FormBuilder\Translations\LabelTranslationCollection;

$group = new Group(
    name: 'my_group',
    label: 'My Group',
    children: new FormElementCollection(
        new Text('my_text', 'My Text Field'),
        new Checkbox('my_checkbox', 'My Checkbox Field'),
        new Number('my_number', 'My Number Field')
    ),
    help: 'This following fields are related to...',
);

$someOtherTextField = new Text(
    name: 'some_other_text',
    label: 'Some Other Text Field',
    help: 'Please enter some other text.',
);

$form = new Form($group, $someOtherTextField);
```

The resulting JSON Schema property for the group will look as follows:

```json
{
  "my_group": {
    "type": "object",
    "description": "My Group",
    "properties": {
      "my_text": {
        "type": "string",
        "description": "My Text Field"
      },
      "my_checkbox": {
        "type": "boolean",
        "description": "My Checkbox Field"
      },
      "my_number": {
        "type": "number",
        "description": "My Number Field"
      }
    },
    "meta": {
      "help": "This following fields are related to..."
    }
  }
}
```

### Example: Adding translations to a form element's label

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

### Example: Adding translations to a Form element's labels and option labels

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

The resulting JSON Schema property will look as follows:

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
          "de-DE": "Option 1 Beschriftung",
          "el-GR": "Επιλογή 2 Ετικέτα",
          "en-GB": "Option 1 Label"
        },
        "option_2_key": {
          "de-DE": "Option 2 Beschriftung",
          "el-GR": "Επιλογή 2 Ετικέτα",
          "en-GB": "Option 2 Label"
        }
      }
    }
  }
}
```

### Example: Multi-Select

Rendering a `MultiSelect` field can be done by setting the `isMultiSelect` property to `true`.

```php
use MyParcelCom\JsonSchema\FormBuilder\Form\Select;

$multiSelectField = new Select(
    name: 'example_multi_select',
    label: 'Example Multi-Select Field',
    options: new OptionCollection(
        new Option('option_1_key', 'Option 1 Label'),
        new Option('option_2_key', 'Option 2 Label')
    ),
    isMultiSelect: true,
    help: 'Please select one or more options.',
);
```

The resulting JSON Schema property will be of type `array` and look as follows:

```json
{
  "example_multi_select": {
    "type": "array",
    "items": {
      "type": "string",
      "enum": [
        "option_1_key",
        "option_2_key"
      ]
    },
    "meta": {
      "help": "Please select one or more options.",
      "enum_labels": {
        "option_1_key": "Option 1 Label",
        "option_2_key": "Option 2 Label"
      }
    }
  }
}
```
