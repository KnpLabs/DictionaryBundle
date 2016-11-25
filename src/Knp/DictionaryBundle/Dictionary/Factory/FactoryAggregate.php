<?php

namespace Knp\DictionaryBundle\Dictionary\Factory;

use Knp\DictionaryBundle\Dictionary\Factory;

class FactoryAggregate implements Factory
{
    /**
     * @var Factory[]
     */
    private $factories = array();

    /**
     * {@inheritdoc}
     */
    public function create($name, array $config)
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($config)) {
                return $factory->create($name, $config);
            }
        }

        throw new \InvalidArgumentException(sprintf(
            'The dictionary with name "%s" cannot be created.',
            $name
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function supports(array $config)
    {
        return true;
    }

    /**
     * @param Factory $factory
     *
     * @return FactoryAggregate
     */
    public function addFactory(Factory $factory)
    {
        $this->factories[] = $factory;

        return $this;
    }
}
