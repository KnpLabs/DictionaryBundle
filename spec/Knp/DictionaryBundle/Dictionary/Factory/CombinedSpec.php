<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\Factory\Combined;
use PhpSpec\ObjectBehavior;

class CombinedSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new Collection());
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

    function it_creates_a_dictionary(Dictionary $dictionary1, Dictionary $dictionary2, Dictionary $dictionary3)
    {
        $dictionary1->getValues()->willReturn([
            'foo1' => 'foo10',
            'foo2' => 'foo20',
        ]);
        $dictionary1->getName()->willReturn('dictionary1');

        $dictionary2->getValues()->willReturn([
            'bar1' => 'bar10',
            'bar2' => 'bar20',
        ]);
        $dictionary2->getName()->willReturn('dictionary2');

        $dictionary3->getValues()->willReturn([
            'foo2' => 'baz20',
            'bar2' => 'baz20',
        ]);
        $dictionary3->getName()->willReturn('dictionary3');

        $this->beConstructedWith(new Collection($dictionary1->getWrappedObject(), $dictionary2->getWrappedObject(), $dictionary3->getWrappedObject()));

        $config = [
            'type'         => 'combined',
            'dictionaries' => [
                'dictionary1',
                'dictionary2',
                'dictionary3',
            ],
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
