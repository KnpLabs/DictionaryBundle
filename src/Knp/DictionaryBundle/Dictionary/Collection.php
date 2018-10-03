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

final class Collection implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     * @var Dictionary[]
     */
    private $dictionaries;

    public function __construct(Dictionary ...$dictionaries)
    {
        foreach ($dictionaries as $dictionary) {
            $this->add($dictionary);
        }
    }

    public function add(Dictionary $dictionary)
    {
        $this->dictionaries[$dictionary->getName()] = $dictionary;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->dictionaries);
    }

    public function offsetGet($offset)
    {
        if (false === $this->offsetExists($offset)) {
            throw new DictionaryNotFoundException(sprintf(
                'The dictionary "%s" has not been found in the dictionaries collection. '.
                'Known dictionaries are: "%s".',
                $offset,
                implode('", "', array_keys($this->dictionaries))
            ));
        }

        return $this->dictionaries[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new RuntimeException(
            'To add a Dictionary to the Collection, use Knp\DictionaryBundle\Dictionary\Collection::add(Dictionary $dictionary).'
        );
    }

    public function offsetUnset($offset)
    {
        throw new RuntimeException('It is not possible to remove a dictionary from the collection.');
    }

    public function getIterator()
    {
        return new ArrayIterator($this->dictionaries);
    }

    public function count()
    {
        return \count($this->dictionaries);
    }
}
