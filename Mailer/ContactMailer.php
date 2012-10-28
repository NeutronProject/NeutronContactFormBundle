<?php
namespace Neutron\Widget\ContactFormBundle\Mailer;

use Neutron\Widget\ContactFormBundle\Model\ContactFormInterface;

use Symfony\Component\DependencyInjection\ContainerAware;

class ContactMailer extends ContainerAware implements ContactMailerInterface
{

    public function sendMessage(ContactFormInterface $widget, array $context)
    {
        $template = $this->container->get('twig')->loadTemplate($widget->getMailTemplate());
        $subject = $widget->getMailSubject();
        $htmlBody = $template->renderBlock('body_html', $context);
    
        $message = \Swift_Message::newInstance()
            ->setSubject($widget->getMailSubject())
            ->setFrom($context['email'], $context['name'])
            ->setTo($widget->getRecipients())
            ->setBody($htmlBody, 'text/html')
        ;
    
        $this->container->get('mailer')->send($message);
    }
}