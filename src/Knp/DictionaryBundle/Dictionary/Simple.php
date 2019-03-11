<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use ArrayIterator;
use Iterator;
use Knp\DictionaryBundle\Dictionary;

final class Simple implements Dictionary
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
    public function offsetExists($offset): bool
    {
        return \array_key_exists($offset, $this->values);
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
    public function offsetSet($offset, $value): void
    {
        $this->values[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset): void
    {
        unset($this->values[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->values);
    }

    public function count(): int
    {
        return \count($this->values);
    }
}
