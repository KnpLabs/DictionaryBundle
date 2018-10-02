<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\DependencyInjection;

use Knp\DictionaryBundle\DependencyInjection\Configuration;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Configuration::class);
    }

    function it_generates_a_tree()
    {
        $this->getConfigTreeBuilder()->shouldHaveType(TreeBuilder::class);
    }
}
