<?php

namespace spec\Knp\DictionaryBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\AbstractType;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;

class DictionaryTypeSpec extends ObjectBehavior
{
    function let(DictionaryRegistry $registry)
    {
        $this->beConstructedWith($registry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Form\Type\DictionaryType');
    }
}
