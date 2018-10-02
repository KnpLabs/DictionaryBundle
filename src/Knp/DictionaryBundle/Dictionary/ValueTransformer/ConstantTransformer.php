<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\ValueTransformer;

use Knp\DictionaryBundle\Dictionary\ValueTransformer;
use ReflectionClass;

class ConstantTransformer implements ValueTransformer
{
    /**
     * @var string
     */
    private $pattern = '/^(?P<class>.*)::(?P<constant>.*)$/';

    /**
     * {@inheritdoc}
     */
    public function supports($value): bool
    {
        $matches = [];

        if (0 === preg_match($this->pattern, $value, $matches)) {
            return false;
        }

        if (false === class_exists($matches['class']) && false === interface_exists($matches['class'])) {
            return false;
        }

        $class     = new ReflectionClass($matches['class']);
        $constants = $class->getConstants();

        return array_key_exists($matches['constant'], $constants);
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        $matches = [];

        preg_match($this->pattern, $value, $matches);

        $class = new ReflectionClass($matches['class']);

        return $class->getConstant($matches['constant']);
    }
}
