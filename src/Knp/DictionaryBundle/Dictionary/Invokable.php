<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use ArrayIterator;
use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use ReturnTypeWillChange;

/**
 * @template E
 *
 * @implements Dictionary<E>
 */
final class Invokable implements Dictionary
{
    private bool $invoked = false;

    /**
     * @var array<mixed, mixed>
     */
    private array $values = [];

    /**
     * @var callable
     */
    private $callable;

    /**
     * @param mixed[] $callableArgs
     */
    public function __construct(
        private readonly string $name,
        callable $callable,
        private readonly array $callableArgs = []
    ) {
        $this->callable = $callable;
    }

    public function getValues(): array
    {
        $this->invoke();

        return $this->values;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getKeys(): array
    {
        $this->invoke();

        return array_keys($this->values);
    }

    public function offsetExists($offset): bool
    {
        $this->invoke();

        return \array_key_exists($offset, $this->values);
    }

    #[ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        $this->invoke();

        return $this->values[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->invoke();

        $this->values[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        $this->invoke();

        unset($this->values[$offset]);
    }

    /**
     * @return ArrayIterator<int|string, mixed>
     */
    public function getIterator(): ArrayIterator
    {
        $this->invoke();

        return new ArrayIterator($this->values);
    }

    public function count(): int
    {
        $this->invoke();

        return \count($this->values);
    }

    private function invoke(): void
    {
        if ($this->invoked) {
            return;
        }

        $values = ($this->callable)(...$this->callableArgs);

        if (!\is_array($values)) {
            throw new InvalidArgumentException(
                'Dictionary callable must return an array or an instance of ArrayAccess.'
            );
        }

        $this->values  = $values;
        $this->invoked = true;
    }
}
