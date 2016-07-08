<?php

namespace Knp\DictionaryBundle\Dictionary;

use ArrayAccess;
use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary as DictionaryInterface;

class CallableDictionary implements DictionaryInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var callable
     */
    private $valuesOrKeys;

    /**
     * @var callable|null
     */
    private $values;

    /**
     * @var DictionaryInterface|null
     */
    private $wrapped;

    /**
     * @param string        $name
     * @param callable      $valuesOrKeys
     * @param callable|null $values
     */
    public function __construct($name, $valuesOrKeys, $values = null)
    {
        $this->name         = $name;
        $this->valuesOrKeys = $valuesOrKeys;
        $this->values       = $values;
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

        return $this
            ->wrapped
            ->getValues()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys()
    {
        $this->hydrate();

        return $this
            ->wrapped
            ->getKeys()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        $this->hydrate();

        return $this
            ->wrapped
            ->offsetExists($offset)
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $this->hydrate();

        return $this
            ->wrapped
            ->offsetGet($offset)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->hydrate();

        $this
            ->wrapped
            ->offsetSet($offset, $value)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->hydrate();

        $this
            ->wrapped
            ->offsetUnset($offset)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $this->hydrate();

        return $this->wrapped->getIterator();
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        $this->hydrate();

        return serialize($this->wrapped);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->wrapped = unserialize($serialized);
    }

    /**
     * Hydrate wrapped dictionary from callables.
     */
    private function hydrate()
    {
        if (null !== $this->wrapped) {
            return;
        }

        if (null === $this->values) {
            $this->wrapped = new SimpleDictionary(
                $this->name,
                $this->assertArrayAndReturn(call_user_func($this->valuesOrKeys))
            );

            return;
        }

        $this->wrapped = new SimpleDictionary(
            $this->name,
            $this->assertArrayAndReturn(call_user_func($this->valuesOrKeys)),
            $this->assertArrayAndReturn(call_user_func($this->values))
        );
    }

    /**
     * @param mixed $array
     *
     * @return array
     *
     * @throw InvalidArgumentException
     */
    private function assertArrayAndReturn($array)
    {
        if (is_array($array)) {
            return $array;
        }

        if ($array instanceof ArrayAccess) {
            return $array;
        }

        throw new InvalidArgumentException('Dictionary callable must return an array or an instance of ArrayAccess');
    }
}
