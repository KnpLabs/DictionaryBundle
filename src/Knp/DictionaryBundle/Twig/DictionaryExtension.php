<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Twig;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class DictionaryExtension extends \Twig_Extension
{
    /**
     * @var DictionaryRegistry
     */
    private $dictionaries;

    public function __construct(DictionaryRegistry $dictionaries)
    {
        $this->dictionaries = $dictionaries;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('dictionary', [$this, 'getDictionary']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('dictionary', [$this, 'getValue']),
        ];
    }

    public function getDictionary(string $name): Dictionary
    {
        return $this->dictionaries->get($name);
    }

    public function getValue($key, string $name)
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
