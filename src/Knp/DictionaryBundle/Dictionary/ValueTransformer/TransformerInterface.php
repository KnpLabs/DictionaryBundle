<?php

namespace Knp\DictionaryBundle\Dictionary\ValueTransformer;

interface TransformerInterface
{
    public function supports($value);

    public function transform($value);
}
