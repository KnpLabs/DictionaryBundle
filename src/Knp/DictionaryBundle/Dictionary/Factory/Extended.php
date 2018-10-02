<?php

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\Factory\FactoryAggregate;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\ExtendedDictionary;

class Extended implements Factory
{
    /**
     * @var FactoryAggregate
     */
    private $factoryAggregate;

    /**
     * @var DictionaryRegistry
     */
    private $dictionaryRegistry;

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

        $extendedDictionary = $this->factoryAggregate->create($name, $config);
        $initialDictionary = $this->registry->get($extends);

        return new ExtendedDictionary($name, $initialDictionary, $extendedDictionary);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(array $config): bool
    {
        return isset($config['extends']);
    }
}
