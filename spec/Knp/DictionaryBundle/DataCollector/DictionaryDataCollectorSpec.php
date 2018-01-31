<?php

namespace spec\Knp\DictionaryBundle\DataCollector;

use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use PhpSpec\ObjectBehavior;

class DictionaryDataCollectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DictionaryDataCollector::class);
    }

    function it_collects_data_from_dictionaries()
    {
        $this->addDictionary('foo', ['key1', 'key2'], ['value1', 'value2']);
        $this->addDictionary('foo', ['key1', 'key2'], ['value1', 'value2']);
        $this->addDictionary('bar', ['keyA', 'keyB'], ['valueA', 'valueB']);

        $this->getDictionaries()->shouldReturn([
            'foo' => [
                [
                    'key'   => 'key1',
                    'value' => 'value1',
                ],
                [
                    'key'   => 'key2',
                    'value' => 'value2',
                ],
            ],
            'bar' => [
                [
                    'key'   => 'keyA',
                    'value' => 'valueA',
                ],
                [
                    'key'   => 'keyB',
                    'value' => 'valueB',
                ],
            ],
        ]);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('dictionary');
    }
}
