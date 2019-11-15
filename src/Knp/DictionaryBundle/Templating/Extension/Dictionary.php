<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Templating\Extension;

use Knp\DictionaryBundle\Dictionary\Collection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class Dictionary extends AbstractExtension
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
            new TwigFunction('dictionary', [$this->dictionaries, 'offsetGet']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('dictionary', function ($key, string $name) {
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
