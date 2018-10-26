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

    function it_can_iterate_over_dictionaries($dictionary1, $dictionary2, $dictionary3)
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
            'foo2' => 'baz20',
            'bar2' => 'baz20',
        ]));

        $this->shouldIterateOver([
            'foo1' => 'foo10',
            'foo2' => 'baz20',
            'bar1' => 'bar10',
            'bar2' => 'baz20',
        ]);
    }

    function it_sums_the_count_of_elements($dictionary1, $dictionary2, $dictionary3)
    {
        $dictionary1->count()->willReturn(1);

        $dictionary2->count()->willReturn(2);

        $dictionary3->count()->willReturn(4);

        $this->count()->shouldReturn(7);
    }

    function its_getname_should_return_dictionary_name()
    {
        $this->getName()->shouldReturn('combined_dictionary');
    }

    public function getMatchers(): array
    {
        return [
            'iterateOver' => function (IteratorAggregate $iterator, array $array): bool {
                Assert::that(iterator_to_array($iterator))->eq($array);

                return true;
            },
        ];
    }
}
