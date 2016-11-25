<?php

namespace Knp\DictionaryBundle\Form\Type;

use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $choices = function(Options $options) {
            $name = $options['name'];

            return $this->registry[$name]->getValues();
        };

        $resolver->setDefaults([
            'name'    => null,
            'choices' => $choices,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // For Symfony 2.x compatibility.

        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return Kernel::MAJOR_VERSION >= 3
            ? 'Symfony\Component\Form\Extension\Core\Type\ChoiceType'
            : 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dictionary';
    }
}
