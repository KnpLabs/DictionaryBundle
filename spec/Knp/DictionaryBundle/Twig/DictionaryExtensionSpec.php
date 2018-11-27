<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Twig;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Twig\DictionaryExtension;
use PhpSpec\ObjectBehavior;

class DictionaryExtensionSpec extends ObjectBehavior
{
    function let(Dictionary $dico1, Dictionary $dico2)
    {
        $dico1->getName()->willReturn('test');
        $dico2->getName()->willReturn('other');

        $dico1->offsetGet('foo')->willReturn('bar');
        $dico2->offsetGet('foo')->willReturn(false);

        $dictionaries = new Collection($dico1->getWrappedObject(), $dico2->getWrappedObject());

        $this->beConstructedWith($dictionaries);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DictionaryExtension::class);
    }

    function it_has_a_filter_and_a_function()
    {
        $filters   = $this->getFilters();
        $functions = $this->getFunctions();

        $filters[0]->getName()->shouldReturn('dictionary');
        $functions[0]->getName()->shouldReturn('dictionary');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('knp_dictionary.dictionary_extension');
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
