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

class DictionaryRegistry implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     * @var Dictionary[]
     */
    private $dictionaries = [];

    public function add(Dictionary $dictionary)
    {
        $this->set($dictionary->getName(), $dictionary);
    }

    public function set(string $key, Dictionary $dictionary)
    {
        if (isset($this->dictionaries[$key])) {
            throw new RuntimeException(sprintf(
                'The key "%s" already exists in the dictionary registry.',
                $key
            ));
        }

        $this->dictionaries[$key] = $dictionary;
    }

    /**
     * @return Dictionary[]
     */
    public function all(): array
    {
        return $this->dictionaries;
    }

    /**
     * @throw DictionaryNotFoundException
     */
    public function get(string $offset): Dictionary
    {
        return $this->offsetGet($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->dictionaries[$offset]);
    }

    /**
     * {@inheritdoc}
     *
     * @return Dictionary
     *
     * @throw DictionaryNotFoundException
     */
    public function offsetGet($offset)
    {
        if (false === $this->offsetExists($offset)) {
            throw new DictionaryNotFoundException(sprintf(
                'The dictionary "%s" has not been found in the registry. '.
                'Known dictionaries are: "%s".',
                $offset,
                implode('", "', array_keys($this->dictionaries))
            ));
        }

        return $this->dictionaries[$offset];
    }

    /**
     * {@inheritdoc}
     *
     * @throw RuntimeException
     */
    public function offsetSet($offset, $value)
    {
        throw new RuntimeException(
            'You can\'t use Knp\DictionaryBundle\Dictionary\Dictionary::offsetSet. Please use '.
            'Knp\DictionaryBundle\Dictionary\Dictionary::set instead.'
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throw RuntimeException
     */
    public function offsetUnset($offset)
    {
        throw new RuntimeException(
            'You can\'t destroy a dictionary registry value. It\'s used as application '.
            'constants.'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return \count($this->dictionaries);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->dictionaries);
    }
}
