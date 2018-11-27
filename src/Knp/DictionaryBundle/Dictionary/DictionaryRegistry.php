<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Exception\DictionaryNotFoundException;
use RuntimeException;

class DictionaryRegistry implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     * @var Collection
     */
    private $collection;

    public function __construct(Collection $collection)
    {
        @trigger_error(
            sprintf(
                'Class %s is deprecated since version 2.2, to be removed in 3.0. Use %s instead.',
                __CLASS__,
                Collection::class
            ),
            E_USER_DEPRECATED
        );

        $this->collection = $collection;
    }

    /**
     * @var Dictionary[]
     */
    private $dictionaries = [];

    public function add(Dictionary $dictionary): void
    {
        $this->collection->add($dictionary);
    }

    public function set(string $key, Dictionary $dictionary): void
    {
        if (isset($this->collection[$key])) {
            throw new RuntimeException(sprintf(
                'The key "%s" already exists in the dictionary registry.',
                $key
            ));
        }

        $this->add($dictionary);
    }

    /**
     * @return Dictionary[]
     */
    public function all(): array
    {
        return iterator_to_array($this->collection);
    }

    /**
     * @throw DictionaryNotFoundException
     */
    public function get(string $offset): Dictionary
    {
        return $this->collection[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->collection[$offset]);
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

        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @throw RuntimeException
     */
    public function offsetSet($offset, $value): void
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
    public function offsetUnset($offset): void
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
        return \count($this->collection);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->collection->getIterator();
    }
}
