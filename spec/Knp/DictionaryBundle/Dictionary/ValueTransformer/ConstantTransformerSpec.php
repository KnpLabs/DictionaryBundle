<?php

namespace spec\Knp\DictionaryBundle\Dictionary\ValueTransformer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConstantTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\ValueTransformer\ConstantTransformer');
    }

    function it_doesnt_support_non_constant_pattern_values()
    {
        $this->supports('foo')->shouldReturn(false);
    }

    function it_doesnt_support_non_existing_classes()
    {
        $this->supports('My\Awesome\Non\Existing\Class::CONST')->shouldReturn(false);
    }

    function it_doesnt_support_non_existing_constants()
    {
        $this->supports('Knp\DictionaryBundle\Dictionary\Dictionary::PONEY')->shouldReturn(false);
    }

    function it_supports_existing_classes_and_constants()
    {
        $this->supports('Knp\DictionaryBundle\Dictionary\Dictionary::VALUE')->shouldReturn(true);
    }

    function it_transforms_constant_patterns()
    {
        $this->transform('Knp\DictionaryBundle\Dictionary\Dictionary::VALUE')->shouldReturn('value');
    }
}
