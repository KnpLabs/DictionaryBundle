<?php

namespace spec\Knp\DictionaryBundle\Dictionary\Factory;

use PhpSpec\ObjectBehavior;

class ValueAsKeySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\Factory\ValueAsKey');
    }

    function it_is_a_factory()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Dictionary\Factory');
    }

    function it_supports_specific_config()
    {
        $this->supports(array('type' => 'value_as_key'))->shouldReturn(true);
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
            'content' => array('bar1', 'bar2', 'bar3'),
        );

        $dictionary = $this->create('yolo', $config);

        $dictionary->getName()->shouldBe('yolo');
        $dictionary->getValues()->shouldBe(array(
            'bar1' => 'bar1',
            'bar2' => 'bar2',
            'bar3' => 'bar3',
        ));
    }
}
