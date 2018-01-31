<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use PhpSpec\ObjectBehavior;

class SimpleDictionarySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo', array(
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\SimpleDictionary');
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement('Knp\DictionaryBundle\Dictionary');
    }

    function its_getvalues_should_return_dictionary_values()
    {
        $this->getValues()->shouldReturn(array(
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ));
    }

    function its_getname_should_return_dictionary_name()
    {
        $this->getName()->shouldReturn('foo');
    }

    function it_access_to_value_like_an_array()
    {
        expect($this['foo']->getWrappedObject())->toBe(0);
        expect($this['bar']->getWrappedObject())->toBe(1);
        expect($this['baz']->getWrappedObject())->toBe(2);
    }
}
