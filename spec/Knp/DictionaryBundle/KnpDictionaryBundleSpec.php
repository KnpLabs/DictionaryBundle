<?php

namespace spec\Knp\DictionaryBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class KnpDictionaryBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\KnpDictionaryBundle');
    }
}
