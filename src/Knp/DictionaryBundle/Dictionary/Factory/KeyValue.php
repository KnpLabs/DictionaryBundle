<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\Simple;
use Knp\DictionaryBundle\ValueTransformer;

final class KeyValue implements Factory
{
    public function __construct(private ValueTransformer $transformer)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @throw InvalidArgumentException if there is some problem with the config.
     */
    public function create(string $name, array $config): Dictionary
    {
        if (!isset($config['content'])) {
            throw new InvalidArgumentException(sprintf(
                'The key content for dictionary %s must be set.',
                $name
            ));
        }

        $content = $config['content'];
        $values  = [];

        foreach ($content as $key => $value) {
            $builtValue   = $this->transformer->transform($value);
            $key          = $this->transformer->transform($key);
            $values[$key] = $builtValue;
        }

        return new Simple($name, $values);
    }

    public function supports(array $config): bool
    {
        return (isset($config['type'])) ? 'key_value' === $config['type'] : false;
    }
}
