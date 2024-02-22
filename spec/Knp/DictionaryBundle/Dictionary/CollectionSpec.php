<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use PhpSpec\ObjectBehavior;
use RuntimeException;

final class CollectionSpec extends ObjectBehavior
{
    function let(Dictionary $dictionary1, Dictionary $dictionary2)
    {
        $this->beConstructedWith($dictionary1, $dictionary2);
        $dictionary1->getName()->willReturn('foo');
        $dictionary2->getName()->willReturn('dictionary');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Collection::class);
    }

    function it_is_an_array_access()
    {
        $this->shouldHaveType(ArrayAccess::class);
    }

    function it_is_iterable()
    {
        $this->shouldHaveType(IteratorAggregate::class);
    }

    function it_is_countable()
    {
        $this->shouldHaveType(Countable::class);
    }

    function it_should_entry_if_it_exists()
    {
        $this->shouldHaveKey('foo');
        $this->shouldNotHaveKey('baz');
    }

    function it_counts_entries()
    {
        $this->shouldHaveCount(2);
    }

    function it_is_a_list_of_dictionaries($dictionary1, $dictionary2)
    {
        $this->shouldYieldLike([
            'foo'        => $dictionary1,
            'dictionary' => $dictionary2,
        ]);
    }

    function its_offsetSet_method_cannot_be_called()
    {
        $this->shouldThrow(RuntimeException::class)->duringOffsetSet('foo', 'bar');
    }

    function its_offsetUnset_method_cannot_be_called()
    {
        $this->shouldThrow(RuntimeException::class)->duringOffsetUnset('foo');
    }
}
