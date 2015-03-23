<?php

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Exception\DictionaryNotFoundException;

class DictionaryRegistry implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var Dictionary[]
     */
    private $dictionaries = array();

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
     * @param mixed $offset
     *
     * @return Dictionary
     */
    public function get($offset)
    {
        return $this->offsetGet($offset);
    }

    /**
     * @param mixed $offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->dictionaries[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return Dictionary
     *
     * @throws DictionaryNotFoundException
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
     * @param mixed $offset
     * @param mixed $value
     *
     * @throws \RuntimeException
     */
    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException(
            'You can\'t use Knp\DictionaryBundle\Dictionary\Dictionary::offsetSet. Please use '.
            'Knp\DictionaryBundle\Dictionary\Dictionary::set instead.'
        );
    }

    /**
     * @param mixed $offset
     *
     * @throws \RuntimeException
     */
    public function offsetUnset($offset)
    {
        throw new \RuntimeException(
            'You can\'t destroy a dictionary registry value. It\'s used as application '.
            'constants.'
        );
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->dictionaries);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->dictionaries);
    }
}
