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
            $values[$key] = $this->buildValue($value);
        }

        return new Dictionary($name, $values);
    }

    private function buildValue($value)
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($value)) {
                return $transformer->transform($value);
            }
        }

        return $value;
    }

    public function addTransformer(TransformerInterface $transformer)
    {
        $this->transformers[] = $transformer;
    }
}
