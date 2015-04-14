<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\DictionaryBundle\Dictionary\ValueTransformer\TransformerInterface;
use Knp\DictionaryBundle\Dictionary\Dictionary;

class DictionaryFactorySpec extends ObjectBehavior
{
    public function let(TransformerInterface $transformer)
    {
        $transformer->supports('baz')->willReturn(true);
        $transformer->transform('baz')->willReturn('foo');

        $transformer->supports('bar')->willReturn(false);

        $this->addTransformer($transformer);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\DictionaryFactory');
    }

    public function it_creates_dictionaries()
    {
        $this
            ->create('foo', array('bar' => 'baz'), Argument::any())
            ->shouldHaveType('Knp\DictionaryBundle\Dictionary\Dictionary')
        ;
    }

    public function it_doesnt_call_transformers_transform_method_if_not_supported($transformer)
    {
        $transformer->supports('foo')->shouldBeCalled();
        $transformer->supports('bar')->shouldBeCalled();
        $transformer->transform('foo')->shouldNotBeCalled();
        $transformer->transform('bar')->shouldNotBeCalled();

        $this->create('foo', array('foo' => 'bar'), Argument::any());
    }

    public function it_calls_transformers_transform_method_if_supported($transformer)
    {
        $transformer->supports('bar')->shouldBeCalled();
        $transformer->supports('baz')->shouldBeCalled();
        $transformer->transform('baz')->shouldBeCalled();
        $transformer->transform('bar')->shouldNotBeCalled();

        $this->create('foo', array('bar' => 'baz'), Argument::any());
    }

    public function it_doesnt_call_transformers_transform_method_for_specific_dictionaries($transformer)
    {
        $transformer->supports('baz')->shouldBeCalled();
        $transformer->supports('bar')->shouldNotBeCalled();
        $this->create('foo', array('bar' => 'baz'), Dictionary::VALUE_AS_KEY);
    }
}
