<?php

namespace Knp\DictionaryBundle\Faker\Provider;

use Faker\Generator;
use Faker\Provider\Base;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;

class Dictionary extends Base
{
    /**
     * @var DictionaryRegistry
     */
    private $dictionaries;

    public function __construct(
        DictionaryRegistry $dictionaries,
        Generator $generator = null
    ) {
        $this->dictionaries = $dictionaries;

        if (null === $generator) {
            $generator = new Generator();
            $generator->addProvider($this);
        }

        parent::__construct($generator);
    }

    public function dictionary(string $name)
    {
        return self::randomElement($this->dictionaries->get($name)->getKeys());
    }
}
