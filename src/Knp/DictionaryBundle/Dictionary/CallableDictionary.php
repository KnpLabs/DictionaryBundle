<?php

namespace Knp\DictionaryBundle\Dictionary;

use ArrayAccess;
use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;

class CallableDictionary implements Dictionary
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ArrayAccess|mixed[]
     */
    private $values;

    /**
     * @var callable
     */
    private $callable;

    /**
     * @var array
     */
    private $callableArgs;

    /**
     * @param string   $name
     * @param callable $callable
     * @param array    $callableArgs
     */
    public function __construct(
        $name,
        callable $callable,
        array $callableArgs = []
    ) {
        $this->name         = $name;
        $this->callable     = $callable;
        $this->callableArgs = $callableArgs;
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
        $this->hydrate();

        return $this->values;
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys()
    {
        $this->hydrate();

        return array_keys($this->values);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        $this->hydrate();

        return array_key_exists($offset, $this->values);
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $this->hydrate();

        return $this->values[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->hydrate();

        $this->values[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->hydrate();

        unset($this->values[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $this->hydrate();

        return new \ArrayIterator($this->values);
    }

    /**
     * Hydrate values from callable.
     */
    private function hydrate()
    {
        if (null !== $this->values) {
            return;
        }

        $values = call_user_func_array($this->callable, $this->callableArgs);

        if (false === is_array($values) && false === $values instanceof ArrayAccess) {
            throw new InvalidArgumentException(
                'Dictionary callable must return an array or an instance of ArrayAccess'
            );
        }

        $this->values = $values;
    }
}
