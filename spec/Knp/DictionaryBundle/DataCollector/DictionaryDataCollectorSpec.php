<?php

namespace spec\Knp\DictionaryBundle\DataCollector;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;

class DictionaryDataCollectorSpec extends ObjectBehavior
{
    function let(DictionaryRegistry $registry)
    {
        $this->beConstructedWith($registry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\DataCollector\DictionaryDataCollector');
    }
}
