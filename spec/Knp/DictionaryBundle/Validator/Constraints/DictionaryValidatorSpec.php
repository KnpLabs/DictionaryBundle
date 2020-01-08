<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Validator\Constraints;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Validator\Constraints\Dictionary as Constraint;
use Knp\DictionaryBundle\Validator\Constraints\DictionaryValidator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class DictionaryValidatorSpec extends ObjectBehavior
{
    function let(ExecutionContextInterface $context, Dictionary $dictionary)
    {
        $dictionary->getName()->willReturn('dico');
        $dictionary->getKeys()->willReturn(['the_key']);

        $dictionaries = new Collection($dictionary->getWrappedObject());

        $this->beConstructedWith($dictionaries);
        $this->initialize($context);
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

        $context->addViolation(
            "The key {{ key }}{{ keyType }} doesn't exist in the given dictionary. {{ keys }}{{ keysType }} available.",
            [
                '{{ key }}'      => 'the_unexisting_key',
                '{{ keyType }}'  => '',
                '{{ keys }}'     => 'the_key',
                '{{ keysType }}' => '',
            ]
        )->shouldBeCalled();

        $this->validate('the_unexisting_key', $constraint);
    }

    function it_adds_violation_for_an_unmathching_key_type($context, Dictionary $dictionary)
    {
        $dictionary->getName()->willReturn('dico');
        $dictionary->getKeys()->willReturn([0]);
        $constraint = new Constraint(['name' => 'dico']);

        $context->addViolation(
            "The key {{ key }}{{ keyType }} doesn't exist in the given dictionary. {{ keys }}{{ keysType }} available.",
            [
                '{{ key }}'      => '0',
                '{{ keyType }}'  => ' (string)',
                '{{ keys }}'     => 0,
                '{{ keysType }}' => ' (integer)',
            ]
        )->shouldBeCalled();

        $this->validate('0', $constraint);
    }

    function it_throw_exception_form_unknown_constraints()
    {
        $constraint = new NotNull();
        $this->shouldThrow(new UnexpectedTypeException($constraint, Constraint::class))->duringValidate('the_key', $constraint);
    }
}
