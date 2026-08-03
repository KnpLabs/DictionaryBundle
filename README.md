# DictionaryBundle

[![CircleCI](https://circleci.com/gh/KnpLabs/DictionaryBundle.svg?style=svg)](https://circleci.com/gh/KnpLabs/DictionaryBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KnpLabs/DictionaryBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KnpLabs/DictionaryBundle/?branch=master)

Are you often tired to repeat static choices like gender or civility in your apps ?

## Requirements

- PHP >= 8.1
- Symfony 5.4, 6.4 or 7.\*

## Installation

Run the following command:

```bash
composer require knplabs/dictionary-bundle
```

Register the bundle in `config/bundles.php`

```php
$bundles = array(
    // ...
    Knp\DictionaryBundle\KnpDictionaryBundle::class => ['all' => true],
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
    civility: # your dictionary name
      - Mr    # your dictionary content
      - Ms
```

To inject a configured dictionary directly, type-hint `Dictionary` and select
its name with Symfony's `#[Target]` attribute:

```php
use Knp\DictionaryBundle\Dictionary;
use Symfony\Component\DependencyInjection\Attribute\Target;

final class UserManager
{
    public function __construct(
        #[Target('civility.dictionary')]
        private Dictionary $dictionary,
    ) {}
}
```

Selecting by argument name remains supported for compatibility. Use
`<dictionaryName>Dictionary`; names are normalized to camel case, so `civility`
maps to `$civilityDictionary`:

```php
use Knp\DictionaryBundle\Dictionary;

final class UserManager
{
    public function __construct(
        private Dictionary $civilityDictionary,
    ) {}
}
```

An existing named `Dictionary` autowiring alias takes precedence and is not
replaced by a configured dictionary.

Names that are invalid PHP argument names after normalization, or names that
normalize to the same argument name (for example, `foo-bar` and `foo_bar`), do
not receive an automatic autowiring alias. Inject the collection instead for
these names or when selecting a dictionary dynamically:

```php
use Knp\DictionaryBundle\Dictionary;

final class UserManager
{
    private Dictionary $dictionary;

    public function __construct(Dictionary\Collection $dictionaries)
    {
        $this->dictionary = $dictionaries['civility'];
    }
}
```

## Dictionary form type

Now, use them in your forms:

```php
use Knp\DictionaryBundle\Form\Type\DictionaryType;

public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('civility', DictionaryType::class, array(
            'name' => 'civility'
        ))
    ;
}
```

The dictionary form type extends the [symfony's choice type](http://symfony.com/fr/doc/current/reference/forms/types/choice.html) and its options.

## Validation constraint

You can also use the constraint for validation. The `value` has to be set.

```php
use Knp\DictionaryBundle\Validator\Constraints\Dictionary;

class User
{
    #[ORM\Column]
    #[Dictionary(name: 'civility')]
    private $civility;
}
```

## Advanced usage

You can specify the indexation mode of each dictionary

```yaml
knp_dictionary:
  dictionaries:
    my_dictionary: # your dictionary name
      type: "key_value" # your dictionary type
      content: # your dictionary content
        "foo": "foo_value"
        "bar": "bar_value"
        "baz": "baz_value"
```

## Available types

- `value` (default) : Natural indexation
- `value_as_key`: Keys are defined from their value
- `key_value`: Define your own keys
- `callable`: Build a dictionary from a callable

## Callable dictionary

You can create a callable dictionary:

```yaml
knp_dictionary:
  dictionaries:
    my_callable_dictionary: # your dictionary name
      type: "callable" # your dictionary type
      service: "app.service.id" # a valid service from your application
      method: "getSomething" # the method name to execute
```

Callable dictionaries are loaded with a lazy strategy. It means that the callable
will not be called if you do not use the dictionary.

## Iterator based dictionary

You can create a dictionary from an iterator:

```yaml
knp_dictionary:
  dictionaries:
    my_iterator_dictionary: # your dictionary name
      type: "iterator" # your dictionary type
      service: "app.service.id" # a valid service from your application
```

Iterator based dictionaries are loaded with a lazy strategy. It means that the
iterator will not be fetched if you do not use the dictionary.

## Combined dictionary

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
        bank_transfer: "Bank transfer"
        other: "Other"

    combined_payment_mode:
      type: combined
      dictionaries:
        - payment_mode
        - extra_payment_mode
```

Now you have 3 dictionaries, `payment_mode` and `extra_payment_mode` contain
their own values but `combined_payment_mode` contains all the values of the previous ones.

## Extended dictionary

You can create an extended dictionary:

```yaml
knp_dictionary:
  dictionaries:
    europe:
      type: "key_value"
      content:
        fr: France
        de: Germany

    world:
      type: "key_value"
      extends: europe
      content:
        us: USA
        ca: Canada
```

The dictionary `world` will now contain its own values in addition
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

## Add your own transformers

Create your class that implements [TransformerInterface](src/Knp/DictionaryBundle/Dictionary/ValueTransformer/TransformerInterface.php).
Load your transformer and tag it as `knp_dictionary.value_transformer`.

```yaml
services:
  App\My\Transformer:
    tags:
      - knp_dictionary.value_transformer
```

## Use your dictionary in twig

You can also use your dictionary in your Twig templates via calling `dictionary` function (or filter).

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

The KnpDictionaryBundle comes with a [faker provider](https://github.com/FakerPHP/Faker) that can be used to provide a random entry from a dictionary.

## Alice

To register the provider in [nelmio/alice](https://github.com/nelmio/alice), you can follow the [official documentation](https://github.com/nelmio/alice/blob/master/doc/customizing-data-generation.md#add-a-custom-faker-provider-class)

```yaml
App\Entity\User:
  john_doe:
    firstname: John
    latnale: Doe
    city: <dictionary('cities')>
```

## Create your own dictionary implementation

## Dictionary

Your dictionary implementation must implements the interface [Dictionary](src/Knp/DictionaryBundle/Dictionary.php).

It is automatically registered with the `autoconfigure: true` DIC feature.

Else you can register it by your self:

```yaml
services:
  App\Dictionary\MyCustomDictionary:
    tags:
      - knp_dictionary.dictionary
```

## Dictionary Factory

You must create a dictionary factory that will be responsible to instantiate your dictionary.

It is automatically registered with the `autoconfigure: true` DIC feature.

Else you can register it by your self:

```yaml
services:
  App\Dictionary\Factory\MyCustomFactory:
    tags:
      - knp_dictionary.factory
```

## Tests

## phpspec

```bash
composer install
vendor/bin/phpspec run
```

## php-cs-fixer

```bash
composer install
vendor/bin/php-cs-fixer fix
```

## phpstan

First [install phive](https://github.com/phar-io/phive#getting-phive).

Then...

```bash
phive install
tools/phpstan process
```

## rector (_optional_)

```bash
rector process --set php70 --set php71 --set php72 --set code-quality --set coding-style --set symfony34 --set twig240 --set psr-4 --set solid src/ spec/
```
