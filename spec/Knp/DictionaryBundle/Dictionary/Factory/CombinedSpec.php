<?php

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use Phpspec\ObjectBehavior;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\Factory\Combined;

class CombinedSpec extends ObjectBehavior
{
    function let(DictionaryRegistry $registry)
    {
        $this->beConstructedWith($registry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Combined::class);
    }

    function it_is_a_factory()
    {
        $this->shouldHaveType(Factory::class);
    }

    function it_supports_specific_config()
    {
        $this->supports(['type' => 'combined'])->shouldReturn(true);
    }

    function it_creates_a_dictionary(
        $registry,
        Dictionary $dictionary1,
        Dictionary $dictionary2,
        Dictionary $dictionary3
    ) {
        $dictionary1->getValues()->willReturn([
            'foo1' => 'foo10',
            'foo2' => 'foo20',
        ]);

        $dictionary2->getValues()->willReturn([
            'bar1' => 'bar10',
            'bar2' => 'bar20',
        ]);

        $dictionary3->getValues()->willReturn([
            'foo2' => 'baz20',
            'bar2' => 'baz20',
        ]);

        $registry->get('dictionary1')->willReturn($dictionary1);
        $registry->get('dictionary2')->willReturn($dictionary2);
        $registry->get('dictionary3')->willReturn($dictionary3);

        $config = [
            'type' => 'combined',
            'dictionaries' => [
                'dictionary1',
                'dictionary2',
                'dictionary3',
            ]
        ];

        $dictionary = $this->create('combined_dictionary', $config);

        $dictionary->getValues()->shouldReturn([
            'foo1' => 'foo10',
            'foo2' => 'baz20',
            'bar1' => 'bar10',
            'bar2' => 'baz20',
        ]);
    }
}
