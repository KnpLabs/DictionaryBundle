<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\Factory\KeyValue;
use Knp\DictionaryBundle\ValueTransformer;
use PhpSpec\ObjectBehavior;

final class KeyValueSpec extends ObjectBehavior
{
    function let(ValueTransformer $transformer)
    {
        $this->beConstructedWith($transformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(KeyValue::class);
    }

    function it_is_a_factory()
    {
        $this->shouldHaveType(Factory::class);
    }

    function it_supports_specific_config()
    {
        $this->supports(['type' => 'key_value'])->shouldReturn(true);
    }

    function it_throws_exception_if_no_content_is_provided()
    {
        $this
            ->shouldThrow(InvalidArgumentException::class)
            ->during('create', ['yolo', []])
        ;
    }

    function it_creates_a_dictionary($transformer)
    {
        $config = [
            'content' => [
                'foo1' => 'bar1',
                'foo2' => 'bar2',
                'foo3' => 'bar3',
            ],
        ];

        $transformer->transform('bar1')->willReturn('bar1');
        $transformer->transform('bar2')->willReturn('bar2');
        $transformer->transform('bar3')->willReturn('bar3');
        $transformer->transform('foo1')->willReturn('foo1');
        $transformer->transform('foo2')->willReturn('foo2');
        $transformer->transform('foo3')->willReturn('foo3');

        $dictionary = $this->create('yolo', $config);

        $dictionary->getName()->shouldBe('yolo');
        $dictionary->getValues()->shouldBe([
            'foo1' => 'bar1',
            'foo2' => 'bar2',
            'foo3' => 'bar3',
        ]);
    }
}
