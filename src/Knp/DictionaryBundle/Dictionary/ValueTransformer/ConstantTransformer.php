<?php

namespace Knp\DictionaryBundle\Dictionary\ValueTransformer;

class ConstantTransformer implements TransformerInterface
{
    private $pattern = '/^(?P<class>.*)::(?P<constant>.*)$/';

    public function supports($value)
    {
        $matches = array();

        if (0 === preg_match($this->pattern, $value, $matches)) {
            return false;
        }

        try {
            $class = new \ReflectionClass($matches['class']);
        } catch (\ReflectionException $e) {
            return false;
        }

        return false !== $class->getConstant($matches['constant']);
    }

    public function transform($value)
    {
        $matches = array();
        preg_match($this->pattern, $value, $matches);
        $class = new \ReflectionClass($matches['class']);

        return $class->getConstant($matches['constant']);
    }
}
