<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\Simple;
use Knp\DictionaryBundle\ValueTransformer;

final class Value implements Factory
{
    public function __construct(private readonly ValueTransformer $valueTransformer) {}

    /**
     * {@inheritdoc}
     *
     * @throw InvalidArgumentException Not able to create a dictionary with the given name
     */
    public function create(string $name, array $config): Dictionary
    {
        if (!isset($config['content'])) {
            throw new \InvalidArgumentException(\sprintf(
                'The key content for dictionary %s must be set.',
                $name
            ));
        }

        $content = $config['content'];
        $values  = [];

        foreach ($content as $value) {
            $values[] = $this->valueTransformer->transform($value);
        }

        return new Simple($name, $values);
    }

    public function supports(array $config): bool
    {
        return isset($config['type']) && 'value' === $config['type'];
    }
}
