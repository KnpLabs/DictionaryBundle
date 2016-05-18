<?php

namespace spec\Knp\DictionaryBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;

class KnpDictionaryExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\DependencyInjection\KnpDictionaryExtension');
    }
}
