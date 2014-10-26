<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DictionarySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo', array(
            'bar' => 'baz'
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\Dictionary');
    }

    function its_getvalues_should_return_dictionary_values()
    {
        $this->getValues()->shouldReturn(array(
            'bar' => 'baz'
        ));
    }

    function its_getname_should_return_dictionary_name()
    {
        $this->getName()->shouldReturn('foo');
    }
}
