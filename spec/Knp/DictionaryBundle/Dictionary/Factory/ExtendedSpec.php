<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\Factory\FactoryAggregate;
use PhpSpec\ObjectBehavior;

class ExtendedSpec extends ObjectBehavior
{
    function let(FactoryAggregate $factoryAggregate)
    {
        $this->beConstructedWith($factoryAggregate, new Collection());
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

    function it_creates_a_dictionary($factoryAggregate, Dictionary $initialDictionary, Dictionary $extendsDictionary)
    {
        $initialDictionary->getName()->willReturn('initial_dictionary');
        $initialDictionary->getValues()->willReturn(['foo1', 'foo2']);

        $extendsDictionary->getName()->willReturn('extends_dictionary');
        $extendsDictionary->getValues()->willReturn(['bar1', 'bar2', 'bar3']);

        $dictionaries = new Collection($initialDictionary->getWrappedObject(), $extendsDictionary->getWrappedObject());

        $this->beConstructedWith($factoryAggregate, $dictionaries);

        $config = [
            'content' => ['bar1', 'bar2', 'bar3'],
        ];

        $factoryAggregate->create('yolo', $config)->willReturn($extendsDictionary);

        $config = array_merge($config, ['extends' => 'initial_dictionary']);
        $factoryAggregate->supports($config)->willReturn(true);

        $dictionary = $this->create('yolo', $config);

        $dictionary->getName()->shouldBe('yolo');
        $dictionary->getValues()->shouldBe(['foo1', 'foo2', 'bar1', 'bar2', 'bar3']);
    }
}
