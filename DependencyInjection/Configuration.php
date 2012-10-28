<?php

namespace Neutron\Widget\ContactFormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neutron_contact_form');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
    
    private function addGeneralConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enable')->defaultFalse()->end()
                ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('controller_backend')->defaultValue('neutron_contact_form.controller.backend.contact_form.default')->end()
                ->scalarNode('controller_frontend')->defaultValue('neutron_contact_form.controller.frontend.contact_form.default')->end()
                ->scalarNode('manager')->defaultValue('neutron_contact_form.doctrine.contact_form_manager.default')->end()
                ->scalarNode('datagrid')->defaultValue('neutron_contact_form_management')->end()
                ->arrayNode('form_types')
                    ->useAttributeAsKey('name')
                        ->prototype('scalar')
                    ->end() 
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('mail_recipients')
                    ->useAttributeAsKey('name')
                        ->prototype('scalar')
                    ->end() 
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('mail_templates')
                    ->useAttributeAsKey('name')
                        ->prototype('scalar')
                    ->end() 
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('templates')
                    ->useAttributeAsKey('name')
                        ->prototype('scalar')
                    ->end() 
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('mailer')->defaultValue('neutron_contact_form.mailer.default')->end()
                ->scalarNode('mail_handler')->defaultValue('neutron_contact_form.form.frontend.handler.contact_form.default')->end()
                ->scalarNode('translation_domain')->defaultValue('NeutronContactFormBundle')->end()
            ->end()
        ;
    }
    
    private function addFormBackendConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('form_backend')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('type')->defaultValue('neutron_backend_contact_form')->end()
                            ->scalarNode('handler')->defaultValue('neutron_contact_form.form.backend.handler.contact_form.default')->end()
                            ->scalarNode('name')->defaultValue('neutron_backend_contact_form')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    

}
