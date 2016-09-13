<?php

namespace Knp\DictionaryBundle\DataCollector;

use Knp\DictionaryBundle\Dictionary\Dictionary;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class DictionaryDataCollector extends DataCollector
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
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = $this->registry->all();
    }

    /**
     * @return Dictionary[]
     */
    public function getDictionaries()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dictionary';
    }
}
