<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
use PhpSpec\ObjectBehavior;

class CombinedDictionarySpec extends ObjectBehavior
{
    function let(Dictionary $dictionary1, Dictionary $dictionary2, Dictionary $dictionary3)
    {
        $this->beConstructedWith('combined_dictionary', [
            $dictionary1,
            $dictionary2,
            $dictionary3,
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Dictionary\CombinedDictionary::class);
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement(Dictionary::class);
    }

    function it_access_to_value_like_an_array($dictionary1, $dictionary2, $dictionary3)
    {
        $dictionary1->offsetExists('foo1')->willReturn(true);
        $dictionary1->offsetGet('foo1')->willReturn('foo10');

        $dictionary1->offsetExists('bar1')->willReturn(false);
        $dictionary2->offsetExists('bar1')->willReturn(true);
        $dictionary2->offsetGet('bar1')->willReturn('bar10');

        $dictionary1->offsetExists('baz1')->willReturn(false);
        $dictionary2->offsetExists('baz1')->willReturn(false);
        $dictionary3->offsetExists('baz1')->willReturn(true);
        $dictionary3->offsetGet('baz1')->willReturn('baz10');

        $this['foo1']->shouldBe('foo10');
        $this['bar1']->shouldBe('bar10');
        $this['baz1']->shouldBe('baz10');
    }

    function it_getvalues_should_return_dictionaries_values($dictionary1, $dictionary2, $dictionary3)
    {
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

        $this->getValues()->shouldReturn([
            'foo1' => 'foo10',
            'foo2' => 'baz20',
            'bar1' => 'bar10',
            'bar2' => 'baz20',
        ]);
    }

    function its_getname_should_return_dictionary_name()
    {
        $this->getName()->shouldReturn('combined_dictionary');
    }
}
