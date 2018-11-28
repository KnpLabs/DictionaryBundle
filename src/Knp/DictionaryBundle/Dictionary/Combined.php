<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;

final class Combined implements Dictionary
{
    use Traits\Wrapper;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $dictionaries;

    public function __construct(string $name, array $dictionaries)
    {
        $this->dictionary = new Invokable($name, function () use ($dictionaries) {
            $data = [];

            foreach ($dictionaries as $dictionary) {
                $data = $this->merge($data, iterator_to_array($dictionary));
            }

            return $data;
        });
    }

    private function merge(array $array1, array $array2): array
    {
        if ($array1 === array_values($array1) && $array2 === array_values($array2)) {
            return array_merge($array1, $array2);
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
