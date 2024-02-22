<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
use Traversable;

/**
 * @template TKey of (int|string)
 * @template TValue
 *
 * @implements Dictionary<TKey, TValue>
 */
abstract class Wrapper implements Dictionary
{
    /**
     * @param Dictionary<TKey, TValue> $wrapped
     */
    public function __construct(private Dictionary $wrapped) {}

    public function getName(): string
    {
        return $this->wrapped->getName();
    }

    public function getValues(): array
    {
        return $this->wrapped->getValues();
    }

    public function getKeys(): array
    {
        return $this->wrapped->getKeys();
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->wrapped->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->wrapped->offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->wrapped->offsetSet($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->wrapped->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->wrapped->count();
    }

    public function getIterator(): Traversable
    {
        yield from $this->wrapped;
    }
}
