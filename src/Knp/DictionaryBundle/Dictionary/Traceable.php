<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use IteratorAggregate;
use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use Knp\DictionaryBundle\Dictionary;

class Traceable implements Dictionary
{
    /**
     * @var Dictionary
     */
    private $dictionary;

    /**
     * @var DictionaryDataCollector
     */
    private $collector;

    public function __construct(Dictionary $dictionary, DictionaryDataCollector $collector)
    {
        $this->dictionary = $dictionary;
        $this->collector  = $collector;
    }

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
        $this->trace();

        return $this->dictionary->getValues();
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys(): array
    {
        $this->trace();

        return $this->dictionary->getKeys();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset): bool
    {
        $this->trace();

        return $this->dictionary->offsetExists($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        $this->trace();

        return $this->dictionary->offsetGet($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void
    {
        $this->dictionary->offsetSet($offset, $value);

        $this->trace();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset): void
    {
        $this->dictionary->offsetUnset($offset);

        $this->trace();
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): IteratorAggregate
    {
        $this->trace();

        return $this->dictionary;
    }

    /**
     * Register this dictionary as used.
     */
    private function trace(): void
    {
        $this->collector->addDictionary(
            $this->dictionary->getName(),
            $this->dictionary->getKeys(),
            array_values($this->dictionary->getValues())
        );
    }

    public function count(): int
    {
        $this->trace();

        return $this->dictionary->count();
    }
}
