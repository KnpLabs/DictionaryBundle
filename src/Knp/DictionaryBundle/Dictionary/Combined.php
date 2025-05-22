<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;

/**
 * @template E
 *
 * @extends Wrapper<E>
 */
final class Combined extends Wrapper
{
    /**
     * @param Dictionary<E> ...$dictionaries
     */
    public function __construct(string $name, Dictionary ...$dictionaries)
    {
        parent::__construct(
            new Invokable($name, function () use ($dictionaries): array {
                $data = [];

                foreach ($dictionaries as $dictionary) {
                    $data = $this->merge($data, iterator_to_array($dictionary));
                }

                return $data;
            })
        );
    }

    /**
     * @param E[] $array1
     * @param E[] $array2
     *
     * @return E[]
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
