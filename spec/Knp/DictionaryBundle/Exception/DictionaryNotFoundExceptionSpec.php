<?php

namespace spec\Knp\DictionaryBundle\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DictionaryNotFoundExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Exception\DictionaryNotFoundException');
    }
}
