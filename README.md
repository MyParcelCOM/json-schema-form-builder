# json-schema-form-builder
This library provides an object-oriented API for constructing forms, which can then be converted into a JSON Schema. 

This package includes:
- Classes that can be used to outline simple forms.
- Functionality to render these forms into JSON Schema
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
