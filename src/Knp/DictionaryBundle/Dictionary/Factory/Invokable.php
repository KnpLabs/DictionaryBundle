<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Factory;
use Psr\Container\ContainerInterface;

final class Invokable implements Factory
{
    public function __construct(private ContainerInterface $container) {}

    public function supports(array $config): bool
    {
        return 'callable' === $config['type'] ?: false;
    }

    /**
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

        if (!\is_string($config['service'])) {
            throw new InvalidArgumentException(sprintf(
                'The "service" config key must be a string for the dictionary named "%s"; %s given.',
                $name,
                \gettype($config['service']),
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
}
