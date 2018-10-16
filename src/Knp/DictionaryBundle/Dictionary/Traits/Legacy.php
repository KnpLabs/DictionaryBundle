<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Traits;

trait Legacy
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

    public function offsetSet($offset, $value)
    {
        $this->dictionary->offsetSet($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->dictionary->offsetUnset($offset);
    }

    public function getIterator()
    {
        return $this->dictionary->getIterator();
    }
}
