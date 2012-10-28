<?php
namespace Neutron\Widget\ContactFormBundle\Form\Frontend\Handler;

use Neutron\Widget\ContactFormBundle\Model\ContactFormInterface;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class ContactFormHandler extends AbstractFormHandler
{    
    
    protected $widget;
    
    public function setWidget(ContactFormInterface $widget)
    {
        $this->widget = $widget;
    }
    
    protected function onSuccess()
    {   
        $context = $this->form->getData();
        $contactMailer = $this->container->get('neutron_contact_form.mailer');
        $contactMailer->sendMessage($this->widget, $context);
    }
}