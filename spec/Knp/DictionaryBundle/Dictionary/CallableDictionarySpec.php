<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use PhpSpec\ObjectBehavior;

class CallableDictionarySpec extends ObjectBehavior
{
    /**
     * @var bool
     */
    private $executed;

    function let()
    {
        $this->executed = false;

        $context = $this;

        $this->beConstructedWith('foo', function () use ($context) {
            return $context->execution();
        });
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\CallableDictionary');
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement('Knp\DictionaryBundle\Dictionary');
    }

    function it_supports_some_array_access_functions()
    {
        $dictionary = $this->getWrappedObject();

        expect($dictionary['foo'])->toBe(0);
        expect(isset($dictionary['foo']))->toBe(true);

        $dictionary['foo'] = 'test';
        expect($dictionary['foo'])->toBe('test');

        unset($dictionary['foo']);
        expect(isset($dictionary['foo']))->toBe(false);
    }

    function it_contains_original_values_after_unserialization_if_the_original_dictionary_is_hydrated_first()
    {
        // should hydrate the original dictionary
        $this->getValues()->shouldReturn(array('foo' => 0, 'bar' => 1, 'baz' => 2));

        $dictionary = unserialize(serialize($this->getWrappedObject()));

        expect($dictionary['foo'])->toBe(0);
        expect(isset($dictionary['foo']))->toBe(true);
    }

    function it_contains_nothing_after_unserialization_if_the_original_dictionary_is_not_hydrated_first()
    {
        $dictionary = unserialize(serialize($this->getWrappedObject()));

        expect(isset($dictionary['foo']))->toBe(false);
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

    function its_getname_should_return_dictionary_name()
    {
        $this->getName()->shouldReturn('foo');
    }

    function it_access_to_value_like_an_array()
    {
        expect($this['foo']->getWrappedObject())->toBe(0);
        expect($this['bar']->getWrappedObject())->toBe(1);
        expect($this['baz']->getWrappedObject())->toBe(2);
    }

    function it_throws_an_exception_if_callable_returns_somthing_else_than_an_array_or_an_array_access($nothing)
    {
        $this->beConstructedWith('foo', function () {
        });

        $this
            ->shouldThrow(new \InvalidArgumentException('Dictionary callable must return an array or an instance of ArrayAccess'))
            ->duringGetValues()
        ;
    }

    function it_generates_an_iterator()
    {
        $iterator = $this->getIterator();
        $iterator->shouldHaveType('Iterator');

        expect(iterator_to_array($iterator->getWrappedObject()))->toBe([
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);
    }

    public function execution()
    {
        if (false === $this->executed) {
            $this->executed = true;

            return  [
                'foo' => 0,
                'bar' => 1,
                'baz' => 2,
            ];
        }

        throw new \Exception('Executed twice');
    }
}
