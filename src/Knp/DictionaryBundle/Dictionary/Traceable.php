<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use Knp\DictionaryBundle\Dictionary;

/**
 * @template E of mixed
 *
 * @implements Dictionary<E>
 */
final class Traceable implements Dictionary
{
    /**
     * @param Dictionary<E> $dictionary
     */
    public function __construct(private Dictionary $dictionary, private DictionaryDataCollector $collector) {}

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

    public function offsetExists(mixed $offset): bool
    {
        $this->markAsUsed();

        return $this->dictionary->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        $this->markAsUsed();

        return $this->dictionary->offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->dictionary->offsetSet($offset, $value);

        $this->markAsUsed();
    }

    public function offsetUnset(mixed $offset): void
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
