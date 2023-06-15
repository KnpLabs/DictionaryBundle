<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Factory;
use Psr\Container\ContainerInterface;
use Traversable;

final class Iterator implements Factory
{
    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @throw InvalidArgumentException if there is some problem with the config.
     */
    public function create(string $name, array $config): Dictionary
    {
        if (!isset($config['service'])) {
            throw new InvalidArgumentException(sprintf(
                'The "service" config key must be set for the dictionary named "%s".',
                $name
            ));
        }

        $service = $this->container->get($config['service']);

        if (!$service instanceof Traversable) {
            throw new InvalidArgumentException(sprintf(
                'You must provide a valid instance of Traversable for the dictionary named "%s".',
                $name
            ));
        }

        return new Dictionary\Iterator($name, $service);
    }

    public function supports(array $config): bool
    {
        return (isset($config['type'])) ? 'iterator' === $config['type'] : false;
    }
}
