<?php
namespace Neutron\Widget\ContactFormBundle\Form\Backend\Handler;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class ContactFormHandler extends AbstractFormHandler
{    
    protected function onSuccess()
    {   
        $content = $this->form->get('general')->getData();
        $this->container->get('neutron_contact_form.contact_form_manager')->update($content, true);
    }
    
    protected function getRedirectUrl()
    {
        return $this->container->get('router')->generate('neutron_contact_form.backend.contact_form');
    }
}