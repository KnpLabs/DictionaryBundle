<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Templating\Extension;

use Assert\Assert;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Templating\Extension;
use PhpSpec\ObjectBehavior;

class DictionarySpec extends ObjectBehavior
{
    function let(Dictionary $dico1, Dictionary $dico2)
    {
        $dico1->offsetGet('foo')->willReturn('bar');
        $dico1->getName()->willReturn('test');

        $dico2->offsetGet('foo')->willReturn(false);
        $dico2->getName()->willReturn('other');

        $this->beConstructedWith(new Dictionary\Collection($dico1->getWrappedObject(), $dico2->getWrappedObject()));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Extension\Dictionary::class);
    }

    function it_has_a_filter_and_a_function()
    {
        $filters   = $this->getFilters();
        $functions = $this->getFunctions();

        Assert::that(current($filters->getWrappedObject())->getName())->eq('dictionary');
        Assert::that(current($functions->getWrappedObject())->getName())->eq('dictionary');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('knp_dictionary.dictionary_extension');
    }

    function it_returns_a_dictionary_by_its_name($dico1, $dico2)
    {
        $functions = $this->getFunctions();
        $callable  = current($functions->getWrappedObject())->getCallable();

        Assert::that($callable('test'))->eq($dico1->getWrappedObject());
        Assert::that($callable('other'))->eq($dico2->getWrappedObject());
    }

    function it_returns_a_value_from_a_dictionary()
    {
        $filters  = $this->getFilters();
        $callable = current($filters->getWrappedObject())->getCallable();

        Assert::that($callable('foo', 'test'))->eq('bar');
        Assert::that($callable('foo', 'other'))->eq(false);
    }
}
