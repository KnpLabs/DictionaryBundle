<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Faker\Provider;

use Faker\Generator;
use Faker\Provider\Base;
use Knp\DictionaryBundle\Dictionary\Collection;

class Dictionary extends Base
{
    /**
     * @var Collection
     */
    private $dictionaries;

    public function __construct(Collection $dictionaries, Generator $generator = null)
    {
        $this->dictionaries = $dictionaries;

        if (null === $generator) {
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
