<?php

namespace Knp\DictionaryBundle\Dictionary\Factory;

use Knp\DictionaryBundle\Dictionary\Factory;
use Knp\DictionaryBundle\Dictionary\SimpleDictionary;
use Knp\DictionaryBundle\Dictionary\ValueTransformer;

class Value implements Factory
{
    /**
     * @var ValueTransformer
     */
    protected $transformers = array();

    /**
     * {@inheritdoc}
     */
    public function create($name, array $config)
    {
        if ( ! isset($config['content'])) {
            throw new \InvalidArgumentException(sprintf(
                'The key content for dictionary %s must be set',
                $name
            ));
        }

        $content = $config['content'];
        $values  = array();

        foreach ($content as $value) {
            $values[] = $this->buildValue($value);
        }

        return new SimpleDictionary($name, $values);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(array $config)
    {
        return (isset($config['type'])) ? $config['type'] === 'value' : false;
    }

    /**
     * @param ValueTransformer $transformers
     *
     * @return ValueAsKey
     */
    public function addTransformer(ValueTransformer $transformer)
    {
        $this->transformers = $transformer;

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    private function buildValue($value)
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($value)) {
                return $transformer->transform($value);
            }
        }

        return $value;
    }
}
