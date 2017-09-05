<?php

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\Container;

class CallableFactorySpec extends ObjectBehavior
{
    function let(Container $container)
    {
        $this->beConstructedWith($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\Factory\CallableFactory');
    }

    function it_is_a_factory()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\Factory');
    }

    function it_supports_specific_config()
    {
        $this->supports(array('type' => 'callable'))->shouldReturn(true);
    }

    function it_creates_a_dictionary(
        $container,
        MockedService $service
    ) {
        $config = array(
            'service' => 'service.id',
            'method'  => 'getYolo',
        );

        $container->get('service.id')->willReturn($service);
        $service->getYolo()->willReturn(array(
            'foo1' => 'bar1',
            'foo2' => 'bar2',
            'foo3' => 'bar3',
        ));

        $dictionary = $this->create('yolo', $config);

        $dictionary->getName()->shouldBe('yolo');
        $dictionary->getValues()->shouldBe(array(
            'foo1' => 'bar1',
            'foo2' => 'bar2',
            'foo3' => 'bar3',
        ));
    }
}

class MockedService
{
    public function getYolo()
    {
    }
}
