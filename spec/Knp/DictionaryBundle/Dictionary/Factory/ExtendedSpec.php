<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\Factory\Extended;
use PhpSpec\ObjectBehavior;

final class ExtendedSpec extends ObjectBehavior
{
    function let(Factory $factory)
    {
        $this->beConstructedWith($factory, new Collection());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Extended::class);
    }

    function it_is_a_factory()
    {
        $this->shouldHaveType(Factory::class);
    }

    function it_supports_specific_config()
    {
        $this->supports(['extends' => 'my_dictionary'])->shouldReturn(true);
    }

    function it_creates_a_dictionary($factory, Dictionary $initialDictionary, Dictionary $extendsDictionary)
    {
        $initialDictionary->getName()->willReturn('initial_dictionary');
        $initialDictionary->getIterator()->willReturn(new \ArrayIterator(['foo1', 'foo2']));

        $extendsDictionary->getName()->willReturn('extends_dictionary');
        $extendsDictionary->getIterator()->willReturn(new \ArrayIterator(['bar1', 'bar2', 'bar3']));

        $dictionaries = new Collection($initialDictionary->getWrappedObject(), $extendsDictionary->getWrappedObject());

        $this->beConstructedWith($factory, $dictionaries);

        $config = [
            'content' => ['bar1', 'bar2', 'bar3'],
        ];

        $factory->create('yolo', $config)->willReturn($extendsDictionary);

        $config = array_merge($config, ['extends' => 'initial_dictionary']);
        $factory->supports($config)->willReturn(true);

        $dictionary = $this->create('yolo', $config);

        $dictionary->getName()->shouldBe('yolo');
        $dictionary->getValues()->shouldBe(['foo1', 'foo2', 'bar1', 'bar2', 'bar3']);
    }
}
