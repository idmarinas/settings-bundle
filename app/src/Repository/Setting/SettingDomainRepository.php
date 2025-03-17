<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 16/03/2025, 19:02
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingDomainRepository.php
 * @date    16/03/2025
 * @time    18:54
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Repository\Setting;

use App\Entity\Setting\SettingDomain;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\Settings\Model\Repository\AbstractSettingDomainRepository;

class SettingDomainRepository extends AbstractSettingDomainRepository
{
	public function __construct (ManagerRegistry $registry)
	{
		parent::__construct($registry, SettingDomain::class);
	}
}
