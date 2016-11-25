<?php

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use PhpSpec\ObjectBehavior;

class KeyValueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\Factory\KeyValue');
    }

    function it_is_a_factory()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\Factory');
    }

    function it_supports_specific_config()
    {
        $this->supports(array('type' => 'key_value'))->shouldReturn(true);
    }

    function it_throws_exception_if_no_content_is_provided()
    {
        $this
            ->shouldThrow('\InvalidArgumentException')
            ->during('create', array('yolo', array()))
        ;
    }

    function it_creates_a_dictionary()
    {
        $config = array(
            'content' => array(
                'foo1' => 'bar1',
                'foo2' => 'bar2',
                'foo3' => 'bar3',
            ),
        );

        $dictionary = $this->create('yolo', $config);

        $dictionary->getName()->shouldBe('yolo');
        $dictionary->getValues()->shouldBe(array(
            'foo1' => 'bar1',
            'foo2' => 'bar2',
            'foo3' => 'bar3',
        ));
    }
}
