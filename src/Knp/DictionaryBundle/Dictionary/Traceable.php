<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use Knp\DictionaryBundle\Dictionary;

/**
 * @template E
 * @implements Dictionary<E>
 */
class Traceable implements Dictionary
{
    /**
     * @var Dictionary<E>
     */
    private $dictionary;

    /**
     * @var DictionaryDataCollector
     */
    private $collector;

    /**
     * @param Dictionary<E> $dictionary
     */
    public function __construct(Dictionary $dictionary, DictionaryDataCollector $collector)
    {
        $this->dictionary = $dictionary;
        $this->collector  = $collector;
    }

    public function getName(): string
    {
        return $this->dictionary->getName();
    }

    public function getValues(): array
    {
        $this->markAsUsed();

        return $this->dictionary->getValues();
    }

    public function getKeys(): array
    {
        $this->markAsUsed();

        return $this->dictionary->getKeys();
    }

    public function offsetExists($offset): bool
    {
        $this->markAsUsed();

        return $this->dictionary->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        $this->markAsUsed();

        return $this->dictionary->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->dictionary->offsetSet($offset, $value);

        $this->markAsUsed();
    }

    public function offsetUnset($offset): void
    {
        $this->dictionary->offsetUnset($offset);

        $this->markAsUsed();
    }

    /**
     * @return Dictionary<E>
     */
    public function getIterator(): Dictionary
    {
        $this->markAsUsed();

        return $this->dictionary;
    }

    public function count(): int
    {
        $this->markAsUsed();

        return $this->dictionary->count();
    }

    /**
     * Mark this dictionary as used.
     */
    private function markAsUsed(): void
    {
        $this->collector->addDictionary(
            $this->dictionary->getName(),
            $this->dictionary->getKeys(),
            array_values($this->dictionary->getValues())
        );
    }
}
