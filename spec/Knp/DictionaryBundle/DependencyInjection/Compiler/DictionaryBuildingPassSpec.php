<?php

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;

class DictionaryBuildingPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass');
    }
}
