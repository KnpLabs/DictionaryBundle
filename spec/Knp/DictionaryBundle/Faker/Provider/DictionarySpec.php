<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Faker\Provider;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Faker;
use PhpSpec\ObjectBehavior;

final class DictionarySpec extends ObjectBehavior
{
    private Collection $dictionaries;

    function let()
    {
        $this->dictionaries = new Collection();

        $this->beConstructedWith($this->dictionaries);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Faker\Provider\Dictionary::class);
    }

    function it_can_generates_random_values(Dictionary $dictionary)
    {
        $dictionary->getName()->willReturn('the_dico');
        $dictionary->getKeys()->willReturn(['foo', 'bar', 'baz']);

        $this->dictionaries->add($dictionary->getWrappedObject());

        $this->dictionary('the_dico')->shouldBeOneOf('foo', 'bar', 'baz');
    }

    function it_can_generates_unique_random_values(Dictionary $dictionary)
    {
        $dictionary->getName()->willReturn('the_dico');
        $dictionary->getKeys()->willReturn(['foo', 'bar', 'baz']);

        $this->dictionaries->add($dictionary->getWrappedObject());

        $this->unique()->dictionary('the_dico')->shouldBeOneOf('foo', 'bar', 'baz');
    }
}
