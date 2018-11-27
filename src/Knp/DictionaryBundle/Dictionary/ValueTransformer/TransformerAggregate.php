<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\ValueTransformer;

use Knp\DictionaryBundle\Dictionary\ValueTransformer;
use Knp\DictionaryBundle\ValueTransformer\Aggregate;

class TransformerAggregate implements ValueTransformer
{
    /**
     * @var Aggregate
     */
    private $transformer;

    public function __construct()
    {
        @trigger_error(
            sprintf(
                'Class %s is deprecated since version 2.2, to be removed in 3.0. Use %s instead.',
                __CLASS__,
                Aggregate::class
            ),
            E_USER_DEPRECATED
        );

        $this->transformer = new Aggregate();
    }

    public function addTransformer(ValueTransformer $transformer): void
    {
        $this->transformer->addTransformer($transformer);
    }

    public function supports($value): bool
    {
        return $this->transformer->supports($value);
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        return $this->transformer->transform($value);
    }
}
