<?php

namespace Knp\DictionaryBundle\Dictionary;

class LazyDictionary extends StaticDictionary
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @param string   $name
     * @param callable $callable
     */
    public function __construct($name, $callable)
    {
        $this->name = $name;

        if (false === is_callable($callable)) {
            throw new \InvalidArgumentException('Second argument must be a callable.');
        }

        $this->callable = $callable;
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        $this->hydrate();

        return parent::getValues();
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys()
    {
        $this->hydrate();

        return parent::getKeys();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        $this->hydrate();

        return parent::offsetExists($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $this->hydrate();

        return parent::offsetGet($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->hydrate();

        return parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->hydrate();

        return parent::offsetUnset($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $this->hydrate();

        return parent::getIterator();
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        $this->hydrate();

        return parent::serialize();
    }

    /**
     * Hydrate values from callable.
     */
    protected function hydrate()
    {
        if (null !== $this->values) {
            return;
        }

        $values = call_user_func($this->callable);

        if (false === is_array($values) && false === $values instanceof \ArrayAccess) {
            throw new \InvalidArgumentException(
                'Dictionary callable must return an array or an instance of ArrayAccess'
            );
        }

        $this->values = $values;
    }
}
