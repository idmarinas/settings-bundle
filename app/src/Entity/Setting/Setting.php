<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/03/2025, 20:53
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    Setting.php
 * @date    16/03/2025
 * @time    17:41
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Entity\Setting;

use App\Repository\Setting\SettingRepository;
use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\Settings\EntityListener\SettingListener;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;

#[ORM\Table(name: 'idm_settings_setting')]
#[ORM\UniqueConstraint(name: 'idm_settings_uniq_idx__setting', columns: ['domain_id', 'name'])]
#[ORM\Entity(repositoryClass: SettingRepository::class)]
#[ORM\EntityListeners([SettingListener::class])]
#[ORM\HasLifecycleCallbacks]
class Setting extends AbstractSetting
{
	public const string ENTITY_NAME = 'setting';
}
