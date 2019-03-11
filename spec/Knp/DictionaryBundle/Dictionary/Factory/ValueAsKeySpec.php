<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\ValueTransformer;
use PhpSpec\ObjectBehavior;

class ValueAsKeySpec extends ObjectBehavior
{
    function let(ValueTransformer $transformer)
    {
        $this->beConstructedWith($transformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Dictionary\Factory\ValueAsKey::class);
    }

    function it_is_a_factory()
    {
        $this->shouldHaveType(Dictionary\Factory::class);
    }

    function it_supports_specific_config()
    {
        $this->supports(['type' => 'value_as_key'])->shouldReturn(true);
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
            'content' => ['bar1', 'bar2', 'bar3'],
        ];

        $transformer->transform('bar1')->willReturn('bar1');
        $transformer->transform('bar2')->willReturn('bar2');
        $transformer->transform('bar3')->willReturn('bar3');

        $dictionary = $this->create('yolo', $config);

        $dictionary->getName()->shouldBe('yolo');
        $dictionary->getValues()->shouldBe([
            'bar1' => 'bar1',
            'bar2' => 'bar2',
            'bar3' => 'bar3',
        ]);
    }
}
