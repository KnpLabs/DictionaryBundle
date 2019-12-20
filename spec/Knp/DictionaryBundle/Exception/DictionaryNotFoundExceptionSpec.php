<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Exception;

use Knp\DictionaryBundle\Exception\DictionaryNotFoundException;
use PhpSpec\ObjectBehavior;

final class DictionaryNotFoundExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('dico_name');

        $this->shouldHaveType(DictionaryNotFoundException::class);
    }

    function it_can_be_build_with_just_a_dictionary_name()
    {
        $this->beConstructedWith('dico_name');

        $this->getMessage()->shouldReturn('The dictionary "dico_name" has not been found in the registry.');
    }

    function it_can_be_build_with_a_dictionary_name_and_a_list_of_known_dictionaries()
    {
        $this->beConstructedWith('dico_name', ['dico1', 'dico2']);

        $this->getMessage()->shouldReturn('The dictionary "dico_name" has not been found in the registry. Known dictionaries are: "dico1", "dico2".');
    }
}
