<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

interface ValueTransformer
{
    public function supports($value): bool;

    public function transform($value);
}
