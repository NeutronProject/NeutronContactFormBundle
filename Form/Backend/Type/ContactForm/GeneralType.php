<?php
/*
 * This file is part of NeutronContactFormBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\ContactFormBundle\Form\Backend\Type\ContactForm;

use Symfony\Component\Form\FormView;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * Short description
 *
 * @author Zender <azazen09@gmail.com>
 * @since 1.0
 */
class GeneralType extends AbstractType
{
    
    protected $contactFormClass;
    
    protected $mailTemplates = array();
    
    protected $recipients = array();
    
    protected $formTypes = array();
    
    protected $templates = array();
    
    protected $translationDomain;
    
    public function setContactFormClass($contactFormClass)
    {   
        $this->contactFormClass = $contactFormClass;
    }
    
    public function setMailTemplates(array $mailTemplates)
    {
        $this->mailTemplates = $mailTemplates;
    }
    
    public function setRecipients(array $recipients)
    {
        $data = array();
        
        foreach ($recipients as $recipient){
            $data[$recipient] = $recipient;
        }
        
        $this->recipients = $data;
    }
    
    public function setFormTypes(array $formTypes)
    {
        $this->formTypes = $formTypes;
    }
    
    public function setTemplates(array $templates)
    {
        $this->templates = $templates;
    }
    
    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'form.title',
                'translation_domain' => $this->translationDomain
            ))
            ->add('mailSubject', 'text', array(
                'label' => 'form.mailSubject',
                'translation_domain' => $this->translationDomain
            ))
            ->add('mailTemplate', 'choice', array(
                'choices' => $this->mailTemplates,
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.mailTemplate',
                'empty_value' => 'form.empty_value',
                'translation_domain' => $this->translationDomain
            ))
            ->add('recipients', 'neutron_select_choice', array(
                'label' => 'form.recipients',
                'multiple' => true,
                'choices' => $this->recipients,
                'configs' => array('filter' => true),
                'translation_domain' => $this->translationDomain
            ))
            ->add('form', 'choice', array(
                'choices' => $this->formTypes,
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.form',
                'empty_value' => 'form.empty_value',
                'translation_domain' => $this->translationDomain
            ))
            ->add('template', 'choice', array(
                'choices' => $this->templates,
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.template',
                'empty_value' => 'form.empty_value',
                'translation_domain' => $this->translationDomain
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'form.enabled', 
                'value' => true,
                'required' => false,
                'attr' => array('class' => 'uniform'),
                'translation_domain' => $this->translationDomain
            ))

        ;
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->contactFormClass,
            'validation_groups' => function(FormInterface $form){
                return 'default';
            },
        ));
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'neutron_backend_contact_form_general';
    }
}