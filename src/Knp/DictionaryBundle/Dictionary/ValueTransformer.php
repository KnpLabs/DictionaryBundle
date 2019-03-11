<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

interface ValueTransformer
{
    public function transform($argument1);
}
