<?php
/*
 * This file is part of NeutronContactFormBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\ContactFormBundle\Entity\Repository;

use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class ContactFormRepository extends TranslationRepository
{
    public function getQueryBuilderForContactFormManagementDataGrid()
    {
        $qb = $this->createQueryBuilder('f');
        $qb->select('f.id, f.name, f.enabled');
        return $qb;
    }
    
    public function getQueryBuilderForContactFormChoices()
    {
        $qb = $this->createQueryBuilder('f');
        $qb
            ->where('f.enabled = ?1')
            ->orderBy('f.name', 'ASC')
            ->setParameters(array(1 => true))
        ;
        return $qb;
    }
}