<?php

namespace Knp\DictionaryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class DictionaryType extends AbstractType
{
    private $registry;

    public function __construct(DictionaryRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choices = function (Options $options) {
            $name    = $options['name'];
            $choices = $this->registry[$name]->getValues();

            return $choices;
        };

        $resolver->setDefaults(array(
            'name'    => null,
            'choices' => $choices
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'dictionary';
    }
}
