<?php

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use Knp\DictionaryBundle\Dictionary;

class TraceableDictionary implements Dictionary
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
    public function offsetExists($offset)
    {
        $this->trace();

        return $this->dictionary->offsetExists($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $this->trace();

        return $this->dictionary->offsetGet($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->dictionary->offsetSet($offset, $value);

        $this->trace();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->dictionary->offsetUnset($offset);

        $this->trace();
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $this->trace();

        return $this->dictionary->getIterator();
    }

    /**
     * Register this dictioanry as used.
     */
    private function trace()
    {
        $this->collector->addDictionary(
            $this->dictionary->getName(),
            $this->dictionary->getKeys(),
            array_values($this->dictionary->getValues())
        );
    }
}
