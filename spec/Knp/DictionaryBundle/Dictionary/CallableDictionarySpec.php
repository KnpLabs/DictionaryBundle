<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use Exception;
use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\CallableDictionary;
use PhpSpec\ObjectBehavior;
use Webmozart\Assert\Assert;

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
        $this->shouldHaveType(CallableDictionary::class);
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement(Dictionary::class);
    }

    function it_supports_callable_arguments()
    {
        $this->beConstructedWith('baz', function () {
            return call_user_func_array([$this, 'execution'], func_get_args());
        }, [['foo' => 2, 'bar' => 1, 'baz' => 0]]);

        $this->getValues()->shouldReturn(['foo' => 2, 'bar' => 1, 'baz' => 0]);
    }

    function it_supports_some_array_access_functions()
    {
        $dictionary = $this->getWrappedObject();

        Assert::eq($dictionary['foo'], 0);
        Assert::eq(isset($dictionary['foo']), true);

        $dictionary['foo'] = 'test';
        Assert::eq($dictionary['foo'], 'test');

        unset($dictionary['foo']);
        Assert::eq(isset($dictionary['foo']), false);
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
        Assert::eq($this['foo']->getWrappedObject(), 0);
        Assert::eq($this['bar']->getWrappedObject(), 1);
        Assert::eq($this['baz']->getWrappedObject(), 2);
    }

    function it_throws_an_exception_if_callable_returns_somthing_else_than_an_array_or_an_array_access(
        $nothing
    ) {
        $this->beConstructedWith('foo', function () {
        });

        $this
            ->shouldThrow(new InvalidArgumentException('Dictionary callable must return an array or an instance of ArrayAccess'))
            ->duringGetValues();
    }

    function it_generates_an_iterator()
    {
        $iterator = $this->getIterator();
        $iterator->shouldHaveType('Iterator');

        Assert::eq(iterator_to_array($iterator->getWrappedObject()), [
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);
    }

    function its_getname_should_return_dictionary_name()
    {
        $this->getName()->shouldReturn('foo');
    }

    public function execution()
    {
        if (false === $this->executed) {
            $this->executed = true;
            $args           = func_get_args();

            return !empty($args) ? current($args) : [
                'foo' => 0,
                'bar' => 1,
                'baz' => 2,
            ];
        }

        throw new Exception('Executed twice');
    }
}
