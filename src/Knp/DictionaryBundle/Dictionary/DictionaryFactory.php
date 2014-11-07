<?php

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary\ValueTransformer\TransformerInterface;
use Knp\DictionaryBundle\Dictionary\Dictionary;

final class DictionaryFactory
{
    private $transformers = array();

    public function create($name, $values)
    {
        foreach ($values as $key => $value) {
            foreach ($this->transformers as $transformer) {
                if (false === $transformer->supports($value)) {
                    continue;
                }

                $values[$key] = $transformer->transform($value);
            }
        }

        return new Dictionary($name, $values);
    }

    public function addTransformer(TransformerInterface $transformer)
    {
        $this->transformers[] = $transformer;
    }
}
