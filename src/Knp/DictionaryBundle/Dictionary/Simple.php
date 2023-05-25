<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
use Traversable;

/**
 * @template TKey of (int|string)
 * @template TValue
 *
 * @implements Dictionary<TKey, TValue>
 */
final class Simple implements Dictionary
{
    /**
     * @param array<TKey, TValue> $values
     */
    public function __construct(private string $name, private array $values) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getKeys(): array
    {
        return array_keys($this->values);
    }

    public function getValues(): array
    {
        return array_values($this->values);
    }

    public function offsetExists(mixed $offset): bool
    {
        return \array_key_exists($offset, $this->values);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->values[$offset];
    }

    /**
     * {@inheritdoc}
     *
     * @param TKey $offset
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->values[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->values[$offset]);
    }

    public function getIterator(): Traversable
    {
        yield from $this->values;
    }

    public function count(): int
    {
        return \count($this->values);
    }
}
