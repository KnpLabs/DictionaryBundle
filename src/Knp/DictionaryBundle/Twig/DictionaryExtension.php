<?php

namespace Knp\DictionaryBundle\Twig;

use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;

class DictionaryExtension extends \Twig_Extension
{
    /**
     * @var Dictionarydictionaries
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
            'dictionary' => new \Twig_Function_Method($this, 'getData'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            'dictionary' => new \Twig_Filter_Method($this, 'getData'),
        );
    }

    /**
     * @param mixed $key
     * @param mixed|null $name
     *
     * @return mixed|Knp\DictionaryBundle\Dictionary\Dictionary if $name !== null, the value $key is searched into the dictionary $name, else the dictionary $key is returned
     */
    public function getData($key, $name = null)
    {
        if (null === $name) {
            return $this->dictionaries->get($key);
        }

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
