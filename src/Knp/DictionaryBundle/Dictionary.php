<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * @template TKey of (int|string)
 * @template TValue
 *
 * @extends IteratorAggregate<TKey, TValue>
 * @extends ArrayAccess<TKey, TValue>
 */
interface Dictionary extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var string
     *
     * @deprecated
     */
    public const VALUE = 'value';

    /**
     * @var string
     *
     * @deprecated
     */
    public const VALUE_AS_KEY = 'value_as_key';

    /**
     * @var string
     *
     * @deprecated
     */
    public const KEY_VALUE = 'key_value';

    public function getName(): string;

    /**
     * @return array<int, TKey>
     */
    public function getKeys(): array;

    /**
     * @return array<int, TValue>
     */
    public function getValues(): array;
}
