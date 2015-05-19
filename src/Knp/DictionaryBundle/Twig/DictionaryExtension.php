<?php

namespace Knp\DictionaryBundle\Twig;

use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;

class DictionaryExtension extends \Twig_Extension
{
    /**
     * @var DictionaryRegistry
     */
    private $registry;

    /**
     *
     * @param DictionaryRegistry $registry
     */
    public function __construct(DictionaryRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'dictionary' => new \Twig_Filter_Method($this, 'getDictionary'),
        );
    }

    public function getName()
    {
        return 'knp_dictionary.dictionary_extension';
    }

    /**
     * @param $dictionaryName
     * @return \Knp\DictionaryBundle\Dictionary\Dictionary
     */
    public function getDictionary($dictionaryName)
    {
        return $this->registry->get($dictionaryName);
    }
}
