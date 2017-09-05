<?php

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Exception\DictionaryNotFoundException;

class DictionaryRegistry implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var Dictionary[]
     */
    private $dictionaries = array();

    /**
     * @param Dictionary $dictionary
     *
     * @return DictionaryRegistry
     */
    public function add(Dictionary $dictionary)
    {
        $this->set($dictionary->getName(), $dictionary);

        return $this;
    }

    /**
     * @param string     $key
     * @param Dictionary $dictionary
     *
     * @return DictionaryRegistry
     */
    public function set($key, Dictionary $dictionary)
    {
        if (isset($this->dictionaries[$key])) {
            throw new \RuntimeException(sprintf(
                'The key "%s" already exists in the dictionary registry',
                $key
            ));
        }

        $this->dictionaries[$key] = $dictionary;

        return $this;
    }

    /**
     * @return Dictionary[]
     */
    public function all()
    {
        return $this->dictionaries;
    }

    /**
     * @param mixed $offset
     *
     * @return Dictionary
     */
    public function get($offset)
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
     */
    public function offsetGet($offset)
    {
        if (false === $this->offsetExists($offset)) {
            throw new DictionaryNotFoundException(sprintf(
                'The dictionary "%s" has not been found in the registry. ' .
                'Known dictionaries are: "%s".',
                $offset,
                implode('", "', array_keys($this->dictionaries))
            ));
        }

        return $this->dictionaries[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException(
            'You can\'t use Knp\DictionaryBundle\Dictionary\Dictionary::offsetSet. Please use ' .
            'Knp\DictionaryBundle\Dictionary\Dictionary::set instead.'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        throw new \RuntimeException(
            'You can\'t destroy a dictionary registry value. It\'s used as application ' .
            'constants.'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->dictionaries);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->dictionaries);
    }
}
