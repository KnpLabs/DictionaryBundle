<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;

class Combined implements Dictionary\Factory
{
    /**
     * @var string
     */
    public const TYPE = 'combined';

    /**
     * @var Dictionary\Collection
     */
    private $dictionaries;

    public function __construct(Dictionary\Collection $dictionaries)
    {
        $this->dictionaries = $dictionaries;
    }

    public function create(string $name, array $config): Dictionary
    {
        if (!isset($config['dictionaries'])) {
            throw new InvalidArgumentException(sprintf(
                'Dictionary of type %s must contains a key "dictionaries".',
                self::TYPE
            ));
        }

        $dictionaries = array_map(
            function ($name): Dictionary {
                return $this->dictionaries[$name];
            },
            $config['dictionaries']
        );

        return new Dictionary\Combined($name, ...$dictionaries);
    }

    public function supports(array $config): bool
    {
        return isset($config['type']) ? self::TYPE === $config['type'] : false;
    }
}
