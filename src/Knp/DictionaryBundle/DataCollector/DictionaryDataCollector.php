<?php

namespace Knp\DictionaryBundle\DataCollector;

use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

class DictionaryDataCollector implements DataCollectorInterface
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
        $this->dictionaries = $this->registry;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dictionary';
    }
}
