<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * @template E
 * @extends IteratorAggregate<mixed, E>
 * @extends ArrayAccess<mixed, E>
 */
interface Dictionary extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var string
     */
    public const VALUE = 'value';

    /**
     * @var string
     */
    public const VALUE_AS_KEY = 'value_as_key';

    /**
     * @var string
     */
    public const KEY_VALUE = 'key_value';

    public function getName(): string;

    /**
     * @return mixed[]
     */
    public function getValues(): array;

    /**
     * @return mixed[]
     */
    public function getKeys(): array;
}
