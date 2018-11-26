<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary;

use ArrayIterator;
use Knp\DictionaryBundle\Dictionary;
use PhpSpec\ObjectBehavior;
use Traversable;

class CombinedSpec extends ObjectBehavior
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
        $this->shouldHaveType(Dictionary\Combined::class);
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement(Dictionary::class);
    }

    function it_access_to_value_like_an_array($dictionary1, $dictionary2, $dictionary3)
    {
        $dictionary1->getIterator()->willReturn(new ArrayIterator(['foo1' => 'foo10']));

        $dictionary2->getIterator()->willReturn(new ArrayIterator(['bar1' => 'bar10']));

        $dictionary3->getIterator()->willReturn(new ArrayIterator(['baz1' => 'baz10']));

        $this['foo1']->shouldBe('foo10');
        $this['bar1']->shouldBe('bar10');
        $this['baz1']->shouldBe('baz10');
    }

    function it_getvalues_should_return_dictionaries_values($dictionary1, $dictionary2, $dictionary3)
    {
        $dictionary1->getIterator()->willReturn(new ArrayIterator([
            'foo1' => 'foo10',
            'foo2' => 'foo20',
        ]));

        $dictionary2->getIterator()->willReturn(new ArrayIterator([
            'bar1' => 'bar10',
            'bar2' => 'bar20',
        ]));

        $dictionary3->getIterator()->willReturn(new ArrayIterator([
            'foo1' => 'baz10',
            'bar2' => 'baz20',
        ]));

        $this->getKeys()->shouldReturn([
            'foo1',
            'foo2',
            'bar1',
            'bar2',
        ]);
        $this->getValues()->shouldReturn([
            'foo1' => 'baz10',
            'foo2' => 'foo20',
            'bar1' => 'bar10',
            'bar2' => 'baz20',
        ]);
    }

    function it_can_merge_dictionaries_naturally_indexed($dictionary1, $dictionary2, $dictionary3)
    {
        $dictionary1->getIterator()->willReturn(new ArrayIterator([
            'foo10',
            'foo20',
        ]));

        $dictionary2->getIterator()->willReturn(new ArrayIterator([
            'bar10',
            'bar20',
        ]));

        $dictionary3->getIterator()->willReturn(new ArrayIterator([
            'baz10',
            'baz20',
        ]));

        $this->shouldIterateOn([
            'foo10',
            'foo20',
            'bar10',
            'bar20',
            'baz10',
            'baz20',
        ]);
    }

    function its_getname_should_return_dictionary_name()
    {
        $this->getName()->shouldReturn('combined_dictionary');
    }

    public function getMatchers(): array
    {
        return [
            'iterateOn' => function (Traversable $iterator, array $array) {
                return iterator_to_array($iterator) === $array;
            },
        ];
    }
}
