<?php 
namespace Neutron\Widget\ContactFormBundle\Doctrine\EventSubscriber;

use Neutron\Widget\ContactFormBundle\Model\ContactFormInterface;

use Doctrine\ORM\Event\LifecycleEventArgs;

use Neutron\MvcBundle\Widget\WidgetInterface;

use Doctrine\ORM\Events;

use Doctrine\Common\EventSubscriber;

class WidgetContactFormEventSubscriber implements EventSubscriber
{
    protected $widget;
    
    public function __construct(WidgetInterface $widget)
    {
        $this->widget = $widget;
    }
    
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        
        if ($entity instanceof ContactFormInterface){
            $entity->setWidget($this->widget);
        }
    }
    
    public function getSubscribedEvents()
    {
        return array(Events::postLoad);
    }
    
}