<?php

namespace Knp\DictionaryBundle\Dictionary\ValueTransformer;

class ConstantTransformer implements TransformerInterface
{
    /**
     * @var string
     */
    private $pattern = '/^(?P<class>.*)::(?P<constant>.*)$/';

    /**
     * {@inheritdoc}
     */
    public function supports($value)
    {
        $matches = array();

        if (0 === preg_match($this->pattern, $value, $matches)) {
            return false;
        }

        if (false === class_exists($matches['class'])) {
            return false;
        }

        $class = new \ReflectionClass($matches['class']);
        $constants = $class->getConstants();

        return array_key_exists($matches['constant'], $constants);
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        $matches = array();
        preg_match($this->pattern, $value, $matches);
        $class = new \ReflectionClass($matches['class']);

        return $class->getConstant($matches['constant']);
    }
}
