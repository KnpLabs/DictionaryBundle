<?php

namespace spec\Knp\DictionaryBundle\Validator\Constraints;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Knp\DictionaryBundle\Validator\Constraints\Dictionary as Constraint;
use Knp\DictionaryBundle\Validator\Constraints\DictionaryValidator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class DictionaryValidatorSpec extends ObjectBehavior
{
    function let(
        DictionaryRegistry $dictionaries,
        ExecutionContextInterface $context,
        Dictionary $dictionary
    ) {
        $this->beConstructedWith($dictionaries);
        $this->initialize($context);

        $dictionaries->get('dico')->willReturn($dictionary);

        $dictionary->getKeys()->willReturn(['the_key']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DictionaryValidator::class);
    }

    function it_valids_existing_keys($context)
    {
        $constraint = new Constraint(['name' => 'dico']);

        $context->addViolation(Argument::any())->shouldNotBeCalled();

        $this->validate('the_key', $constraint);
    }

    function it_adds_violation_for_an_unexisting_keys($context)
    {
        $constraint = new Constraint(['name' => 'dico']);

        $context->addViolation('The key {{ key }} doesn\'t exist in the given dictionary. {{ keys }} available.', ['{{ key }}' => 'the_unexisting_key', '{{ keys }}' => 'the_key'])->shouldBeCalled();

        $this->validate('the_unexisting_key', $constraint);
    }

    function it_throw_exception_form_unknown_constraints()
    {
        $constraint = new NotNull();
        $this->shouldThrow(new UnexpectedTypeException($constraint, Constraint::class))->duringValidate('the_key', $constraint);
    }
}
