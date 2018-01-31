<?php

namespace Knp\DictionaryBundle\Dictionary;

use ArrayIterator;
use Knp\DictionaryBundle\Dictionary as DictionaryInterface;

class SimpleDictionary implements DictionaryInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $values;

    public function __construct(string $name, array $values)
    {
        $this->name   = $name;
        $this->values = $values;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys(): array
    {
        return array_keys($this->values);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->values);
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->values[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->values[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->values[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->values);
    }
}
