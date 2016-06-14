DictionaryBundle
================
[![Build Status](https://travis-ci.org/KnpLabs/DictionaryBundle.svg)](https://travis-ci.org/KnpLabs/DictionaryBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KnpLabs/DictionaryBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KnpLabs/DictionaryBundle/?branch=master)

Are you often tired to repeat static choices like gender or civility in your apps ?

## Requirements
- Symfony >= 2.8

## Installation
Add the DictionaryBundle to your `composer.json`:
```yaml
{
    "require": {
        "knplabs/dictionary-bundle": "~2.0"
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
