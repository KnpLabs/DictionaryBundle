<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Traversable;

/**
 * @template TKey of (int|string)
 * @template TValue
 *
 * @extends Wrapper<TKey, TValue>
 */
final class Iterator extends Wrapper
{
    /**
     * @param Traversable<TKey, TValue> $iterator
     */
    public function __construct(string $name, Traversable $iterator)
    {
        parent::__construct(
            new Invokable(
                $name,
                static fn (): array => iterator_to_array($iterator)
            )
        );
    }
}
