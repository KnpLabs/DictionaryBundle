<?php

namespace Knp\DictionaryBundle\Dictionary;

interface ValueTransformer
{
    /**
     * @param mixed $value
     */
    public function supports($value): bool;

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function transform($value);
}
