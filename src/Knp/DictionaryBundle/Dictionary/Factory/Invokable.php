<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Factory;
use Psr\Container\ContainerInterface;

final class Invokable implements Factory
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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

        $service  = $this->container->get($config['service']);
        $callable = [$service];

        if (isset($config['method'])) {
            $callable[] = $config['method'];
        }

        if (!\is_callable($callable)) {
            throw new InvalidArgumentException(sprintf(
                'You must provide a valid callable for the dictionary named "%s".',
                $name
            ));
        }

        return new Dictionary\Invokable($name, $callable);
    }

    public function supports(array $config): bool
    {
        return (isset($config['type'])) ? 'callable' === $config['type'] : false;
    }
}
