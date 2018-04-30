<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Traits;

use Knp\DictionaryBundle\Dictionary;

trait DictionaryWrapper
{
    /**
     * @var Dictionary
     */
    protected $dictionary;

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->dictionary->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getValues(): array
    {
        return $this->dictionary->getValues();
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys(): array
    {
        return $this->dictionary->getKeys();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->dictionary->offsetExists($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->dictionary->offsetGet($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->dictionary->offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->dictionary->offsetUnset($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->dictionary;
    }
}
