<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\Factory;

use InvalidArgumentException;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\ValueTransformer;

class Value implements Dictionary\Factory
{
    /**
     * @var ValueTransformer
     */
    protected $transformer;

    public function __construct(ValueTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * {@inheritdoc}
     *
     * @throw InvalidArgumentException Not able to create a dictionary with the given name
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

        foreach ($content as $value) {
            $values[] = $this->transformer->transform($value);
        }

        return new Dictionary\Simple($name, $values);
    }

    public function supports(array $config): bool
    {
        return (isset($config['type'])) ? 'value' === $config['type'] : false;
    }
}
