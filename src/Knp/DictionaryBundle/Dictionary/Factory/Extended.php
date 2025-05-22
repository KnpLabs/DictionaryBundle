<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Dictionary\Combined;
use Knp\DictionaryBundle\Dictionary\Factory;

final class Extended implements Factory
{
    public function __construct(private readonly Factory $factory, private Collection $collection) {}

    public function create(string $name, array $config): Dictionary
    {
        if (!$this->factory->supports($config)) {
            throw new \InvalidArgumentException(\sprintf(
                'The dictionary with named "%s" cannot be created.',
                $name
            ));
        }

        $extends = $config['extends'];

        unset($config['extends']);

        return new Combined(
            $name,
            $this->collection[$extends],
            $this->factory->create($name, $config)
        );
    }

    public function supports(array $config): bool
    {
        return isset($config['extends']);
    }
}
