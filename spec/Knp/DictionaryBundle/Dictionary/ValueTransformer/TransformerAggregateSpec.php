<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary\ValueTransformer;

use Knp\DictionaryBundle\Dictionary\ValueTransformer;
use Knp\DictionaryBundle\Dictionary\ValueTransformer\TransformerAggregate;
use PhpSpec\ObjectBehavior;

class TransformerAggregateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TransformerAggregate::class);
    }

    function it_is_a_value_transfomer()
    {
        $this->shouldHaveType(ValueTransformer::class);
    }

    function it_supports_values(
        ValueTransformer $transformer1,
        ValueTransformer $transformer2,
        ValueTransformer $transformer3
    ) {
        $transformer1->supports([])->willReturn(false);
        $transformer2->supports([])->willReturn(false);
        $transformer3->supports([])->willReturn(true);

        $this->addTransformer($transformer1);
        $this->addTransformer($transformer2);

        $this->supports([])->shouldReturn(false);

        $this->addTransformer($transformer3);

        $this->supports([])->shouldReturn(true);
    }

    function it_transform_value(
        ValueTransformer $transformer1,
        ValueTransformer $transformer2,
        ValueTransformer $transformer3
    ) {
        $transformer1->supports([])->willReturn(false);
        $transformer2->supports([])->willReturn(true);
        $transformer3->supports([])->willReturn(true);

        $transformer2->transform([])->willReturn('foo');
        $transformer3->transform([])->willReturn('bar');

        $this->addTransformer($transformer1);
        $this->addTransformer($transformer2);
        $this->addTransformer($transformer3);

        $this->transform([])->shouldReturn('foo');
    }
}
