<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Form\Type;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Form\Type\DictionaryType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DictionaryTypeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new Collection());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DictionaryType::class);
    }

    function it_is_a_choice_form_type()
    {
        $this
            ->getParent()
            ->shouldReturn(ChoiceType::class)
        ;
    }

    function it_has_default_options(
        OptionsResolver $resolver,
        Options $options,
        Dictionary $dictionary1,
        Dictionary $dictionary2
    ) {
        $dictionary1->getName()->willReturn('d1');
        $dictionary2->getName()->willReturn('d2');

        $dictionary1->getValues()->willReturn(['foo' => 'bar']);

        $dictionaries = new Collection($dictionary1->getWrappedObject(), $dictionary2->getWrappedObject());

        $this->beConstructedWith($dictionaries);

        $resolver
            ->setDefault('choices', Argument::that(function ($callable) use ($options) {
                $options->offsetGet('name')->willReturn('d1');

                return $callable($options->getWrappedObject()) === array_flip(['foo' => 'bar']);
            }))
            ->willReturn($resolver)
            ->shouldBeCalled()
        ;

        $resolver
            ->setRequired(['name'])
            ->willReturn($resolver)
            ->shouldBeCalled()
        ;

        $resolver
            ->setAllowedValues('name', ['d1', 'd2'])
            ->willReturn($resolver)
            ->shouldBeCalled()
        ;

        $this->configureOptions($resolver);
    }
}
