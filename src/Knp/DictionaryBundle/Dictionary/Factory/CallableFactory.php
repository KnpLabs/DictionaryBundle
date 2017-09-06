<?php

namespace Knp\DictionaryBundle\Dictionary\Factory;

use Knp\DictionaryBundle\Dictionary\CallableDictionary;
use Knp\DictionaryBundle\Dictionary\Factory;
use Symfony\Component\DependencyInjection\Container;

class CallableFactory implements Factory
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function create($name, array $config)
    {
        if ( ! isset($config['service'])) {
            throw new \InvalidArgumentException(sprintf(
                'The "service" config key must be set for the dictionary named "%s"',
                $name
            ));
        }

        $service = $this->container->get($config['service']);

        $callable = [$service];

        if (isset($config['method'])) {
            $callable[] = $config['method'];
        }

        if ( ! is_callable($callable)) {
            throw new \InvalidArgumentException(sprintf(
                'You must provide a valid callable for the dictionary named "%s"',
                $name
            ));
        }

        return new CallableDictionary($name, $callable);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(array $config)
    {
        return (isset($config['type'])) ? $config['type'] === 'callable' : false;
    }
}
