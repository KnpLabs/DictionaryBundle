<?php

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Knp\DictionaryBundle\Dictionary\CombinedDictionary;

class Combined implements Factory
{
    const TYPE = 'combined';

    /**
     * @var DictionaryRegistry
     */
    private $registry;

    /**
     * @param DictionaryRegistry $registry
     */
    public function __construct(DictionaryRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $name, array $config): Dictionary
    {
        if (!isset($config['dictionaries'])) {
            throw new InvalidArgumentException(sprintf(
                'Dictionary of type %s must contains a key "dictionaries"',
                self::TYPE
            ));
        }

        $dictionaries = array_map(function ($name) {
            return $this->registry->get($name);
        }, $config['dictionaries']);

        return new CombinedDictionary($name, $dictionaries);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(array $config): bool
    {
        return isset($config['type']) ? $config['type'] === self::TYPE : false;
    }
}
