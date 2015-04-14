<?php

namespace spec\Knp\DictionaryBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;

class DictionaryTypeSpec extends ObjectBehavior
{
    public function let(DictionaryRegistry $registry)
    {
        $this->beConstructedWith($registry);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Form\Type\DictionaryType');
    }
}
