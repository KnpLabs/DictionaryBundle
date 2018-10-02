<?php

namespace Knp\DictionaryBundle\Dictionary;

use ArrayIterator;
use Knp\DictionaryBundle\Dictionary;

class ExtendedDictionary implements Dictionary
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Dictionary
     */
    private $initialDictionary;

    /**
     * @var Dictionary
     */
    private $extendedDictionary;

    /**
     * @var array
     */
    private $computedValues = null;

    /**
     * @param string $name
     * @param Dictionary $initialDictionary
     * @param Dictionary $extendedDictionary
     */
    public function __construct(
        string $name,
        Dictionary $initialDictionary,
        Dictionary $extendedDictionary
    ) {
        $this->name               = $name;
        $this->initialDictionary  = $initialDictionary;
        $this->extendedDictionary = $extendedDictionary;
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
        $this->ensureComputedValues();

        return $this->computedValues;
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys(): array
    {
        $this->ensureComputedValues();

        return array_keys($this->computedValues);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return
            $this->extendedDictionary->offsetExists($offset)
            || $this->initialDictionary->offsetExists($offset)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        $this->ensureComputedValues();

        return $this->computedValues[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->clearComputedValues();

        if ($this->extendedDictionary->offsetExists($offset)) {
            return $this->extendedDictionary->offsetSet($offset, $value);
        }

        if ($this->initialDictionary->offsetExists($offset)) {
            return $this->extendedDictionary->offsetSet($offset, $value);
        }

        return $this->extendedDictionary->offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->clearComputedValues();

        if ($this->extendedDictionary->offsetExists($offset)) {
            $this->extendedDictionary->offsetUnset($offset);
        }

        if ($this->initialDictionary->offsetExists($offset)) {
            $this->extendedDictionary->offsetUnset($offset);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $this->ensureComputedValues();

        return new ArrayIterator($this->computedValues);
    }

    private function computeValues()
    {
        $this->computedValues = array_merge(
            $this->initialDictionary->getValues(),
            $this->extendedDictionary->getValues()
       );
    }

    private function ensureComputedValues()
    {
        if (null === $this->computedValues) {
            $this->computeValues();
        }
    }

    private function clearComputedValues()
    {
        $this->computedValues = null;
    }
}
