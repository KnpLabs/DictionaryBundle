<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
use PhpSpec\ObjectBehavior;

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
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\DictionaryRegistry');
    }

    function it_is_an_array_access()
    {
        $this->shouldHaveType('ArrayAccess');
    }

    function it_is_iterable()
    {
        $this->shouldHaveType('IteratorAggregate');
    }

    function it_is_countable()
    {
        $this->shouldHaveType('Countable');
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
        $this->set('bar', $dictionary)->shouldReturn($this);
    }

    function it_should_throw_exception_if_entry_exists($dictionary)
    {
        $this->shouldThrow('\RuntimeException')->duringSet('foo', $dictionary);
    }

    function it_should_entry_if_it_exists($dictionary)
    {
        $this->get('foo')->shouldReturn($dictionary);
    }

    function it_should_throw_exception_if_entry_does_not_exist()
    {
        $this->shouldThrow('Knp\DictionaryBundle\Exception\DictionaryNotFoundException')->duringGet('bar');
    }

    function its_offsetSet_method_cannot_be_called()
    {
        $this->shouldThrow('\RuntimeException')->duringOffsetSet('foo', 'bar');
    }

    function its_offsetUnset_method_cannot_be_called()
    {
        $this->shouldThrow('\RuntimeException')->duringOffsetUnset('foo');
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
}
