<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Faker\Provider;

use Faker\Generator;
use Faker\Provider\Base;
use Knp\DictionaryBundle\Dictionary\Collection;

final class Dictionary extends Base
{
    public function __construct(
        private readonly Collection $dictionaries,
        Generator $generator = null
    ) {
        if (!$generator instanceof Generator) {
            $generator = new Generator();
            $generator->addProvider($this);
        }

        parent::__construct($generator);
    }

    /**
     * @return mixed
     */
    public function dictionary(string $name)
    {
        return self::randomElement($this->dictionaries[$name]->getKeys());
    }
}
