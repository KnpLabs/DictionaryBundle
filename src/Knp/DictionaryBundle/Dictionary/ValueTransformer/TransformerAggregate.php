<?php

namespace Knp\DictionaryBundle\Dictionary\ValueTransformer;

use Knp\DictionaryBundle\Dictionary\ValueTransformer;

class TransformerAggregate implements ValueTransformer
{
    /**
     * @var ValueTransformer[]
     */
    private $transformers = array();

    /**
     * @param ValueTransformer $transformer
     *
     * @return TransformerAggregate
     */
    public function addTransformer(ValueTransformer $transformer)
    {
        $this->transformers[] = $transformer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($value)) {
                return $transformer->transform($value);
            }
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($value)
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($value)) {
                return true;
            }
        }

        return false;
    }
}
