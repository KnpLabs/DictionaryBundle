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
        $choiceList = function (Options $options) {
            $choices = $this->registry[$options['dictionary']]->getValues();

            return new ChoiceList(
                array_keys($choices),
                array_values($choices)
            );
        };

        $resolver->setDefaults(array(
            'dictionary'  => null,
            'choice_list' => $choiceList
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
