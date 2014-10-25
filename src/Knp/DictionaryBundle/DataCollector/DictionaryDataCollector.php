<?php

namespace Knp\DictionaryBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\DictionaryBundle\Dictionary\DictionaryRegistry;

class DictionaryDataCollector implements DataCollectorInterface
{
    private $registry;

    public function __construct(DictionaryRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->dictionaries = $this->registry;
    }

    public function getName()
    {
        return 'dictionary';
    }
}
