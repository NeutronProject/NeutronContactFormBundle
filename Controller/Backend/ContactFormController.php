<?php
namespace Neutron\Widget\ContactFormBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

class ContactFormController extends ContainerAware
{
    public function indexAction()
    {
        $datagrid = $this->container->get('neutron.datagrid')
            ->get($this->container->getParameter('neutron_contact_form.datagrid.contact_form_management'));
    
        $template = $this->container->get('templating')->render(
            'NeutronContactFormBundle:Backend\ContactForm:index.html.twig', array(
                'datagrid' => $datagrid,
                'translationDomain' => 
                    $this->container->getParameter('neutron_contact_form.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    public function updateAction($id)
    {   
        $form = $this->container->get('neutron_contact_form.form.backend.contact_form');
        $handler = $this->container->get('neutron_contact_form.form.backend.handler.contact_form');
        $form->setData($this->getData($id));

        if (null !== $handler->process()){
            return new Response(json_encode($handler->getResult()));
        }

        $template = $this->container->get('templating')->render(
            'NeutronContactFormBundle:Backend\ContactForm:update.html.twig', array(
                'form' => $form->createView(),
                'translationDomain' => 
                    $this->container->getParameter('neutron_contact_form.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    public function deleteAction($id)
    {      
        $entity = $this->getEntity($id);
    
        if ($this->container->get('request')->getMethod() == 'POST'){
            $this->container->get('neutron_contact_form.contact_form_manager')
                ->delete($entity, true);
            $redirectUrl = $this->container->get('router')
                ->generate('neutron_contact_form.backend.contact_form');
            return new RedirectResponse($redirectUrl);
        }
    
        $template = $this->container->get('templating')
            ->render('NeutronContactFormBundle:Backend\ContactForm:delete.html.twig', array(
                'entity' => $entity,
                'translationDomain' =>
                    $this->container->getParameter('neutron_contact_form.translation_domain')
            )
        );
    
        return  new Response($template); 
    }
    
    public function getData($id)
    {
        $entity = $this->getEntity($id);
        
        return array('general' => $entity);
    }
    
    protected function getEntity($id)
    {

        $manager = $this->container->get('neutron_contact_form.contact_form_manager');
        
        if ($id){
            $entity = $manager->findOneBy(array('id' => $id));
        } else {
            $entity = $manager->create();
        }
        
        if (!$entity){
            throw new NotFoundHttpException();
        }
        
        return $entity;
    }
}
