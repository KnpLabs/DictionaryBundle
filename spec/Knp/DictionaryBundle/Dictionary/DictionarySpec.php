<?php

namespace spec\Knp\DictionaryBundle\Dictionary;

use PhpSpec\ObjectBehavior;

class DictionarySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('foo', [
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ]);
    }
    
    public function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\Dictionary');
    }
    
    public function its_getvalues_should_return_dictionary_values()
    {
        $this->getValues()->shouldReturn([
            'foo' => 0,
            'bar' => 1,
            'baz' => 2,
        ])
        ;
    }
    
    public function its_getname_should_return_dictionary_name()
    {
        $this->getName()->shouldReturn('foo');
    }
    
    public function it_access_to_value_like_an_array()
    {
        expect($this['foo']->getWrappedObject())->toBe(0);
        expect($this['bar']->getWrappedObject())->toBe(1);
        expect($this['baz']->getWrappedObject())->toBe(2);
    }
}
