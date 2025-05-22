<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Templating\Extension;

use Knp\DictionaryBundle\Dictionary\Collection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class Dictionary extends AbstractExtension
{
    public function __construct(private Collection $collection) {}

    /**
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('dictionary', $this->collection->offsetGet(...)),
        ];
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('dictionary', fn ($key, string $name): mixed => $this->collection[$name][$key]),
        ];
    }
}
