<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Form\Type;

use Knp\DictionaryBundle\Dictionary\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<mixed>
 */
final class DictionaryType extends AbstractType
{
    public function __construct(private readonly Collection $collection) {}

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        $dictionaries = $this->collection;

        $choices = static function (Options $options) use ($dictionaries): array {
            $name    = $options['name'];
            $choices = $dictionaries[$name]->getValues();

            return array_flip($choices);
        };

        $optionsResolver
            ->setDefault('choices', $choices)
            ->setRequired(['name'])
            ->setAllowedValues('name', array_keys(iterator_to_array($this->collection)))
        ;
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
