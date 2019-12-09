<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;

class Extended implements Dictionary\Factory
{
    /**
     * @var Dictionary\Factory
     */
    private $factory;

    /**
     * @var Dictionary\Collection
     */
    private $dictionaries;

    public function __construct(Dictionary\Factory $factory, Dictionary\Collection $dictionaries)
    {
        $this->factory      = $factory;
        $this->dictionaries = $dictionaries;
    }

    public function create(string $name, array $config): Dictionary
    {
        if (!$this->factory->supports($config)) {
            throw new InvalidArgumentException(sprintf(
                'The dictionary with named "%s" cannot be created.',
                $name
            ));
        }

        $extends = $config['extends'];

        unset($config['extends']);

        return new Dictionary\Combined(
            $name,
            $this->dictionaries[$extends],
            $this->factory->create($name, $config)
        );
    }

    public function supports(array $config): bool
    {
        return isset($config['extends']);
    }
}
