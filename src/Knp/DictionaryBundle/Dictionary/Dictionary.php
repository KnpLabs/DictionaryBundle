<?php

namespace Knp\DictionaryBundle\Dictionary;

class Dictionary implements \ArrayAccess, \IteratorAggregate, \Serializable
{
    const VALUE = 'value';

    const VALUE_AS_KEY = 'value_as_key';

    const KEY_VALUE = 'key_value';

    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed[]
     */
    private $values = array();

    /**
     * @param string  $name
     * @param mixed[] $values
     */
    public function __construct($name, array $values)
    {
        $this->name   = $name;
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed[]
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return mixed[]
     */
    public function getKeys()
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
        return new \ArrayIterator($this->values);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
            'name'   => $this->name,
            'values' => $this->values,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $this->name   = $data['name'];
        $this->values = $data['values'];
    }
}
