<?php
namespace Neutron\Widget\ContactFormBundle\Mailer;

use Neutron\Widget\ContactFormBundle\Model\ContactFormInterface;

interface ContactMailerInterface
{
    public function sendMessage(ContactFormInterface $widget, array $context);
}