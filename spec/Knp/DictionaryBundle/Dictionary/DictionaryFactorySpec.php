<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\DictionaryBundle\Dictionary\ValueTransformer\TransformerInterface;

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

    function it_creates_dictionaries()
    {
        $this
            ->create('foo', array('bar' => 'baz'), Argument::any())
            ->shouldHaveType('Knp\DictionaryBundle\Dictionary\Dictionary')
        ;
    }

    function it_doesnt_call_transformers_transform_method_if_not_supported($transformer)
    {
        $transformer->supports('bar')->shouldBeCalled();
        $transformer->transform('bar')->shouldNotBeCalled();

        $this->create('foo', array('foo' => 'bar'), Argument::any());

    }

    function it_calls_transformers_transform_method_if_supported($transformer)
    {
        $transformer->supports('baz')->shouldBeCalled();
        $transformer->transform('baz')->shouldBeCalled();

        $this->create('foo', array('bar' => 'baz'), Argument::any());
    }
}
