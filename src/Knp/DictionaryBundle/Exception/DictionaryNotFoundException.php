<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Exception;

final class DictionaryNotFoundException extends \Exception
{
    /**
     * @param string[] $knowns
     */
    public function __construct(string $dictionaryName, array $knowns = [], ?\Exception $exception = null)
    {
        $message = \sprintf('The dictionary "%s" has not been found in the registry.', $dictionaryName);

        if ([] !== $knowns) {
            $message .= \sprintf(' Known dictionaries are: "%s".', implode('", "', $knowns));
        }

        parent::__construct($message, 0, $exception);
    }
}
