<?php

namespace Knp\DictionaryBundle\Dictionary;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\DictionaryCollection;

class DictionaryRegistry implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     * @var DictionaryCollection
     */
    private $collection;

    public function __construct(DictionaryCollection $collection)
    {
        @trigger_error(
            sprintf(
                'Class %s is deprecated since version 2.1, to be removed in 3.0. Use %s instead.',
                __CLASS__,
                DictionaryCollection::class
            ),
            E_USER_DEPRECATED
        );

        $this->collection = $collection;
    }

    public function add(Dictionary $dictionary)
    {
        $this->collection->add($dictionary);
    }

    public function set(string $key, Dictionary $dictionary)
    {
        $this->collection->set($key, $dictionary);
    }

    /**
     * @return Dictionary[]
     */
    public function all(): array
    {
        return $this->collection->all();
    }

    /**
     * @throw DictionaryNotFoundException
     */
    public function get(string $offset): Dictionary
    {
        return $this->collection->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->collection->offsetExists($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @return Dictionary
     *
     * @throw \Knp\DictionaryBundle\Exception\DictionaryNotFoundException
     */
    public function offsetGet($offset)
    {
        return $this->collection->offsetGet($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @throw RuntimeException
     */
    public function offsetSet($offset, $value)
    {
        return $this->collection->offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     *
     * @throw RuntimeException
     */
    public function offsetUnset($offset)
    {
        return $this->collection->offsetUnset($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->collection->count();
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->collection;
    }
}
