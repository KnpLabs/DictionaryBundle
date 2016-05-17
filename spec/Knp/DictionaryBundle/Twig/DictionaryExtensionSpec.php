<?php

namespace spec\Knp\DictionaryBundle\Twig;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use PhpSpec\ObjectBehavior;

class DictionaryExtensionSpec extends ObjectBehavior
{
    function let(DictionaryRegistry $registry, Dictionary $dico1, Dictionary $dico2)
    {
        $this->beConstructedWith($registry);

        $registry->get('test')->willReturn($dico1);
        $registry->get('other')->willReturn($dico2);

        $dico1->offsetGet('foo')->willReturn('bar');
        $dico2->offsetGet('foo')->willReturn(false);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Twig\DictionaryExtension');
    }

    function it_returns_a_dictionary_by_its_name($dico1, $dico2)
    {
        $this->getDictionary('test')->shouldReturn($dico1);
        $this->getDictionary('other')->shouldReturn($dico2);
    }

    function it_returns_a_value_from_a_dictionary()
    {
        $this->getValue('foo', 'test')->shouldReturn('bar');
        $this->getValue('foo', 'other')->shouldReturn(false);
    }
}
