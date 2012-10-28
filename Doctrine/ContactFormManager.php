<?php
namespace Neutron\Widget\ContactFormBundle\Doctrine;

use Neutron\Widget\ContactFormBundle\Model\ContactFormManagerInterface;

use Neutron\ComponentBundle\Doctrine\AbstractManager;

class ContactFormManager extends AbstractManager implements ContactFormManagerInterface
{
    public function getQueryBuilderForContactFormManagementDataGrid()
    {
        return $this->repository->getQueryBuilderForContactFormManagementDataGrid();
    }
    
    public function getQueryBuilderForContactFormChoices()
    {
        return $this->repository->getQueryBuilderForContactFormChoices();
    }
}