<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle;

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
