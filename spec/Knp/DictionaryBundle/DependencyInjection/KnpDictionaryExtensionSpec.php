<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\DependencyInjection;

use Knp\DictionaryBundle\DependencyInjection\KnpDictionaryExtension;
use PhpSpec\ObjectBehavior;

class KnpDictionaryExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(KnpDictionaryExtension::class);
    }
}
