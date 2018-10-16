<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Templating\Extension;

use Knp\DictionaryBundle\Dictionary\Collection;
use Twig_Extension;
use Twig_Filter;
use Twig_Function;

final class Dictionary extends Twig_Extension
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
            new Twig_Function('dictionary', [$this->dictionaries, 'offsetGet']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new Twig_Filter('dictionary', function ($key, string $name) {
                return $this->dictionaries[$name][$key];
            }),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'knp_dictionary.dictionary_extension';
    }
}
