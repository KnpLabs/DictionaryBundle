<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\Form\Type;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Knp\DictionaryBundle\Form\Type\DictionaryType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DictionaryTypeSpec extends ObjectBehavior
{
    function let(DictionaryRegistry $dictionaries)
    {
        $this->beConstructedWith($dictionaries);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DictionaryType::class);
    }

    function it_is_a_choice_form_type()
    {
        $this
            ->getParent()
            ->shouldReturn(ChoiceType::class);
    }

    function it_has_default_options(
        $dictionaries,
        OptionsResolver $resolver,
        Options $options,
        Dictionary $dictionary1,
        Dictionary $dictionary2
    ) {
        $dictionaries
            ->all()
            ->willReturn(['d1' => $dictionary1, 'd2' => $dictionary2]);

        $dictionaries
            ->offsetGet('d1')
            ->willReturn($dictionary1);

        $dictionary1->getValues()->willReturn(['foo' => 'bar']);

        $resolver
            ->setDefault('choices', Argument::that(function ($callable) use ($options) {
                $options->offsetGet('name')->willReturn('d1');

                return $callable($options->getWrappedObject()) === array_flip(['foo' => 'bar']);
            }))
            ->willReturn($resolver)
            ->shouldBeCalled();

        $resolver
            ->setRequired(['name'])
            ->willReturn($resolver)
            ->shouldBeCalled();

        $resolver
            ->setAllowedValues('name', ['d1', 'd2'])
            ->willReturn($resolver)
            ->shouldBeCalled();

        $this->configureOptions($resolver);
    }
}
