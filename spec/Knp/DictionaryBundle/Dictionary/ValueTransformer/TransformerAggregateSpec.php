<?php

namespace spec\Knp\DictionaryBundle\Dictionary\ValueTransformer;

use Knp\DictionaryBundle\Dictionary\ValueTransformer;
use PhpSpec\ObjectBehavior;

class TransformerAggregateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\ValueTransformer\TransformerAggregate');
    }

    function it_is_a_value_transfomer()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\ValueTransformer');
    }

    function it_supports_values(
        ValueTransformer $transformer1,
        ValueTransformer $transformer2,
        ValueTransformer $transformer3
    ) {
        $transformer1->supports(array())->willReturn(false);
        $transformer2->supports(array())->willReturn(false);
        $transformer3->supports(array())->willReturn(true);

        $this
            ->addTransformer($transformer1)
            ->addTransformer($transformer2)
        ;

        $this->supports(array())->shouldReturn(false);

        $this->addTransformer($transformer3);

        $this->supports(array())->shouldReturn(true);
    }

    function it_transform_value(
        ValueTransformer $transformer1,
        ValueTransformer $transformer2,
        ValueTransformer $transformer3
    ) {
        $transformer1->supports(array())->willReturn(false);
        $transformer2->supports(array())->willReturn(true);
        $transformer3->supports(array())->willReturn(true);

        $transformer2->transform(array())->willReturn('foo');
        $transformer3->transform(array())->willReturn('bar');

        $this
            ->addTransformer($transformer1)
            ->addTransformer($transformer2)
            ->addTransformer($transformer3)
        ;

        $this->transform(array())->shouldReturn('foo');
    }
}
