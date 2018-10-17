<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary\ValueTransformer;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\ValueTransformer\ConstantTransformer;
use PhpSpec\ObjectBehavior;

class ConstantTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ConstantTransformer::class);
    }

    function it_doesnt_support_non_constant_pattern_values()
    {
        $this->supports('foo')->shouldReturn(false);
    }

    function it_doesnt_support_integers()
    {
        $this->supports(0)->shouldReturn(false);
    }

    function it_doesnt_support_non_existing_classes()
    {
        $this->supports('My\Awesome\Non\Existing\Class::CONST')->shouldReturn(false);
    }

    function it_doesnt_support_non_existing_constants()
    {
        $this->supports(Dictionary::class.'::PONEY')->shouldReturn(false);
    }

    function it_supports_existing_classes_and_constants()
    {
        $this->supports(Dictionary::class.'::VALUE')->shouldReturn(true);
    }

    function it_transforms_constant_patterns()
    {
        $this->transform(Dictionary::class.'::VALUE')->shouldReturn('value');
    }
}
