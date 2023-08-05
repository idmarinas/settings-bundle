<?php

/**
 * This file is part of Bundle "Idm Settings Bundle".
 *
 * @see https://github.com/idmarinas/settings-bundle/
 *
 * @license https://github.com/idmarinas/settings-bundle/blob/master/LICENSE.txt
 *
 * @since 1.0.0
 */

namespace Idm\Bundle\Settings\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\Settings\Model\AbstractSettingDomain;

/**
 * @method SettingDomain|null find($id, $lockMode = null, $lockVersion = null)
 * @method SettingDomain|null findOneBy(array $criteria, array $orderBy = null)
 * @method SettingDomain[]    findAll()
 * @method SettingDomain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingDomainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractSettingDomain::class);
    }
}
