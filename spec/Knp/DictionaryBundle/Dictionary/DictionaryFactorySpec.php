<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\ValueTransformer\TransformerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DictionaryFactorySpec extends ObjectBehavior
{
    function let(TransformerInterface $transformer)
    {
        $transformer->supports('baz')->willReturn(true);
        $transformer->transform('baz')->willReturn('foo');

        $transformer->supports('bar')->willReturn(false);

        $this->addTransformer($transformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\DictionaryFactory');
    }

    function it_creates_dictionaries_from_array()
    {
        $dictionary = $this
            ->createFromArray('foo', array('bar' => 'baz'), Argument::any())
        ;

        $dictionary
            ->shouldHaveType('Knp\DictionaryBundle\Dictionary')
        ;

        $dictionary->getName()->shouldReturn('foo');
        $dictionary->getKeys()->shouldReturn(array('bar'));
        $dictionary->getValues()->shouldReturn(array('bar' => 'foo'));
    }

    function it_creates_dictionaries_from_callable()
    {
        $dictionary = $this
            ->createFromCallable('foo', function () { return array('bar' => 'baz'); })
        ;

        $dictionary
            ->shouldHaveType('Knp\DictionaryBundle\Dictionary')
        ;

        $dictionary->getName()->shouldReturn('foo');
        $dictionary->getKeys()->shouldReturn(array('bar'));
        $dictionary->getValues()->shouldReturn(array('bar' => 'baz'));
    }

    function it_doesnt_call_transformers_transform_method_if_not_supported($transformer)
    {
        $transformer->supports('foo')->shouldBeCalled();
        $transformer->supports('bar')->shouldBeCalled();
        $transformer->transform('foo')->shouldNotBeCalled();
        $transformer->transform('bar')->shouldNotBeCalled();

        $this->createFromArray('foo', array('foo' => 'bar'), Argument::any());
    }

    function it_calls_transformers_transform_method_if_supported($transformer)
    {
        $transformer->supports('bar')->shouldBeCalled();
        $transformer->supports('baz')->shouldBeCalled();
        $transformer->transform('baz')->shouldBeCalled();
        $transformer->transform('bar')->shouldNotBeCalled();

        $this->createFromArray('foo', array('bar' => 'baz'), Argument::any());
    }

    function it_doesnt_call_transformers_transform_method_for_specific_dictionaries($transformer)
    {
        $transformer->supports('baz')->shouldBeCalled();
        $transformer->supports('bar')->shouldNotBeCalled();
        $this->createFromArray('foo', array('bar' => 'baz'), Dictionary::VALUE_AS_KEY);
    }
}
