<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Faker\Provider;

use Assert\Assert;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Knp\DictionaryBundle\Dictionary\SimpleDictionary;
use Knp\DictionaryBundle\Faker\Provider\Dictionary;
use PhpSpec\ObjectBehavior;

class DictionarySpec extends ObjectBehavior
{
    function let(DictionaryRegistry $dictionaries)
    {
        $this->beConstructedWith($dictionaries);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Dictionary::class);
    }

    function it_can_generates_random_values($dictionaries, SimpleDictionary $dictionary)
    {
        $dictionaries->get('the_dico')->willReturn($dictionary);
        $dictionary->getKeys()->willReturn(['foo', 'bar', 'baz']);

        $this->dictionary('the_dico')->shouldBeOneOf(['foo', 'bar', 'baz']);
    }

    function it_can_generates_unique_random_values($dictionaries, SimpleDictionary $dictionary)
    {
        $dictionaries->get('the_dico')->willReturn($dictionary);
        $dictionary->getKeys()->willReturn(['foo', 'bar', 'baz']);

        $this->unique()->dictionary('the_dico')->shouldBeOneOf(['foo', 'bar', 'baz']);
    }

    public function getMatchers(): array
    {
        return [
            'beOneOf' => function (string $value, array $array) {
                Assert::that($value)->inArray($array);

                return true;
            },
        ];
    }
}
