<?php

namespace Knp\DictionaryBundle\Dictionary;

interface Factory
{
    /**
     * @param array $config
     *
     * @return Dictionary
     */
    public function create($name, array $config);

    /**
     * @param array
     *
     * @return bool
     */
    public function supports(array $config);
}
