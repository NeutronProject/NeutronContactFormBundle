<?php
/*
 * This file is part of NeutronContactFormBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\ContactFormBundle\Form\Frontend\Type;

use Symfony\Component\Validator\Constraints\Email;

use Symfony\Component\Validator\Constraints\MaxLength;

use Symfony\Component\Validator\Constraints\MinLength;

use Symfony\Component\Validator\Constraints\NotBlank;

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
abstract class AbstractContactType extends AbstractType
{
    
    protected $translationDomain = 'messages';
    
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
               'label' => 'form.name',
               'constraints' => array(
                   new NotBlank(array('message' => 'name.blank')), 
                   new MinLength(array('message' => 'name.min', 'limit' => 2)),
                   new MaxLength(array('message' => 'name.max', 'limit' => 255))
               ),
               'translation_domain' => $this->translationDomain
           ))
           ->add('email', 'text', array(
               'label' => 'form.email',
               'constraints' => array(
                   new NotBlank(array('message' => 'email.blank')),
                   new Email(array('message' => 'email.invalid')),
                   new MaxLength(array('message' => 'name.max', 'limit' => 255))
               ),
               'translation_domain' => $this->translationDomain
           ))
           ->add('content', 'textarea', array(
               'label' => 'form.content',
               'constraints' => array(
                   new NotBlank(array('message' => 'content.blank')),
                   new MinLength(array('message' => 'content.min', 'limit' => 2)),
               ),
               'translation_domain' => $this->translationDomain,       
           ))
           ->add('recaptcha', 'neutron_recaptcha', array(
               'label' => 'form.recaptcha',
               'translation_domain' => $this->translationDomain,
               'configs' => array('theme' => 'clean'),
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
            'csrf_protection' => false,
        ));
    }
    

}