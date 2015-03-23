<?php

namespace Knp\DictionaryBundle\Form\Type;

use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choices = function (Options $options) {
            $name    = $options['name'];
            $choices = $this->registry[$name]->getValues();

            return $choices;
        };

        $resolver->setDefaults(array('name'    => null, 'choices' => $choices));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dictionary';
    }
}
