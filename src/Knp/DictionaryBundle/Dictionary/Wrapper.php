<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;

/**
 * @template E
 *
 * @implements Dictionary<E>
 */
abstract class Wrapper implements Dictionary
{
    /**
     * @param Dictionary<E> $dictionary
     */
    public function __construct(private readonly Dictionary $dictionary) {}

    public function getName(): string
    {
        return $this->dictionary->getName();
    }

    public function getValues(): array
    {
        return $this->dictionary->getValues();
    }

    public function getKeys(): array
    {
        return $this->dictionary->getKeys();
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->dictionary->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->dictionary->offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->dictionary->offsetSet($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->dictionary->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->dictionary->count();
    }

    /**
     * @return Dictionary<E>
     */
    public function getIterator(): Dictionary
    {
        return $this->dictionary;
    }
}
