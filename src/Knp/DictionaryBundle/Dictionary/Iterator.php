<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use ArrayIterator;
use Knp\DictionaryBundle\Dictionary;
use Traversable;

final class Iterator implements Dictionary
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $values;

    /**
     * @var Traversable
     */
    private $iterator;

    /**
     * @var array
     */
    private $callableArgs;

    public function __construct(string $name, Traversable $iterator)
    {
        $this->name     = $name;
        $this->iterator = $iterator;
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
        $this->hydrate();

        return $this->values;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $this->hydrate();

        return new ArrayIterator($this->values);
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys(): array
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
     */
    public function offsetGet($offset)
    {
        $this->hydrate();

        return $this->values[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void
    {
        $this->hydrate();

        $this->values[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset): void
    {
        $this->hydrate();

        unset($this->values[$offset]);
    }

    /**
     * Hydrate values from iterator.
     */
    private function hydrate(): void
    {
        if (null !== $this->values) {
            return;
        }

        $this->values = iterator_to_array($this->iterator);
    }
}
