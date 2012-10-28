<?php
namespace Neutron\Widget\ContactFormBundle;

use Neutron\MvcBundle\MvcEvents;

use Symfony\Component\Translation\TranslatorInterface;

use Neutron\MvcBundle\Event\ConfigureWidgetEvent;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Neutron\MvcBundle\Widget\WidgetFactoryInterface;

class ContactBlockWidget
{
    const IDENTIFIER = 'neutron.widget.contact_form';
    
    protected $dispatcher;
    
    protected $factory; 
    
    protected $translator;
    
    protected $translationDomain;

    public function __construct(EventDispatcherInterface $dispatcher, WidgetFactoryInterface $factory, 
        TranslatorInterface $translator, $translationDomain)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->translator = $translator;
        $this->translationDomain = $translationDomain;
    }
    
    public function build()
    {
        $widget = $this->factory->createWidget(self::IDENTIFIER);
        $widget
            ->setLabel($this->translator->trans('widget.contact_form.label', array(), $this->translationDomain))
            ->setDescription($this->translator->trans('widget.contact_form.desc', array(), $this->translationDomain))
            ->setForward('neutron_contact_block.controller.frontend.widget_contact_form:renderAction')
            ->addBackendPage(array(
                'name'      => 'widget.contact_block.management',
                'label'     => 'widget.contact_block.management.label',
                'route'     => 'neutron_contact_block.backend.widget_contact_block',
                'displayed' => true
            ))
        ;
        
        $this->dispatcher->dispatch(
            MvcEvents::onWidgetConfigure,
            new ConfigureWidgetEvent($this->factory, $widget)
        );
 
        return $widget;
    }
}