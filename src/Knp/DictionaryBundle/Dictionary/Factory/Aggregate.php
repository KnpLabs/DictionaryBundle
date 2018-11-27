<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Factory;

class Aggregate implements Factory
{
    /**
     * @var Dictionary\Factory[]
     */
    private $factories = [];

    public function addFactory(Dictionary\Factory $factory): void
    {
        $this->factories[] = $factory;
    }

    /**
     * {@inheritdoc}
     *
     * @throw InvalidArgumentException Not able to create a dictionary with the given name
     */
    public function create(string $name, array $config): Dictionary
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($config)) {
                return $factory->create($name, $config);
            }
        }

        throw new InvalidArgumentException(sprintf(
            'The dictionary with named "%s" cannot be created.',
            $name
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function supports(array $config): bool
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($config)) {
                return true;
            }
        }

        return false;
    }
}
