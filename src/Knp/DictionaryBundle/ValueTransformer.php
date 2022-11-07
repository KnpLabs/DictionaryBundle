<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle;

interface ValueTransformer
{
    public function supports(mixed $value): bool;

    /**
     * @return mixed
     */
    public function transform(mixed $value);
}
