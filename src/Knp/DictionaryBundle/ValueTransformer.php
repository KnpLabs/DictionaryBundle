<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle;

interface ValueTransformer
{
    public function supports($value): bool;

    public function transform($value);
}
