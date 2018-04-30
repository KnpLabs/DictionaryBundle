<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Simple;
use PhpSpec\ObjectBehavior;
use Webmozart\Assert\Assert;

class SimpleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo', [
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Simple::class);
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement(Dictionary::class);
    }

    function it_access_to_value_like_an_array()
    {
        Assert::eq($this['foo']->getWrappedObject(), 0);
        Assert::eq($this['bar']->getWrappedObject(), 1);
        Assert::eq($this['baz']->getWrappedObject(), 2);
    }

    function its_getvalues_should_return_dictionary_values()
    {
        $this->getValues()->shouldReturn([
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);
    }

    function its_getname_should_return_dictionary_name()
    {
        $this->getName()->shouldReturn('foo');
    }
}
