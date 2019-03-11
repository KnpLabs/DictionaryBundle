<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
use Traversable;

final class Iterator implements Dictionary
{
    use Traits\Wrapper;

    public function __construct(string $name, Traversable $iterator)
    {
        $this->dictionary = new Invokable($name, function () use ($iterator): array {
            return iterator_to_array($iterator);
        });
    }
}
