<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Form\Type;

use Knp\DictionaryBundle\Dictionary\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DictionaryType extends AbstractType
{
    /**
     * @var Collection
     */
    private $dictionaries;

    public function __construct(Collection $dictionaries)
    {
        $this->dictionaries = $dictionaries;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $dictionaries = $this->dictionaries;

        $choices = function (Options $options) use ($dictionaries) {
            $name    = $options['name'];
            $choices = $dictionaries[$name]->getValues();

            return array_flip($choices);
        };

        $resolver
            ->setDefault('choices', $choices)
            ->setRequired(['name'])
            ->setAllowedValues('name', array_keys(iterator_to_array($this->dictionaries)));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ChoiceType::class;
    }
}
