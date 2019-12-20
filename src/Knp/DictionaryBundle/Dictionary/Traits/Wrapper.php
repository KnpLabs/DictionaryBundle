<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Traits;

/**
 * @deprecated Trait Knp\DictionaryBundle\Dictionary\Traits\Wrapper is deprecated since version 3.1, to be removed in 3.2. Extend from Knp\DictionaryBundle\Dictionary\Wrapper instead.
 */
trait Wrapper
{
    /**
     * @var \Knp\DictionaryBundle\Dictionary
     */
    private $dictionary;

    public function getName(): string
    {
        return $this->dictionary->getName();
    }

    public function getValues(): array
    {
        return $this->dictionary->getValues();
    }

    public function getKeys(): array
    {
        return $this->dictionary->getKeys();
    }

    public function offsetExists($offset)
    {
        return $this->dictionary->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->dictionary->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->dictionary->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->dictionary->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->dictionary->count();
    }

    public function getIterator()
    {
        return $this->dictionary->getIterator();
    }
}
