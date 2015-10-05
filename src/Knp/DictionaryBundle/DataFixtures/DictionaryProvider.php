<?php

namespace Knp\DictionaryBundle\DataFixtures;

use Faker\Provider\Base as BaseProvider;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;

class DictionaryProvider extends BaseProvider
{
    /**
     * @var DictionaryRegistry
     */
    private $registry;

    /**
     * @param DictionaryRegistry $registry
     */
    public function __construct(DictionaryRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function dictionary($name)
    {
        $dictionary = $this->registry->get($name);

        return self::randomElement($dictionary->getKeys());
    }
}

