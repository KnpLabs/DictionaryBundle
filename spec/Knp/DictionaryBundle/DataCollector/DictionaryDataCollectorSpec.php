<?php

namespace spec\Knp\DictionaryBundle\DataCollector;

use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use PhpSpec\ObjectBehavior;

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
