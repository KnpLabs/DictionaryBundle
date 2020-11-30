<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use Knp\DictionaryBundle\Dictionary;

/**
 * @template E
 * @implements Dictionary<E>
 */
final class Traceable implements Dictionary
{
    /**
     * @var Dictionary<E>
     */
    private $traced;

    /**
     * @var DictionaryDataCollector
     */
    private $collector;

    /**
     * @param Dictionary<E> $traced
     */
    public function __construct(Dictionary $traced, DictionaryDataCollector $collector)
    {
        $this->traced = $traced;
        $this->collector  = $collector;
    }

    /**
     * @return Dictionary<E>
     */
    public function getTraced(): Dictionary
    {
        return $this->traced;
    }

    public function getName(): string
    {
        return $this->traced->getName();
    }

    public function getValues(): array
    {
        $this->markAsUsed();

        return $this->traced->getValues();
    }

    public function getKeys(): array
    {
        $this->markAsUsed();

        return $this->traced->getKeys();
    }

    public function offsetExists($offset): bool
    {
        $this->markAsUsed();

        return $this->traced->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        $this->markAsUsed();

        return $this->traced->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->traced->offsetSet($offset, $value);

        $this->markAsUsed();
    }

    public function offsetUnset($offset): void
    {
        $this->traced->offsetUnset($offset);

        $this->markAsUsed();
    }

    /**
     * @return Dictionary<E>
     */
    public function getIterator(): Dictionary
    {
        $this->markAsUsed();

        return $this->traced;
    }

    public function count(): int
    {
        $this->markAsUsed();

        return $this->traced->count();
    }

    /**
     * Mark this dictionary as used.
     */
    private function markAsUsed(): void
    {
        $this->collector->addDictionary(
            $this->traced->getName(),
            $this->traced->getKeys(),
            array_values($this->traced->getValues())
        );
    }
}
