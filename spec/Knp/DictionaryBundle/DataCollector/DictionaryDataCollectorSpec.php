<?php

namespace spec\Knp\DictionaryBundle\DataCollector;

use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DictionaryDataCollectorSpec extends ObjectBehavior
{
    function let(DictionaryRegistry $registry)
    {
        $this->beConstructedWith($registry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\DataCollector\DictionaryDataCollector');
    }

    function it_collects_data_from_dictionaries(Request $request, Response $response, $registry)
    {
        $registry->all()->willReturn(['foo', 'bar', 'baz']);
        $this->collect($request, $response);

        $this->getDictionaries()->shouldReturn(['foo', 'bar', 'baz']);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('dictionary');
    }
}
