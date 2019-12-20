<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Validator\Constraints;

use Knp\DictionaryBundle\Validator\Constraints\Dictionary;
use Knp\DictionaryBundle\Validator\Constraints\DictionaryValidator;
use PhpSpec\ObjectBehavior;

final class DictionarySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['name' => 'yolo']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Dictionary::class);
    }

    function it_adds_default_values()
    {
        $this->name->shouldReturn('yolo');
        $this->validatedBy()->shouldReturn(DictionaryValidator::class);
    }
}
