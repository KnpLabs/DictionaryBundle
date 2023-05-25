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
    private Dictionary $dictionary1;
    private Dictionary $dictionary2;

    function let()
    {
        $this->dictionary1 = new Dictionary\Simple(
            'test',
            ['foo' => 'bar'],
        );
        $this->dictionary2 = new Dictionary\Simple(
            'other',
            ['foo' => false],
        );

        $this->beConstructedWith(new Collection($this->dictionary1, $this->dictionary2));
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

    function it_returns_a_dictionary_by_its_name()
    {
        $functions = $this->getFunctions();
        $callable  = current($functions->getWrappedObject())->getCallable();

        Assert::eq($callable('test'), $this->dictionary1);
        Assert::eq($callable('other'), $this->dictionary2);
    }

    function it_returns_a_value_from_a_dictionary()
    {
        $filters  = $this->getFilters();
        $callable = current($filters->getWrappedObject())->getCallable();

        Assert::eq($callable('foo', 'test'), 'bar');
        Assert::eq($callable('foo', 'other'), false);
    }
}
