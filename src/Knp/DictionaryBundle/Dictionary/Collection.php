<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Exception\DictionaryNotFoundException;
use RuntimeException;
use Traversable;

/**
 * @implements ArrayAccess<string, Dictionary<int|string, mixed>>
 * @implements IteratorAggregate<string, Dictionary<int|string, mixed>>
 */
final class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var array<string, Dictionary<int|string, mixed>>
     */
    private array $dictionaries = [];

    /**
     * @param Dictionary<int|string, mixed> ...$dictionaries
     */
    public function __construct(Dictionary ...$dictionaries)
    {
        foreach ($dictionaries as $dictionary) {
            $this->add($dictionary);
        }
    }

    /**
     * @param Dictionary<int|string, mixed> $dictionary
     */
    public function add(Dictionary $dictionary): void
    {
        $this->dictionaries[$dictionary->getName()] = $dictionary;
    }

    public function offsetExists(mixed $offset): bool
    {
        return \array_key_exists($offset, $this->dictionaries);
    }

    /**
     * @return Dictionary<int|string, mixed>
     *
     * @throws DictionaryNotFoundException
     */
    public function offsetGet(mixed $offset): mixed
    {
        if (!$this->offsetExists($offset)) {
            throw new DictionaryNotFoundException($offset, array_keys($this->dictionaries));
        }

        return $this->dictionaries[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new RuntimeException(
            'To add a Dictionary to the Collection, use Knp\DictionaryBundle\Dictionary\Collection::add(Dictionary $dictionary).'
        );
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new RuntimeException('It is not possible to remove a dictionary from the collection.');
    }

    public function getIterator(): Traversable
    {
        return yield from $this->dictionaries;
    }

    public function count(): int
    {
        return \count($this->dictionaries);
    }
}
