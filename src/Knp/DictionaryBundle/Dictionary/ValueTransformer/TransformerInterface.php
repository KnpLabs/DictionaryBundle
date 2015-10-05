<?php

namespace Knp\DictionaryBundle\Dictionary\ValueTransformer;

interface TransformerInterface
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function supports($value);

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function transform($value);
}
