<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\Factory\Iterator;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\Container;

final class IteratorSpec extends ObjectBehavior
{
    function let(Container $container)
    {
        $this->beConstructedWith($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Iterator::class);
    }

    function it_is_a_factory()
    {
        $this->shouldHaveType(Factory::class);
    }

    function it_supports_specific_config()
    {
        $this->supports(['type' => 'iterator'])->shouldReturn(true);
    }

    function it_creates_a_dictionary($container, MockIterator $service)
    {
        $config = [
            'service' => 'service.id',
        ];

        $container->get('service.id')->willReturn($service);
        $service->getIterator()->willReturn(new \ArrayIterator([
            'foo1' => 'bar1',
            'foo2' => 'bar2',
            'foo3' => 'bar3',
        ]));

        $dictionary = $this->create('yolo', $config);

        $dictionary->getName()->shouldBe('yolo');
        $dictionary->getValues()->shouldBe([
            'foo1' => 'bar1',
            'foo2' => 'bar2',
            'foo3' => 'bar3',
        ]);
    }
}

abstract class MockIterator implements \IteratorAggregate
{
    public function getIterator()
    {
        return yield from [];
    }
}
