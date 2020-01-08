<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Exception\DictionaryNotFoundException;
use RuntimeException;

/**
 * @implements ArrayAccess<string, Dictionary<mixed>>
 * @implements IteratorAggregate<string, Dictionary<mixed>>
 */
final class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var array<string, Dictionary<mixed>>
     */
    private $dictionaries = [];

    /**
     * @param array<int, Dictionary<mixed>> $dictionaries
     */
    public function __construct(Dictionary ...$dictionaries)
    {
        foreach ($dictionaries as $dictionary) {
            $this->add($dictionary);
        }
    }

    /**
     * @param Dictionary<mixed> $dictionary
     */
    public function add(Dictionary $dictionary): void
    {
        $this->dictionaries[$dictionary->getName()] = $dictionary;
    }

    public function offsetExists($offset)
    {
        return \array_key_exists($offset, $this->dictionaries);
    }

    /**
     * @param mixed $offset
     *
     * @throws DictionaryNotFoundException
     *
     * @return Dictionary<mixed>
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new DictionaryNotFoundException($offset, array_keys($this->dictionaries));
        }

        return $this->dictionaries[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        throw new RuntimeException(
            'To add a Dictionary to the Collection, use Knp\DictionaryBundle\Dictionary\Collection::add(Dictionary $dictionary).'
        );
    }

    public function offsetUnset($offset): void
    {
        throw new RuntimeException('It is not possible to remove a dictionary from the collection.');
    }

    public function getIterator()
    {
        return new ArrayIterator($this->dictionaries);
    }

    public function count(): int
    {
        return \count($this->dictionaries);
    }
}
