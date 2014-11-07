DictionaryBundle
================
[![Build Status](https://travis-ci.org/Shivoham/DictionaryBundle.svg?branch=master)](https://travis-ci.org/Shivoham/DictionaryBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Shivoham/DictionaryBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Shivoham/DictionaryBundle/?branch=master)

## Requirements
- Symfony >= 2.4

## Installation
Add the DictionaryBundle to your `composer.json`:
```yaml
{
    "require": {
        "knplabs/dictionary-bundle": "dev-master"
    }
}
```
Register the bundle in ``app/AppKernel.php``

```php
$bundles = array(
    // ...
    new Knp\DictionaryBundle\KnpDictionaryBundle(),
);
```
## Basic usage
Define dictionaries in your config.yml file:
```yaml
knp_dictionary:
    dictionaries:
        my_dictionary:      # your dictionary name
            content:        # your dictionary content
                - Foo
                - Bar
                - Baz
```
You will be able to retreive it trough the dictionary registry service:
```php
$container->get('knp_dictionary.registry')->get('my_dictionary');
```
### Dictionary form type

You can now use them in your forms:

```php
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // ...
        ->add('civility', 'dictionary', array(
            'name' => 'my_dictionary'
        ));
    ;
}
```
The dictionary form type extends the [symfony's choice type](http://symfony.com/fr/doc/current/reference/forms/types/choice.html) and its options.

## Types
You can also specify the indexation mode of each dictionary
```yaml
knp_dictionary:
    dictionaries:
        my_dictionary:
            type: 'key_value'   # your dictionary type
            content:
                "foo": "foo_value"
                "bar": "bar_value"
                "baz": "baz_value"
```
### Available types
- `value` (default) : Natural indexation
- `value_as_key`: Keys are defined from their value
- `key_value`: Define your own keys
