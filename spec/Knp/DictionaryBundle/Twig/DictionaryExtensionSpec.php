<?php

namespace spec\Knp\DictionaryBundle\Twig;

use Knp\DictionaryBundle\Dictionary\Dictionary;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use PhpSpec\ObjectBehavior;

class DictionaryExtensionSpec extends ObjectBehavior
{
    public function let(DictionaryRegistry $registry, Dictionary $dico1, Dictionary $dico2)
    {
        $this->beConstructedWith($registry);

        $registry->get('test')->willReturn($dico1);
        $registry->get('other')->willReturn($dico2);

        $dico1->offsetGet('foo')->willReturn('bar');
        $dico2->offsetGet('foo')->willReturn(false);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Twig\DictionaryExtension');
    }

    public function it_returns_a_dictionary_by_its_name($dico1, $dico2)
    {
        $this->getData('test')->shouldReturn($dico1);
        $this->getData('other')->shouldReturn($dico2);
    }

    public function it_returns_a_value_from_a_dictionary()
    {
        $this->getData('foo', 'test')->shouldReturn('bar');
        $this->getData('foo', 'other')->shouldReturn(false);
    }
}
