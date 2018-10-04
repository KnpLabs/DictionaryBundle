DictionaryBundle
================
[![Build Status](https://travis-ci.org/KnpLabs/DictionaryBundle.svg)](https://travis-ci.org/KnpLabs/DictionaryBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KnpLabs/DictionaryBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KnpLabs/DictionaryBundle/?branch=master)

Are you often tired to repeat static choices like gender or civility in your apps ?

## Requirements
- Symfony >= 3.0

## Installation
Run the following command:
```bash
composer require knplabs/dictionary-bundle
```
Register the bundle in ``app/AppKernel.php``

```php
$bundles = array(
    // ...
    new Knp\DictionaryBundle\KnpDictionaryBundle(),
);
```

## Maintainers

You can ping us if need some reviews/comments/help:

 - [@AntoineLelaisant](https://github.com/AntoineLelaisant)
 - [@PedroTroller](https://github.com/PedroTroller)

## Basic usage
Define dictionaries in your config.yml file:
```yaml
knp_dictionary:
    dictionaries:
        my_dictionary:      # your dictionary name
            - Foo           # your dictionary content
            - Bar
            - Baz
```
You will be able to retreive it trough the dictionary registry service:
```php
$container->get('knp_dictionary.registry')->get('my_dictionary');
```
### Dictionary form type

Now, use them in your forms:

```php
use Knp\DictionaryBundle\Form\Type\DictionaryType;

public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // PHP ~5.5.9 syntax
        ->add('civility', DictionaryType::class, array(
            'name' => 'my_dictionary'
        ))

        // PHP ~5.3.9+ syntax
        ->add('civility', 'Knp\DictionaryBundle\Form\Type\DictionaryType', array(
            'name' => 'my_dictionary'
        ))

        // PHP ~5.3.9+ (deprecated since Symfony 3.0)
        ->add('civility', 'dictionary', array(
            'name' => 'my_dictionary'
        ))
    ;
}
```
The dictionary form type extends the [symfony's choice type](http://symfony.com/fr/doc/current/reference/forms/types/choice.html) and its options.

### Validation constraint

You can also use the constraint for validation. The `value` have to be set.

```php
use Knp\DictionaryBundle\Validator\Constraints\Dictionary;

class User
{
    /**
     * @ORM\Column
     * @Dictionary(name="my_dictionary")
     */
    private $civility;
}
```

## Advanced usage
You can specify the indexation mode of each dictionary
```yaml
knp_dictionary:
    dictionaries:
        my_dictionary:                  # your dictionary name
            type: 'key_value'           # your dictionary type
            content:                    # your dictionary content
                "foo": "foo_value"
                "bar": "bar_value"
                "baz": "baz_value"
```
### Available types
- `value` (default) : Natural indexation
- `value_as_key`: Keys are defined from their value
- `key_value`: Define your own keys
- `callable`: Build a dictionary from a callable

### Callable dictionary
You can create a callable dictionary:
```yaml
knp_dictionary:
    dictionaries:
        my_callable_dictionary:         # your dictionary name
            type: 'callable'            # your dictionary type
            service: 'app.service.id'   # a valid service from your application
            method: 'getSomething'      # the method name to execute
```
Callable dictionaries are loaded with a lazy strategy. It means that the callable
will not be called if you do not use the dictionary.

### Combined dictionary

You can combine multiple dictionaries into a single one:
```yaml
knp_dictionary:
  dictionaries:
    payment_mode:
      type: key_value
      content:
        card: "credit card"
        none: "none"

    extra_payment_mode:
      type: key_value
      content:
        bank_transfert: "Bank transfert"
        other: "Other"

    combined_payment_mode:
      type: combined
      dictionaries:
        - payment_mode
        - extra_payment_mode
```
Now you have 3 dictionaries, `payment_mode` and `extra_payment_mode` contains 
their own values but `combined_payment_mode` contains all the values of the previous ones.

### Extended dictionary

You can create an extended dictionary:
```yaml
knp_dictionary:
    dictionaries:
        europe:
            type: 'key_value'
            content:
                fr: France
                de: Germany

        world:
            type: 'key_value'
            extends: europe
            content:
                us: USA
                ca: Canada
```
The dictionary `world` will now contains its own values in addition
to the `europe` values.

**Note**: You must define the initial dictionary **BEFORE** the extended one.

## Transformers
For now, this bundle is only able to resolve your **class constants**:

```yaml
my_dictionary:
    - MyClass::MY_CONSTANT
    - Foo
    - Bar
```
You want to add other kinds of transformations for your dictionary values ?
Feel free to create your own transformer !

### Add your own transformers

Create your class that implements [TransformerInterface](src/Knp/DictionaryBundle/Dictionary/ValueTransformer/TransformerInterface.php).
Load your transformer and tag it as `knp_dictionary.value_transformer`.
```yaml
services:
    my_bundle.my_namespace.my_transformer:
        class: %my_transformer_class%
            tags:
                - { name: knp_dictionary.value_transformer }
```

## Use your dictionary in twig

You can also use your dictionary in your Twig templates via calling ```dictionary``` function (or filter)

```twig
{% for example in dictionary('examples') %}
    {{ example }}
{% endfor %}
```

But you can also access directly to a value by using the same function (or filter)

```twig
{{ 'my_key'|dictionary('dictionary_name') }}
```

## Faker provider

The KnpDictionaryBundle comes with a [faker provider](https://github.com/fzaninotto/Faker) that can be used to provide a random entry from a dictionary.

### Alice

To register the provider in [nelmio/alice](https://github.com/nelmio/alice), you can follow the [official documentation](https://github.com/nelmio/alice/blob/master/doc/customizing-data-generation.md#add-a-custom-faker-provider-class)

or ...

if you use the awesome [knplabs/rad-fixtures-load](https://github.com/knplabs/rad-fixtures-load) library, the dictionary provider will be automaticaly loaded for you :)

```yaml
App\Entity\User:
    john_doe:
        firstname: John
        latnale: Doe
        city: <dictionary('cities')>
```

## Create your own dictionary implementation

### Dictionary

Your dictionary implementation must implements the interface [Dictionary](src/Knp/DictionaryBundle/Dictionary.php).

### Dictionary Factory

You must create a dictionary factory that will be responsible to instanciate your dictionary.

```yaml

services:
    app.dictionary.factory.my_custom_factory:
        class: App\Dictionary\Factory\MyCustomFactory
        tags:
            { name: 'knp_dictionary.factory' }

```
