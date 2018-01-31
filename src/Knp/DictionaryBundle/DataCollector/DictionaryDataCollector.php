<?php

namespace Knp\DictionaryBundle\DataCollector;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class DictionaryDataCollector extends DataCollector
{
    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, Exception $exception = null)
    {
    }

    public function addDictionary($name, array $keys, array $values)
    {
        $this->data[$name] = array_map(function ($key, $value) {
            return ['key' => $key, 'value' => $value];
        }, $keys, $values);
    }

    /**
     * @return array
     */
    public function getDictionaries()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function reset()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dictionary';
    }
}
