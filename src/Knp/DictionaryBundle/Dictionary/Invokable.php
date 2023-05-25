<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Traversable;

/**
 * @template TKey of (int|string)
 * @template TValue
 *
 * @implements Dictionary<TKey, TValue>
 */
final class Invokable implements Dictionary
{
    /**
     * @var Simple<TKey, TValue>
     */
    private Simple $dictionary;

    /**
     * @var callable(): array<TKey, TValue>
     */
    private $callable;

    /**
     * @param mixed[]                         $callableArgs
     * @param callable(): array<TKey, TValue> $callable
     */
    public function __construct(
        private string $name,
        callable $callable,
        private array $callableArgs = []
    ) {
        $this->callable = $callable;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getKeys(): array
    {
        $this->invoke();

        return $this->dictionary->getKeys();
    }

    public function getValues(): array
    {
        $this->invoke();

        return $this->dictionary->getValues();
    }

    public function offsetExists(mixed $offset): bool
    {
        $this->invoke();

        return $this->dictionary->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        $this->invoke();

        return $this->dictionary->offsetGet($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @param TKey $offset
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->invoke();

        $this->dictionary->offsetSet($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->invoke();

        $this->dictionary->offsetUnset($offset);
    }

    public function getIterator(): Traversable
    {
        $this->invoke();

        yield from $this->dictionary;
    }

    public function count(): int
    {
        $this->invoke();

        return $this->dictionary->count();
    }

    private function invoke(): void
    {
        if (isset($this->dictionary)) {
            return;
        }

        $values = ($this->callable)(...$this->callableArgs);

        if (!\is_array($values)) {
            throw new InvalidArgumentException(
                'Dictionary callable must return an array or an instance of ArrayAccess.'
            );
        }

        $this->dictionary = new Simple($this->name, $values);
    }
}
