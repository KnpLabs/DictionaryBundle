<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Templating\Extension;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Templating\Extension;
use PhpSpec\ObjectBehavior;
use Webmozart\Assert\Assert;

final class DictionarySpec extends ObjectBehavior
{
    function let(Dictionary $dico1, Dictionary $dico2)
    {
        $dico1->offsetGet('foo')->willReturn('bar');
        $dico1->getName()->willReturn('test');

        $dico2->offsetGet('foo')->willReturn(false);
        $dico2->getName()->willReturn('other');

        $this->beConstructedWith(new Collection($dico1->getWrappedObject(), $dico2->getWrappedObject()));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Extension\Dictionary::class);
    }

    function it_has_a_filter_and_a_function()
    {
        $filters   = $this->getFilters();
        $functions = $this->getFunctions();

        $filters[0]->getName()->shouldReturn('dictionary');
        $functions[0]->getName()->shouldReturn('dictionary');
    }

    function it_returns_a_dictionary_by_its_name($dico1, $dico2)
    {
        $functions = $this->getFunctions();
        $callable  = current($functions->getWrappedObject())->getCallable();

        Assert::eq($callable('test'), $dico1->getWrappedObject());
        Assert::eq($callable('other'), $dico2->getWrappedObject());
    }

    function it_returns_a_value_from_a_dictionary()
    {
        $filters  = $this->getFilters();
        $callable = current($filters->getWrappedObject())->getCallable();

        Assert::eq($callable('foo', 'test'), 'bar');
        Assert::eq($callable('foo', 'other'), false);
    }
}
