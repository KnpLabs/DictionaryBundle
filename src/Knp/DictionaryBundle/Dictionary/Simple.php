<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Generator;
use Knp\DictionaryBundle\Dictionary;

/**
 * @template E
 *
 * @implements Dictionary<E>
 */
final class Simple implements Dictionary
{
    /**
     * @param array<mixed, E> $values
     */
    public function __construct(
        private readonly string $name,
        private array $values
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getKeys(): array
    {
        return array_keys($this->values);
    }

    public function offsetExists(mixed $offset): bool
    {
        return \array_key_exists($offset, $this->values);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->values[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->values[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->values[$offset]);
    }

    public function getIterator(): Generator
    {
        yield from $this->values;
    }

    public function count(): int
    {
        return \count($this->values);
    }
}
