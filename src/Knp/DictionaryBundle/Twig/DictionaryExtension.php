<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Twig;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class DictionaryExtension extends \Twig_Extension
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
        return $this->dictionaries[$name];
    }

    public function getValue($key, string $name)
    {
        $dictionary = $this->dictionaries[$name];

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
