<?php

namespace spec\Knp\DictionaryBundle\Exception;

use Knp\DictionaryBundle\Exception\DictionaryNotFoundException;
use PhpSpec\ObjectBehavior;

class DictionaryNotFoundExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DictionaryNotFoundException::class);
    }
}
