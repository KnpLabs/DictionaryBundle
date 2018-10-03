<?php

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\CombinedDictionary;

class Extended implements Factory
{
    /**
     * @var FactoryAggregate
     */
    private $factoryAggregate;

    /**
     * @var DictionaryRegistry
     */
    private $registry;

    /**
     * @param FactoryAggregate $factoryAggregate
     * @param DictionaryRegistry $registry
     */
    public function __construct(
        FactoryAggregate $factoryAggregate,
        DictionaryRegistry $registry
    ) {
        $this->factoryAggregate = $factoryAggregate;
        $this->registry         = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $name, array $config): Dictionary
    {
        if (false === $this->factoryAggregate->supports($config)) {
            throw new InvalidArgumentException(sprintf(
                'The dictionary with named "%s" cannot be created.',
                $name
            ));
        }

        $extends = $config['extends'];
        unset($config['extends']);

        $dictionaries = [];
        $dictionaries[] = $this->registry->get($extends);
        $dictionaries[] = $this->factoryAggregate->create($name, $config);

        return new CombinedDictionary($name, $dictionaries);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(array $config): bool
    {
        return isset($config['extends']);
    }
}
