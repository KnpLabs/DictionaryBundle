<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Dictionary;

use Exception;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Iterator;
use PhpSpec\ObjectBehavior;

final class IteratorSpec extends ObjectBehavior
{
    /**
     * @var bool
     */
    private $executed;

    function let()
    {
        $this->executed = false;

        $this->beConstructedWith('foo', $this->execution());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Iterator::class);
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement(Dictionary::class);
    }

    function it_supports_some_array_access_functions()
    {
        $dictionary = $this->getWrappedObject();

        $this['foo']->shouldBe(0);
        $this->offsetExists('foo')->shouldReturn(true);

        $this['foo'] = 'test';
        $this['foo']->shouldBe('test');

        unset($dictionary['foo']);
        $this->offsetExists('foo')->shouldReturn(false);
    }

    function it_provides_a_set_of_values()
    {
        $this->getValues()->shouldReturn([
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);
    }

    function it_provides_a_set_of_keys()
    {
        $this->getKeys()->shouldReturn([
            'foo',
            'bar',
            'baz',
        ]);
    }

    function it_is_hydrated_just_once()
    {
        $this->getValues()->shouldReturn([
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);

        $this->getValues()->shouldReturn([
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);
    }

    function it_access_to_value_like_an_array()
    {
        $this['foo']->shouldReturn(0);
        $this['bar']->shouldReturn(1);
        $this['baz']->shouldReturn(2);
    }

    function it_generates_an_iterator()
    {
        $this->shouldIterateLike([
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);
    }

    function its_getname_should_return_dictionary_name()
    {
        $this->getName()->shouldReturn('foo');
    }

    private function execution(): iterable
    {
        if (!$this->executed) {
            $this->executed = true;

            yield 'foo' => 0;
            yield 'bar' => 1;
            yield 'baz' => 2;

            return;
        }

        throw new Exception('Executed twice.');
    }
}
