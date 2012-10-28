<?php
namespace Neutron\Widget\ContactFormBundle\Model;

interface ContactFormManagerInterface
{
    public function getQueryBuilderForContactFormManagementDataGrid();
    
    public function getQueryBuilderForContactFormChoices();
}

