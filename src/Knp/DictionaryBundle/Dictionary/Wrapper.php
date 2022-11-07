<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
use ReturnTypeWillChange;

/**
 * @template E
 *
 * @implements Dictionary<E>
 */
abstract class Wrapper implements Dictionary
{
    /**
     * @var Dictionary<E>
     */
    private Dictionary $wrapped;

    /**
     * @param Dictionary<E> $wrapped
     */
    public function __construct(Dictionary $wrapped)
    {
        $this->wrapped = $wrapped;
    }

    public function getName(): string
    {
        return $this->wrapped->getName();
    }

    public function getValues(): array
    {
        return $this->wrapped->getValues();
    }

    public function getKeys(): array
    {
        return $this->wrapped->getKeys();
    }

    public function offsetExists($offset): bool
    {
        return $this->wrapped->offsetExists($offset);
    }

    #[ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->wrapped->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->wrapped->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->wrapped->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->wrapped->count();
    }

    /**
     * @return Dictionary<E>
     */
    public function getIterator(): Dictionary
    {
        return $this->wrapped;
    }
}
