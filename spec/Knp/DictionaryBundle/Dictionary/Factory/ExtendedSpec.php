<?php

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use PhpSpec\ObjectBehavior;
use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\Factory\FactoryAggregate;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;

class ExtendedSpec extends ObjectBehavior
{
    function let(
        FactoryAggregate $factoryAggregate,
        DictionaryRegistry $registry
    ) {
        $this->beConstructedWith($factoryAggregate, $registry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Factory\Extended::class);
    }

    function it_is_a_factory()
    {
        $this->shouldHaveType(Factory::class);
    }

    function it_supports_specific_config()
    {
        $this->supports(['extends' => 'my_dictionary'])->shouldReturn(true);
    }

    function it_creates_a_dictionary(
        $factoryAggregate,
        $registry,
        Dictionary $initialDictionary,
        Dictionary $extendsDictionary
    ) {
        $config = [
            'content' => ['bar1', 'bar2', 'bar3'],
        ];

        $initialDictionary->getValues()->willReturn(['foo1', 'foo2']);
        $extendsDictionary->getValues()->willReturn(['bar1', 'bar2', 'bar3']);

        $factoryAggregate->create('yolo', $config)->willReturn($extendsDictionary);
        $registry->get('initial_dictionary')->willReturn($initialDictionary);

        $config = array_merge($config, ['extends' => 'initial_dictionary']);
        $factoryAggregate->supports($config)->willReturn(true);

        $dictionary = $this->create('yolo', $config);

        $dictionary->getName()->shouldBe('yolo');
        $dictionary->getValues()->shouldBe(['foo1', 'foo2', 'bar1', 'bar2', 'bar3']);
    }
}
