<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use PhpSpec\ObjectBehavior;
use Knp\DictionaryBundle\Dictionary\Dictionary;

class DictionaryRegistrySpec extends ObjectBehavior
{
    public function let(Dictionary $dictionary, Dictionary $dictionary2)
    {
        $this->set('foo', $dictionary);
        $this->set('dictionary', $dictionary);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\DictionaryRegistry');
    }

    public function it_is_an_array_access()
    {
        $this->shouldHaveType('\ArrayAccess');
    }

    public function it_is_iterable()
    {
        $this->shouldHaveType('\IteratorAggregate');
    }

    public function it_is_countable()
    {
        $this->shouldHaveType('\Countable');
    }

    public function it_sets_registry_entry($dictionary)
    {
        $this->set('bar', $dictionary)->shouldReturn($this);
    }

    public function it_should_throw_exception_if_entry_exists($dictionary)
    {
        $this->shouldThrow('\RuntimeException')->duringSet('foo', $dictionary);
    }

    public function it_should_entry_if_it_exists($dictionary)
    {
        $this->get('foo')->shouldReturn($dictionary);
    }

    public function it_should_throw_exception_if_entry_does_not_exist()
    {
        $this->shouldThrow('Knp\DictionaryBundle\Exception\DictionaryNotFoundException')->duringGet('bar');
    }

    public function its_offsetSet_method_cannot_be_called()
    {
        $this->shouldThrow('\RuntimeException')->duringOffsetSet('foo', 'bar');
    }

    public function its_offsetUnset_method_cannot_be_called()
    {
        $this->shouldThrow('\RuntimeException')->duringOffsetUnset('foo');
    }

    public function it_counts_entries()
    {
        $this->count()->shouldReturn(2);
    }
}
