<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

/**
 * @template E
 *
 * @extends Wrapper<E>
 */
final class Iterator extends Wrapper
{
    /**
     * @param \Traversable<mixed, E> $traversable
     */
    public function __construct(string $name, \Traversable $traversable)
    {
        parent::__construct(
            new Invokable(
                $name,
                static fn (): array => iterator_to_array($traversable)
            )
        );
    }
}
