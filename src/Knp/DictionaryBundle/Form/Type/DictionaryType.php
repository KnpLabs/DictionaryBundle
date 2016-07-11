<?php

namespace Knp\DictionaryBundle\Form\Type;

use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DictionaryType extends AbstractType
{
    /**
     * @var DictionaryRegistry
     */
    private $registry;

    /**
     * @param DictionaryRegistry $registry
     */
    public function __construct(DictionaryRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $registry = $this->registry;

        $choices = function (Options $options) use ($registry) {
            $name    = $options['name'];
            $choices = $registry[$name]->getValues();

            return $choices;
        };

        $resolver
            ->setDefault('choices', $choices)
            ->setRequired(['name'])
            ->setAllowedValues('name', array_keys($this->registry->all()))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\ChoiceType';
    }
}
