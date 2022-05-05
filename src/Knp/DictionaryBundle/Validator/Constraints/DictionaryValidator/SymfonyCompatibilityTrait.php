<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Validator\Constraints\DictionaryValidator;

use Composer\InstalledVersions;
use Exception;
use Knp\DictionaryBundle\Validator\Constraints\Dictionary;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;

switch ($version = substr((string) InstalledVersions::getVersion('symfony/validator'), 0, 3)) {
    default:
        throw new Exception('knplabs/dictionary-bundle is not compatible with the current version of symfony/validator: '.$version);

    case '6.1':
    case '6.0':
        trait SymfonyCompatibilityTrait
        {
            public function validate(mixed $value, Constraint $constraint): void
            {
                if (!$constraint instanceof Dictionary) {
                    throw new UnexpectedTypeException($constraint, Dictionary::class);
                }

                if (null === $value || '' === $value) {
                    return;
                }

                $dictionary = $this->dictionaries[$constraint->name];
                $values     = $dictionary->getKeys();

                if (!\in_array($value, $values, true)) {
                    $this->context->addViolation(
                        $constraint->message,
                        [
                            '{{ key }}'  => $this->varToString($value),
                            '{{ keys }}' => implode(', ', array_map([$this, 'varToString'], $values)),
                        ]
                    );
                }
            }
        }

        break;

    case '5.4':
        trait SymfonyCompatibilityTrait
        {
            public function validate($value, Constraint $constraint): void
            {
                if (!$constraint instanceof Dictionary) {
                    throw new UnexpectedTypeException($constraint, Dictionary::class);
                }

                if (null === $value || '' === $value) {
                    return;
                }

                $dictionary = $this->dictionaries[$constraint->name];
                $values     = $dictionary->getKeys();

                if (!\in_array($value, $values, true)) {
                    $this->context->addViolation(
                        $constraint->message,
                        [
                            '{{ key }}'  => $this->varToString($value),
                            '{{ keys }}' => implode(', ', array_map([$this, 'varToString'], $values)),
                        ]
                    );
                }
            }
        }

        break;
}
