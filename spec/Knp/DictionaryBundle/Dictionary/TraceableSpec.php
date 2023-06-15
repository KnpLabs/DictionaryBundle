<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Simple;
use Knp\DictionaryBundle\Dictionary\Traceable;
use PhpSpec\ObjectBehavior;
use Webmozart\Assert\Assert;

final class TraceableSpec extends ObjectBehavior
{
    /**
     * @var DictionaryDataCollector
     */
    private $collector;

    function let()
    {
        $dictionary = new Simple('name', [
            'foo' => 'bar',
            'baz' => null,
        ]);

        $this->collector = new DictionaryDataCollector();

        $this->beConstructedWith($dictionary, $this->collector);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Traceable::class);
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement(Dictionary::class);
    }

    function it_has_a_name()
    {
        Assert::isEmpty(iterator_to_array($this->collector->getDictionaries()));

        $this->getName()->shouldReturn('name');

        Assert::isEmpty(iterator_to_array($this->collector->getDictionaries()));
    }

    function it_traces_keys()
    {
        Assert::isEmpty(iterator_to_array($this->collector->getDictionaries()));

        $this->getKeys()->shouldReturn(['foo', 'baz']);

        Assert::eq(
            iterator_to_array($this->collector->getDictionaries()),
            [
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
            ]
        );
    }

    function it_traces_values()
    {
        Assert::isEmpty(iterator_to_array($this->collector->getDictionaries()));

        $this->getValues()->shouldReturn(['foo' => 'bar', 'baz' => null]);

        Assert::eq(
            iterator_to_array($this->collector->getDictionaries()),
            [
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
            ],
        );
    }

    function it_traces_values_get()
    {
        Assert::isEmpty(iterator_to_array($this->collector->getDictionaries()));

        $this['foo']->shouldReturn('bar');

        Assert::eq(
            iterator_to_array($this->collector->getDictionaries()),
            [
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
            ]
        );
    }

    function it_traces_value_set()
    {
        Assert::isEmpty(iterator_to_array($this->collector->getDictionaries()));

        $this['yo'] = 'lo';

        Assert::eq(
            iterator_to_array($this->collector->getDictionaries()),
            [
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
            ]
        );
    }

    function it_traces_value_unset()
    {
        Assert::isEmpty(iterator_to_array($this->collector->getDictionaries()));

        unset($this['foo']);

        Assert::eq(
            iterator_to_array($this->collector->getDictionaries()),
            [
                'name' => [
                    [
                        'key'   => 'baz',
                        'value' => null,
                    ],
                ],
            ]
        );
    }

    function it_traces_key_exists()
    {
        Assert::isEmpty(iterator_to_array($this->collector->getDictionaries()));

        $this->shouldHaveKey('baz');

        Assert::eq(
            iterator_to_array($this->collector->getDictionaries()),
            [
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
            ]
        );
    }

    function it_trace_iteration()
    {
        Assert::isEmpty(iterator_to_array($this->collector->getDictionaries()));

        $this->shouldIterateLike([
            'foo' => 'bar',
            'baz' => null,
        ]);

        Assert::eq(
            iterator_to_array($this->collector->getDictionaries()),
            [
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
            ]
        );
    }

    function it_delegates_the_count_to_the_other_dictionary()
    {
        $this->count()->shouldReturn(2);
    }
}
