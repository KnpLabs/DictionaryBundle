<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use PhpSpec\ObjectBehavior;

class LazyDictionarySpec extends ObjectBehavior
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
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\LazyDictionary');
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement('Knp\DictionaryBundle\Dictionary');
    }

    function its_getvalues_should_return_dictionary_values()
    {
        $this->getValues()->shouldReturn(array(
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ));
    }

    function it_is_hydrated_just_once()
    {
        $this->getValues()->shouldReturn(array(
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ));

        $this->getValues()->shouldReturn(array(
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ));
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

    public function execution()
    {
        if (false === $this->executed) {
            $this->executed = true;

            return  array(
                'foo' => 0,
                'bar' => 1,
                'baz' => 2,
            );
        }

        throw new \Exception('Executed twice');
    }
}
