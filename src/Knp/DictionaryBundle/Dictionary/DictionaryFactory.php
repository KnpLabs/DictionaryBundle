<?php

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary\ValueTransformer\TransformerInterface;

final class DictionaryFactory
{
    /**
     * @var TransformerInterface[]
     */
    private $transformers = array();

    /**
     * @param TransformerInterface $transformer
     *
     * @return DictionaryFactory
     */
    public function addTransformer(TransformerInterface $transformer)
    {
        $this->transformers[] = $transformer;

        return $this;
    }

    /**
     * @param string  $name
     * @param mixed[] $content
     * @param string  $type
     *
     * @return Dictionary
     */
    public function create($name, array $content, $type)
    {
        $values = array();
        foreach ($content as $key => $value) {
            $builtValue   = $this->buildValue($value);
            $key          = Dictionary::VALUE_AS_KEY === $type ? $builtValue : $this->buildValue($key);
            $values[$key] = $builtValue;
        }

        return new Dictionary($name, $values);
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
