<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use Knp\DictionaryBundle\Dictionary;
use PhpSpec\ObjectBehavior;
use Webmozart\Assert\Assert;

class TraceableSpec extends ObjectBehavior
{
    function let(DictionaryDataCollector $collector)
    {
        $dictionary = new Dictionary\Simple('name', [
            'foo' => 'bar',
            'baz' => null,
        ]);

        $this->beConstructedWith($dictionary, $collector);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Dictionary\Traceable::class);
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement(Dictionary::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('name');
    }

    function it_traces_keys($collector)
    {
        $collector->addDictionary('name', ['foo', 'baz'], ['bar', null])->shouldbeCalled();

        $this->getKeys()->shouldReturn(['foo', 'baz']);
    }

    function it_traces_values($collector)
    {
        $collector->addDictionary('name', ['foo', 'baz'], ['bar', null])->shouldbeCalled();

        $this->getValues()->shouldReturn(['foo' => 'bar', 'baz' => null]);
    }

    function it_traces_values_get($collector)
    {
        $collector->addDictionary('name', ['foo', 'baz'], ['bar', null])->shouldbeCalled();

        $this['foo']->shouldReturn('bar');
    }

    function it_traces_value_set($collector)
    {
        $collector->addDictionary('name', ['foo', 'baz', 'yo'], ['bar', null, 'lo'])->shouldbeCalled();

        $this['yo'] = 'lo';
    }

    function it_traces_value_unset($collector)
    {
        $collector->addDictionary('name', ['baz'], [null])->shouldbeCalled();

        unset($this['foo']);
    }

    function it_traces_key_exists($collector)
    {
        $collector->addDictionary('name', ['foo', 'baz'], ['bar', null])->shouldbeCalled();

        Assert::eq(isset($this['baz']), true);
    }

    function it_trace_iteration($collector)
    {
        $collector->addDictionary('name', ['foo', 'baz'], ['bar', null])->shouldbeCalled();

        Assert::eq(iterator_to_array($this->getIterator()->getWrappedObject()), ['foo' => 'bar', 'baz' => null]);
    }
}
