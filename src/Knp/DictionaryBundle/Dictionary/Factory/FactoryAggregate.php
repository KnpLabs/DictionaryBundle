<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;

class FactoryAggregate implements Dictionary\Factory
{
    /**
     * @var Dictionary\Factory\Aggregate
     */
    private $factory;

    public function __construct(Dictionary\Factory\Aggregate $aggregate)
    {
        $this->factory = $aggregate;
    }

    public function addFactory(Dictionary\Factory $factory)
    {
        $this->factory->addFactory($factory);
    }

    /**
     * {@inheritdoc}
     *
     * @throw InvalidArgumentException Not able to create a dictionary with the given name
     */
    public function create(string $name, array $config): Dictionary
    {
        return $this->factory->create($name, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(array $config): bool
    {
        return $this->factory->supports($config);
    }
}
