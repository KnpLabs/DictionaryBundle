<?php

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary\ValueTransformer\TransformerInterface;
use Knp\DictionaryBundle\Dictionary\Dictionary;

final class DictionaryFactory
{
    private $transformers = array();

    public function create($name, $content, $type)
    {
        $values = array();
        foreach ($content as $key => $value) {
            $builtValue = $this->buildValue($value);
            $key = Dictionary::VALUE_AS_KEY == $type
                ? $builtValue
                : $this->buildValue($key)
            ;
            $values[$key] = $builtValue;
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
