<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DictionaryFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\DictionaryFactory');
    }

    function it_creates_dictionaries()
    {
        $this
            ->create('foo', array('bar' => 'baz'))
            ->shouldHaveType('Knp\DictionaryBundle\Dictionary\Dictionary')
        ;
    }
}
