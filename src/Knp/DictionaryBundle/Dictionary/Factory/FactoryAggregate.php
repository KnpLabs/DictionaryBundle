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
        @trigger_error(
            sprintf(
                'Class %s is deprecated since version 2.2, to be removed in 3.0. Use %s instead.',
                __CLASS__,
                Dictionary\Factory\Aggregate::class
            ),
            E_USER_DEPRECATED
        );

        $this->factory = $aggregate;
    }

    public function addFactory(Dictionary\Factory $factory): void
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
