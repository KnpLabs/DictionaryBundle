<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Form\Type;

use Knp\DictionaryBundle\Dictionary\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class DictionaryType extends AbstractType
{
    public function __construct(private Collection $dictionaries) {}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $dictionaries = $this->dictionaries;

        $choices = static function (Options $options) use ($dictionaries): array {
            $name    = $options['name'];
            $choices = $dictionaries[$name]->getValues();

            return array_flip($choices);
        };

        $resolver
            ->setDefault('choices', $choices)
            ->setRequired(['name'])
            ->setAllowedValues('name', array_keys(iterator_to_array($this->dictionaries)))
        ;
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
