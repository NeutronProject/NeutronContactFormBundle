<?php

namespace Neutron\Widget\ContactFormBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NeutronContactFormExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        $this->loadGeneralConfigurations($configs, $container);
    }
    
    protected function loadGeneralConfigurations(array $config, ContainerBuilder $container)
    {
        
        if (false === $config['enable']){
            $container->getDefinition('neutron_contact_form.widget.')
                ->clearTag('neutron.widget');    
        }
        
        $container->setParameter('neutron_contact_form.widget.enable', $config['enable']);
        $container->setParameter('neutron_contact.contact_form_class', $config['class']);
        $container->setAlias('neutron_contact_form.contact_form_manager', $config['manager']);
        $container->setAlias('neutron_contact_form.controller.backend.contact_form', $config['controller_backend']);
        $container->setAlias('neutron_contact_form.controller.frontend.contact_form', $config['controller_frontend']);
        $container->setParameter('neutron_contact_form.datagrid.contact_form_management', $config['datagrid']);
       
        $container->setAlias('neutron_contact_form.form.backend.handler.contact_form', $config['form']['handler']);
        $container->setParameter('neutron_contact_form.form.backend.type.contact_form', $config['form']['type']);
        $container->setParameter('neutron_contact_form.form.backend.name.contact_form', $config['form']['name']);
        
        
        $container->setParameter('neutron_contact.contact_form_types', $config['form_types']);
        $container->setParameter('neutron_contact.templates', $config['templates']);
        
        $container->setParameter('neutron_contact_form.mail_recipients', $config['mail_recipients']);
        $container->setParameter('neutron_contact_form.mail_templates', $config['mail_templates']);
        $container->setAlias('neutron_contact_form.mailer', $config['mailer']);
        $container->setAlias('neutron_contact_form.form.frontend.handler.contact_form', $config['mail_handler']);
        $container->setParameter('neutron_contact_form.translation_domain', $config['translation_domain']);
        
    }
}
