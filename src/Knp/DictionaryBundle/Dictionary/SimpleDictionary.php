<?php

namespace Knp\DictionaryBundle\Dictionary;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary as DictionaryInterface;

class SimpleDictionary implements DictionaryInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed[]|\ArrayAccess
     */
    private $keys;

    /**
     * @var mixed[]|\ArrayAccess
     */
    private $values;

    /**
     * @param string                    $name
     * @param mixed[]|\ArrayAccess      $valuesOrKeys
     * @param mixed[]|\ArrayAccess|null $values
     */
    public function __construct($name, $valuesOrKeys, $values = null)
    {
        $this->name   = $name;
        $this->keys   = null === $values ? array_keys($valuesOrKeys) : array_values($valuesOrKeys);
        $this->values = null === $values ? array_values($valuesOrKeys) : array_values($values);

        if (array_unique($this->keys) !== $this->keys) {
            throw new InvalidArgumentException('Keys have to be unique.');
        }

        if (count($this->keys) !== count($this->values)) {
            throw new InvalidArgumentException('Number of keys and values are not equals.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return array_combine($this->keys, $this->values);
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return in_array($offset, $this->keys, true);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->values[$this->indexOf($offset)];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->values[$this->indexOf($offset)] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $index = $this->indexOf($offset);

        unset($this->keys[$index], $this->values[$index]);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator(array_combine($this->keys, $this->values));
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            'name'   => $this->name,
            'keys'   => $this->keys,
            'values' => $this->values,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $this->name   = $data['name'];
        $this->keys   = $data['keys'];
        $this->values = $data['values'];
    }

    /**
     * @param mixed $offset
     *
     * @return int The position of the given $offset into the keys array
     */
    private function indexOf($offset)
    {
        if (false === in_array($offset, $this->keys, true)) {
            throw new Exception(sprintf('Undefined offset: %s”', $offset));
        }

        return array_search($offset, $this->keys, true);
    }
}
