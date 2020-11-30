<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary;

use Assert\Assert;
use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Simple;
use Knp\DictionaryBundle\Dictionary\Traceable;
use PhpSpec\ObjectBehavior;

final class TraceableSpec extends ObjectBehavior
{
    /**
     * @var DictionaryDataCollector
     */
    private $collector;

    /**
     * @var Dictionary
     */
    private $dictionary;

    function let()
    {
        $this->dictionary = new Simple('name', [
            'foo' => 'bar',
            'baz' => null,
        ]);

        $this->collector = new DictionaryDataCollector();

        $this->beConstructedWith($this->dictionary, $this->collector);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Traceable::class);
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement(Dictionary::class);
    }

    function it_trace_an_other_dictionary()
    {
        $this->getTraced()->shouldReturn($this->dictionary);
    }

    function it_has_a_name()
    {
        Assert::that(iterator_to_array($this->collector->getDictionaries()))->noContent();

        $this->getName()->shouldReturn('name');

        Assert::that(iterator_to_array($this->collector->getDictionaries()))->noContent();
    }

    function it_traces_keys()
    {
        Assert::that(iterator_to_array($this->collector->getDictionaries()))->noContent();

        $this->getKeys()->shouldReturn(['foo', 'baz']);

        Assert::that(iterator_to_array($this->collector->getDictionaries()))
            ->eq([
                'name' => [
                    [
                        'key'   => 'foo',
                        'value' => 'bar',
                    ],
                    [
                        'key'   => 'baz',
                        'value' => null,
                    ],
                ],
            ])
        ;
    }

    function it_traces_values()
    {
        Assert::that(iterator_to_array($this->collector->getDictionaries()))->noContent();

        $this->getValues()->shouldReturn(['foo' => 'bar', 'baz' => null]);

        Assert::that(iterator_to_array($this->collector->getDictionaries()))
            ->eq([
                'name' => [
                    [
                        'key'   => 'foo',
                        'value' => 'bar',
                    ],
                    [
                        'key'   => 'baz',
                        'value' => null,
                    ],
                ],
            ])
        ;
    }

    function it_traces_values_get()
    {
        Assert::that(iterator_to_array($this->collector->getDictionaries()))->noContent();

        $this['foo']->shouldReturn('bar');

        Assert::that(iterator_to_array($this->collector->getDictionaries()))
            ->eq([
                'name' => [
                    [
                        'key'   => 'foo',
                        'value' => 'bar',
                    ],
                    [
                        'key'   => 'baz',
                        'value' => null,
                    ],
                ],
            ])
        ;
    }

    function it_traces_value_set()
    {
        Assert::that(iterator_to_array($this->collector->getDictionaries()))->noContent();

        $this['yo'] = 'lo';

        Assert::that(iterator_to_array($this->collector->getDictionaries()))
            ->eq([
                'name' => [
                    [
                        'key'   => 'foo',
                        'value' => 'bar',
                    ],
                    [
                        'key'   => 'baz',
                        'value' => null,
                    ],
                    [
                        'key'   => 'yo',
                        'value' => 'lo',
                    ],
                ],
            ])
        ;
    }

    function it_traces_value_unset()
    {
        Assert::that(iterator_to_array($this->collector->getDictionaries()))->noContent();

        unset($this['foo']);

        Assert::that(iterator_to_array($this->collector->getDictionaries()))
            ->eq([
                'name' => [
                    [
                        'key'   => 'baz',
                        'value' => null,
                    ],
                ],
            ])
        ;
    }

    function it_traces_key_exists()
    {
        Assert::that(iterator_to_array($this->collector->getDictionaries()))->noContent();

        $this->offsetExists('baz')->shouldReturn(true);

        Assert::that(iterator_to_array($this->collector->getDictionaries()))
            ->eq([
                'name' => [
                    [
                        'key'   => 'foo',
                        'value' => 'bar',
                    ],
                    [
                        'key'   => 'baz',
                        'value' => null,
                    ],
                ],
            ])
        ;
    }

    function it_trace_iteration()
    {
        Assert::that(iterator_to_array($this->collector->getDictionaries()))->noContent();

        $this->shouldIterateLike([
            'foo' => 'bar',
            'baz' => null,
        ]);

        Assert::that(iterator_to_array($this->collector->getDictionaries()))
            ->eq([
                'name' => [
                    [
                        'key'   => 'foo',
                        'value' => 'bar',
                    ],
                    [
                        'key'   => 'baz',
                        'value' => null,
                    ],
                ],
            ])
        ;
    }

    function it_delegates_the_count_to_the_other_dictionary()
    {
        $this->count()->shouldReturn(2);
    }
}
