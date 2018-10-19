<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary\ValueTransformer;

use Knp\DictionaryBundle\Dictionary\ValueTransformer;
use Knp\DictionaryBundle\ValueTransformer\Constant;

class ConstantTransformer implements ValueTransformer
{
    /**
     * @var Constant
     */
    private $transformer;

    public function __construct()
    {
        @trigger_error(
            sprintf(
                'Class %s is deprecated since version 2.2, to be removed in 3.0. Use %s instead.',
                __CLASS__,
                Constant::class
            ),
            E_USER_DEPRECATED
        );

        $this->transformer = new Constant();
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
