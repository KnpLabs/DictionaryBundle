<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use AppendIterator;
use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;

class Combined implements Dictionary
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $dictionaries;

    public function __construct(string $name, array $dictionaries)
    {
        $this->name         = $name;
        $this->dictionaries = $dictionaries;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getValues(): array
    {
        $values = array_map(function ($dictionary) {
            return $dictionary->getValues();
        }, $this->dictionaries);

        return array_merge(...$values);
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys(): array
    {
        $keys = array_map(function ($dictionary) {
            return $dictionary->getKeys();
        }, $this->dictionaries);

        return array_merge(...$keys);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return \in_array($offset, $this->getKeys());
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        foreach ($this->dictionaries as $dictionary) {
            if ($dictionary->offsetExists($offset)) {
                return $dictionary->offsetGet($offset);
            }
        }

        throw new InvalidArgumentException(
            sprintf('Undefined offset "%s".', $offset)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        foreach ($this->dictionaries as $dictionary) {
            if ($dictionary->offsetExists($offset)) {
                $dictionary->offsetSet($offset, $value);

                return;
            }
        }

        throw new InvalidArgumentException(
            sprintf('Undefined offset "%s".', $offset)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        foreach ($this->dictionaries as $dictionary) {
            if ($dictionary->offsetExists($offset)) {
                $dictionary->offsetUnset($offset);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $iterator = new AppendIterator();

        foreach ($this->dictionaries as $dictionary) {
            $iterator->append($dictionary->getIterator());
        }

        return $iterator;
    }
}
