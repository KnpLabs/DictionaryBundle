<?php

namespace spec\Knp\DictionaryBundle\Dictionary\ValueTransformer;

use PhpSpec\ObjectBehavior;

class ConstantTransformerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\ValueTransformer\ConstantTransformer');
    }

    public function it_doesnt_support_non_constant_pattern_values()
    {
        $this->supports('foo')->shouldReturn(false);
    }

    public function it_doesnt_support_non_existing_classes()
    {
        $this->supports('My\Awesome\Non\Existing\Class::CONST')->shouldReturn(false);
    }

    public function it_doesnt_support_non_existing_constants()
    {
        $this->supports('Knp\DictionaryBundle\Dictionary\Dictionary::PONEY')->shouldReturn(false);
    }

    public function it_supports_existing_classes_and_constants()
    {
        $this->supports('Knp\DictionaryBundle\Dictionary\Dictionary::VALUE')->shouldReturn(true);
    }

    public function it_transforms_constant_patterns()
    {
        $this->transform('Knp\DictionaryBundle\Dictionary\Dictionary::VALUE')->shouldReturn('value');
    }
}
