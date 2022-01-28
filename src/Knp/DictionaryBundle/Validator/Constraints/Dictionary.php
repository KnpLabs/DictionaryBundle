<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class Dictionary extends Constraint
{
    /**
     * @var string
     *
     * @todo switch to native typehint after Symfony 4.4 compatibility was removed
     */
    public $name;

    public string $message = "The key {{ key }} doesn't exist in the given dictionary. {{ keys }} available.";

    public function validatedBy(): string
    {
        return DictionaryValidator::class;
    }

    /**
     * @return array<string>
     */
    public function getRequiredOptions(): array
    {
        return ['name'];
    }
}
