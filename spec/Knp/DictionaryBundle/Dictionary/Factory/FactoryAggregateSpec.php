<?php

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Factory;
use PhpSpec\ObjectBehavior;

class FactoryAggregateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\Factory\FactoryAggregate');
    }

    function it_is_a_factory()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\Factory');
    }

    function it_supports_if_one_factory_supports(
        Factory $factory1,
        Factory $factory2,
        Factory $factory3
    ) {
        $this->addFactory($factory1)->addFactory($factory2);

        $factory1->supports(array())->willReturn(false);
        $factory2->supports(array())->willReturn(false);
        $factory3->supports(array())->willReturn(true);

        $this->supports(array())->shouldReturn(false);

        $this->addFactory($factory3);

        $this->supports(array())->shouldReturn(true);
    }

    function it_uses_its_factory_to_build_a_dictionary(
        Factory $factory1,
        Factory $factory2,
        Factory $factory3,
        Dictionary $dictionary
    ) {
        $this->addFactory($factory1)->addFactory($factory2)->addFactory($factory3);

        $factory1->supports(array())->willReturn(false);
        $factory2->supports(array())->willReturn(false);
        $factory3->supports(array())->willReturn(true);

        $factory3->create('yolo', array())->willReturn($dictionary);

        $this->create('yolo', array())->shouldReturn($dictionary);
    }

    function it_throws_exception_if_no_factory_supports_the_config(
        Factory $factory1,
        Factory $factory2,
        Factory $factory3
    ) {
        $this->addFactory($factory1)->addFactory($factory2)->addFactory($factory3);

        $factory1->supports(array())->willReturn(false);
        $factory2->supports(array())->willReturn(false);
        $factory3->supports(array())->willReturn(false);

        $this->shouldThrow('\InvalidArgumentException')->during('create', array('yolo', array()));
    }
}
