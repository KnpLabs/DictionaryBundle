<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;

/**
 * @template TKey of (int|string)
 * @template TValue
 *
 * @extends Wrapper<TKey, TValue>
 */
final class Combined extends Wrapper
{
    /**
     * @param Dictionary<TKey, TValue> ...$dictionaries
     */
    public function __construct(string $name, Dictionary ...$dictionaries)
    {
        parent::__construct(
            new Invokable($name, function () use ($dictionaries) {
                $data = [];

                foreach ($dictionaries as $dictionary) {
                    $data = $this->merge($data, iterator_to_array($dictionary));
                }

                return $data;
            })
        );
    }

    /**
     * @param array<TKey, TValue> $array1
     * @param array<TKey, TValue> $array2
     *
     * @return array<TKey, TValue>
     */
    private function merge(array $array1, array $array2): array
    {
        if ($array1 === array_values($array1) && $array2 === array_values($array2)) {
            return [...$array1, ...$array2];
        }

        $data = [];

        foreach ([$array1, $array2] as $array) {
            foreach ($array as $key => $value) {
                $data[$key] = $value;
            }
        }

        return $data;
    }
}
