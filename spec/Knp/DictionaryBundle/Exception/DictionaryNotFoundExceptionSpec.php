<?php

namespace spec\Knp\DictionaryBundle\Exception;

use PhpSpec\ObjectBehavior;

class DictionaryNotFoundExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Exception\DictionaryNotFoundException');
    }
}
