<?php

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
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
     * @return StaticDictionary
     */
    public function createFromArray($name, array $content, $type)
    {
        $values = array();
        foreach ($content as $key => $value) {
            $builtValue   = $this->buildValue($value);
            $key          = Dictionary::VALUE_AS_KEY === $type ? $builtValue : $this->buildValue($key);
            $values[$key] = $builtValue;
        }

        return new StaticDictionary($name, $values);
    }

    /**
     * @param string   $name
     * @param callable $callable
     *
     * @return LazyDictionary
     */
    public function createFromCallable($name, $callable)
    {
        return new LazyDictionary($name, $callable);
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
