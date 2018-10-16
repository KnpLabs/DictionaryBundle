<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Dictionary\CombinedDictionary;
use Knp\DictionaryBundle\Dictionary\Factory;

class Extended implements Factory
{
    /**
     * @var Dictionary\Factory\FactoryAggregate
     */
    private $factoryAggregate;

    /**
     * @var Dictionary\Collection
     */
    private $dictionaries;

    public function __construct(Dictionary\FactoryAggregate $factoryAggregate, Dictionary\Collection $dictionaries)
    {
        $this->factoryAggregate = $factoryAggregate;
        $this->dictionaries     = $dictionaries;
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

        $dictionaries   = [];
        $dictionaries[] = $this->dictionaries[$extends];
        $dictionaries[] = $this->factoryAggregate->create($name, $config);

        return new Dictionary\Combined($name, $dictionaries);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(array $config): bool
    {
        return isset($config['extends']);
    }
}
