<?php

namespace Knp\DictionaryBundle\Twig;

use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;

class DictionaryExtension extends \Twig_Extension
{
    /**
     * @var DictionaryRegistry
     */
    private $dictionaries;

    /**
     * @param DictionaryRegistry $dictionaries
     */
    public function __construct(DictionaryRegistry $dictionaries)
    {
        $this->dictionaries = $dictionaries;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('dictionary', [$this, 'getDictionary']),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('dictionary', [$this, 'getValue']),
        );
    }

    /**
     * @param string $name
     *
     * @return \Knp\DictionaryBundle\Dictionary\Dictionary
     */
    public function getDictionary($name)
    {
        return $this->dictionaries->get($name);
    }

    /**
     * @param mixed  $key
     * @param string $name
     *
     * @return mixed
     */
    public function getValue($key, $name)
    {
        $dictionary = $this->dictionaries->get($name);

        return $dictionary[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'knp_dictionary.dictionary_extension';
    }
}
