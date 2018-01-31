<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Knp\DictionaryBundle\Exception\DictionaryNotFoundException;
use PhpSpec\ObjectBehavior;
use RuntimeException;

class DictionaryRegistrySpec extends ObjectBehavior
{
    function let(Dictionary $dictionary, Dictionary $dictionary2)
    {
        $dictionary->getName()->willReturn('foo');

        $this->add($dictionary);
        $this->set('dictionary', $dictionary2);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DictionaryRegistry::class);
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

    function it_provides_a_list_of_dictionaries($dictionary, $dictionary2)
    {
        $this->all()->shouldReturn([
            'foo'        => $dictionary,
            'dictionary' => $dictionary2,
        ]);
    }

    function it_sets_registry_entry($dictionary)
    {
        $this->set('bar', $dictionary);

        $this->get('bar')->shouldReturn($dictionary);
    }

    function it_should_throw_exception_if_entry_exists($dictionary)
    {
        $this->shouldThrow(RuntimeException::class)->duringSet('foo', $dictionary);
    }

    function it_should_entry_if_it_exists($dictionary)
    {
        $this->get('foo')->shouldReturn($dictionary);
    }

    function it_should_throw_exception_if_entry_does_not_exist()
    {
        $this->shouldThrow(DictionaryNotFoundException::class)->duringGet('bar');
    }

    function it_counts_entries()
    {
        $this->count()->shouldReturn(2);
    }

    function it_provides_an_array_iterator($dictionary, $dictionary2)
    {
        $this->getIterator()->getArrayCopy()->shouldReturn([
            'foo'        => $dictionary,
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
