<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Dictionary\Factory;

final class Combined implements Factory
{
    /**
     * @var string
     */
    private const TYPE = 'combined';

    public function __construct(private Collection $dictionaries) {}

    public function create(string $name, array $config): Dictionary
    {
        if (!isset($config['dictionaries'])) {
            throw new InvalidArgumentException(
                sprintf(
                    'The configuration of the dictionary named "%s" of type "%s" must contain a "dictionary" parameter.',
                    $name,
                    self::TYPE
                )
            );
        }

        if (!\is_array($config['dictionaries'])) {
            throw new InvalidArgumentException(
                sprintf(
                    'The "dictionaries" configuration parameter of the dictionary named "%s" of type "%s" must contain an array, %s is given.',
                    $name,
                    self::TYPE,
                    \gettype($config['dictionaries']),
                )
            );
        }

        $dictionaries = array_map(
            fn (string $name): Dictionary => $this->dictionaries[$name],
            $config['dictionaries']
        );

        return new Dictionary\Combined($name, ...$dictionaries);
    }

    public function supports(array $config): bool
    {
        return isset($config['type']) && self::TYPE === $config['type'];
    }
}
