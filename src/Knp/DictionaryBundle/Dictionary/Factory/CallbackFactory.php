<?php

namespace Knp\DictionaryBundle\Dictionary\Factory;

use Knp\DictionaryBundle\Dictionary\CallbackDictionary;
use Knp\DictionaryBundle\Dictionary\Factory;
use Symfony\Component\DependencyInjection\Container;

class CallbackFactory implements Factory
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param $container Container
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

        $callback = array($service);

        if (isset($config['method'])) {
            $callback[] = $config['method'];
        }

        if ( ! is_callable($callback)) {
            throw new \InvalidArgumentException(sprintf(
                'You must provide a valid callback for the dictionary named "%s"',
                $name
            ));
        }

        return new CallbackDictionary($name, $callback);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(array $config)
    {
        return (isset($config['type'])) ? $config['type'] === 'callback' : false;
    }
}
