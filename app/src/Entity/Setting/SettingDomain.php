<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 16/03/2025, 21:03
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingDomain.php
 * @date    16/03/2025
 * @time    17:43
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Entity\Setting;

use App\Repository\Setting\SettingDomainRepository;
use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\Settings\Model\Entity\AbstractSettingDomain;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/** Domain for settings of Symfony App */
#[ORM\Table(name: 'idm_settings_setting_domain')]
#[ORM\Entity(repositoryClass: SettingDomainRepository::class)]
#[UniqueEntity(fields: 'domain', message: 'domain.not_unique')]
class SettingDomain extends AbstractSettingDomain {}
