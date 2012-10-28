<?php
namespace Neutron\Widget\ContactFormBundle\DataGrid;

use Neutron\Widget\ContactFormBundle\Model\ContactFormManagerInterface;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Neutron\Bundle\DataGridBundle\DataGrid\FactoryInterface;

class ContactFormManagementDataGrid
{

    const IDENTIFIER = 'neutron_contact_form_management';
    
    protected $factory;
    
    protected $translator;
    
    protected $router;
    
    protected $manager;
    
    protected $translationDomain;
   

    public function __construct (FactoryInterface $factory, Translator $translator, Router $router, 
             ContactFormManagerInterface $manager, $translationDomain)
    {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->router = $router;
        $this->manager = $manager;
        $this->translationDomain = $translationDomain;
    }

    public function build ()
    {
        
        $dataGrid = $this->factory->createDataGrid(self::IDENTIFIER);
        $dataGrid
            ->setCaption(
                $this->translator->trans('grid.contact_form_management.title',  array(), $this->translationDomain)
            )
            ->setAutoWidth(true)
            ->setColNames(array(
                $this->translator->trans('grid.contact_form_management.name',  array(), $this->translationDomain),
                $this->translator->trans('grid.contact_form_management.enabled',  array(), $this->translationDomain),
            ))
            ->setColModel(array(
                array(
                    'name' => 'f.name', 'index' => 'f.name', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                   

                array(
                    'name' => 'f.enabled', 'index' => 'f.enabled', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                    'formatter' => 'checkbox',  'search' => true, 'stype' => 'select',
                    'searchoptions' => array('value' => array(
                        1 => $this->translator->trans('grid.enabled', array(), $this->translationDomain), 
                        0 => $this->translator->trans('grid.disabled', array(), $this->translationDomain), 
                    ))
                ), 

            ))
            ->setQueryBuilder($this->manager->getQueryBuilderForContactFormManagementDataGrid())
            ->setSortName('f.name')
            ->setSortOrder('asc')
            ->enablePager(true)
            ->enableViewRecords(true)
            ->enableSearchButton(true)
            ->enableAddButton(true)
            ->setAddBtnUri($this->router->generate('neutron_contact_form.backend.contact_form.update', array(), true))
            ->enableEditButton(true)
            ->setEditBtnUri($this->router->generate('neutron_contact_form.backend.contact_form.update', array('id' => '{id}'), true))
            ->enableDeleteButton(true)
            ->setDeleteBtnUri($this->router->generate('neutron_contact_form.backend.contact_form.delete', array('id' => '{id}'), true))
        ;

        return $dataGrid;
    }



}