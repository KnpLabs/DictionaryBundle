<?php

namespace spec\Knp\DictionaryBundle\Form\Type;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DictionaryTypeSpec extends ObjectBehavior
{
    function let(DictionaryRegistry $registry)
    {
        $this->beConstructedWith($registry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\Form\Type\DictionaryType');
    }

    function it_is_a_choice_form_type()
    {
        $this
            ->getParent()
            ->shouldReturn('Symfony\Component\Form\Extension\Core\Type\ChoiceType')
        ;
    }

    function it_has_default_options(
        $registry,
        OptionsResolver $resolver,
        Options $options,
        Dictionary $dictionary1,
        Dictionary $dictionary2
    ) {
        $registry
            ->all()
            ->willReturn(['d1' => $dictionary1, 'd2' => $dictionary2])
        ;

        $registry
            ->offsetGet('d1')
            ->willReturn($dictionary1)
        ;

        $dictionary1->getValues()->willReturn(['foo' => 'bar']);

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
