<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class SimpleDictionarySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('foo', []);

        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\SimpleDictionary');
    }

    function it_is_a_dictionary()
    {
        $this->beConstructedWith('foo', []);

        $this->shouldImplement('Knp\DictionaryBundle\Dictionary');
    }

    function its_getvalues_should_return_dictionary_values()
    {
        $this->beConstructedWith('foo', [
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);

        $this->getValues()->shouldReturn([
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);
    }

    function its_can_also_e_constructed_with_an_array_of_keys_and_an_array_of_values()
    {
        $this->beConstructedWith('foo', ['foo', 'bar', 'baz'], [0, 1, 2]);

        $this->getValues()->shouldReturn([
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);
    }

    function it_have_to_be_constructed_with_the_same_amount_of_keys_and_values()
    {
        $this->beConstructedWith('foo', ['foo', 'bar', 'baz'], [0, 1, 2, 3]);

        $this
            ->shouldThrow(new InvalidArgumentException('Number of keys and values are not equals.'))
            ->duringInstantiation()
        ;
    }

    function it_have_to_be_constructed_with_unique_keys()
    {
        $this->beConstructedWith('foo', ['foo', 'bar', 'bar'], [0, 1, 2]);

        $this
            ->shouldThrow(new InvalidArgumentException('Keys have to be unique.'))
            ->duringInstantiation()
        ;
    }

    function its_getname_should_return_dictionary_name()
    {
        $this->beConstructedWith('foo', []);

        $this->getName()->shouldReturn('foo');
    }

    function it_access_to_value_like_an_array()
    {
        $this->beConstructedWith('foo', [
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);

        expect($this['foo']->getWrappedObject())->toBe(0);
        expect($this['bar']->getWrappedObject())->toBe(1);
        expect($this['baz']->getWrappedObject())->toBe(2);
    }
}
