<?php
namespace Neutron\Widget\ContactFormBundle\Controller\Frontend;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Neutron\Widget\ContactFormBundle\Model\ContactFormInterface;

use Symfony\Component\DependencyInjection\ContainerAware;

use Symfony\Component\HttpFoundation\Response;


class ContactFormController extends ContainerAware
{   
    public function renderAction(ContactFormInterface $widget = null)
    {   
        if (null === $widget || false === $widget->getEnabled() ||
                !$this->container->getParameter('neutron_contact_form.enable')){
            return  new Response();
        }
        
        $form = $this->container->get('form.factory')
            ->createNamed('contact_form', $widget->getForm());

        $template = $this->container->get('templating')
            ->render($widget->getTemplate(), array(
                'widget' => $widget,  
                'form' => $form->createView()  
            )
        );
    
        return  new Response($template);
    }
    
    public function handleAction($id)
    { 
        $manager = $this->container->get('neutron_contact_form.contact_form_manager');
        $widget = $manager->findOneBy(array('id' => $id, 'enabled' => true));
        
        if (null === $widget || 
                !$this->container->getParameter('neutron_contact_form.enable')){
            throw new NotFoundHttpException();
        }
        
        $form = $this->container->get('form.factory')
            ->createNamed('contact_form', $widget->getForm());
        
        $handler = $this->container->get('neutron_contact_form.form.frontend.handler.contact_form');
        $handler->setForm($form);
        $handler->setWidget($widget);
        $handler->process();
        
        return new Response(json_encode($handler->getResult()));
    }

}
