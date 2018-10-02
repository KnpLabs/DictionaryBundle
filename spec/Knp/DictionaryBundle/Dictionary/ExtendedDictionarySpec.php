<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary\ExtendedDictionary;
use Knp\DictionaryBundle\Dictionary;
use Phpspec\ObjectBehavior;
use Webmozart\Assert\Assert;

class ExtendedDictionarySpec extends ObjectBehavior
{
    function let(Dictionary $initialDictionary, Dictionary $extendedDictionary) {
        $initialDictionary->getValues()->willReturn(['foo1' => 'foo1', 'foo2' => 'foo2']);
        $extendedDictionary->getValues()->willReturn(['bar1' => 'bar1', 'bar2' => 'bar2']);

        $this->beConstructedWith('foo', $initialDictionary, $extendedDictionary);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ExtendedDictionary::class);
    }

    function it_is_a_dictionary()
    {
        $this->shouldImplement(Dictionary::class);
    }

    function it_access_to_value_like_an_array()
    {
        Assert::eq($this['foo1']->getWrappedObject(), 'foo1');
        Assert::eq($this['foo2']->getWrappedObject(), 'foo2');
        Assert::eq($this['bar1']->getWrappedObject(), 'bar1');
        Assert::eq($this['bar2']->getWrappedObject(), 'bar2');
    }

    function its_getvalues_should_return_dictionary_values()
    {
        $this->getValues()->shouldReturn([
            'foo1' => 'foo1',
            'foo2' => 'foo2',
            'bar1' => 'bar1',
            'bar2' => 'bar2',
        ]);
    }

    function its_getname_should_return_dictionary_name()
    {
        $this->getName()->shouldReturn('foo');
    }
}
