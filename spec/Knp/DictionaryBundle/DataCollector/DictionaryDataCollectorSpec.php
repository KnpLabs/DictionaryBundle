<?php

namespace spec\Knp\DictionaryBundle\DataCollector;

use PhpSpec\ObjectBehavior;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;

class DictionaryDataCollectorSpec extends ObjectBehavior
{
    public function let(DictionaryRegistry $registry)
    {
        $this->beConstructedWith($registry);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\DataCollector\DictionaryDataCollector');
    }
}
