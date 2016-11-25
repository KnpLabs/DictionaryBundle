<?php

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\Dictionary;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DictionaryBuildingPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass');
    }

    function it_builds_a_value_as_key_dictionary_form_the_config(ContainerBuilder $container)
    {
        $config = array(
            'dictionaries' => array(
                'dico1' => array(
                    'type'    => Dictionary::VALUE_AS_KEY,
                    'content' => array('foo', 'bar', 'baz'),
                ),
            ),
        );

        $container->getParameter('knp_dictionary.configuration')->willReturn($config);
        $container->setDefinition(
            'knp_dictionary.dictionary.dico1',
            Argument::that(function ($definition) {
                expect($definition->getClass())
                    ->toBe('Knp\DictionaryBundle\Dictionary')
                ;

                $factory = $definition->getFactory();

                expect($factory[0]->__toString())
                    ->toBe('knp_dictionary.dictionary.factory.factory_aggregate')
                ;

                expect($factory[1])
                    ->toBe('create')
                ;

                expect($definition->getArguments())
                    ->toBe(array('dico1', array(
                        'type'    => Dictionary::VALUE_AS_KEY,
                        'content' => array('foo', 'bar', 'baz'),
                    )))
                ;

                expect($definition->getTags())
                    ->toBe(array(DictionaryRegistrationPass::TAG_DICTIONARY => array(array())))
                ;

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_builds_a_value_dictionary_form_the_config(ContainerBuilder $container)
    {
        $config = array(
            'dictionaries' => array(
                'dico1' => array(
                    'type'    => Dictionary::VALUE,
                    'content' => array(2 => 'foo', 10 => 'bar', 100 => 'baz'),
                ),
            ),
        );

        $container->getParameter('knp_dictionary.configuration')->willReturn($config);
        $container->setDefinition(
            'knp_dictionary.dictionary.dico1',
            Argument::that(function ($definition) {
                expect($definition->getClass())
                    ->toBe('Knp\DictionaryBundle\Dictionary')
                ;

                $factory = $definition->getFactory();

                expect($factory[0]->__toString())
                    ->toBe('knp_dictionary.dictionary.factory.factory_aggregate')
                ;

                expect($factory[1])
                    ->toBe('create')
                ;

                expect($definition->getArguments())
                    ->toBe(array('dico1', array(
                        'type'    => Dictionary::VALUE,
                        'content' => array(2 => 'foo', 10 => 'bar', 100 => 'baz'),
                    )))
                ;

                expect($definition->getTags())
                    ->toBe(array(DictionaryRegistrationPass::TAG_DICTIONARY => array(array())))
                ;

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }

    function it_builds_a_key_value_dictionary_form_the_config(ContainerBuilder $container)
    {
        $config = array(
            'dictionaries' => array(
                'dico1' => array(
                    'type'    => Dictionary::KEY_VALUE,
                    'content' => array(2 => 'foo', 10 => 'bar', 100 => 'baz'),
                ),
            ),
        );

        $container->getParameter('knp_dictionary.configuration')->willReturn($config);
        $container->setDefinition(
            'knp_dictionary.dictionary.dico1',
            Argument::that(function ($definition) {
                expect($definition->getClass())
                    ->toBe('Knp\DictionaryBundle\Dictionary')
                ;

                $factory = $definition->getFactory();

                expect($factory[0]->__toString())
                    ->toBe('knp_dictionary.dictionary.factory.factory_aggregate')
                ;

                expect($factory[1])
                    ->toBe('create')
                ;

                expect($definition->getArguments())
                    ->toBe(array('dico1', array(
                        'type'    => Dictionary::KEY_VALUE,
                        'content' => array(2 => 'foo', 10 => 'bar', 100 => 'baz'),
                    )))
                ;

                expect($definition->getTags())
                    ->toBe(array(DictionaryRegistrationPass::TAG_DICTIONARY => array(array())))
                ;

                return true;
            })
        )->shouldBeCalled();

        $this->process($container);
    }
}
