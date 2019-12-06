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

    public function addTransformer(ValueTransformer $transformer): void
    {
        $this->transformers[] = $transformer;
    }

    public function transform($value)
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($value)) {
                return $transformer->transform($value);
            }
        }

        return $value;
    }

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
