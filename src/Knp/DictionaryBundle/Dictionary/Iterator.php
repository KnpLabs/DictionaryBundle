<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Traversable;

final class Iterator extends Wrapper
{
    public function __construct(string $name, Traversable $iterator)
    {
        parent::__construct(
            new Invokable(
                $name,
                function () use ($iterator): array {
                    return iterator_to_array($iterator);
                }
            )
        );
    }
}
