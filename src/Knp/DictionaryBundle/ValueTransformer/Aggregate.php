<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\ValueTransformer;

use Knp\DictionaryBundle\ValueTransformer;

final class Aggregate implements ValueTransformer
{
    /**
     * @var ValueTransformer[]
     */
    private $transformers = [];

    public function addTransformer(ValueTransformer $transformer)
    {
        $this->transformers[] = $transformer;
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
    public function supports($value): bool
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($value)) {
                return true;
            }
        }

        return false;
    }
}
