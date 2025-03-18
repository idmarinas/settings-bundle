<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 22:50
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingUser.php
 * @date    16/03/2025
 * @time    18:41
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Entity\Setting;

use App\Entity\User\User;
use App\Repository\Setting\SettingUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\Settings\EntityListener\SettingListener;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;

#[ORM\Table(name: 'idm_settings_setting_user')]
#[ORM\Entity(repositoryClass: SettingUserRepository::class)]
#[ORM\UniqueConstraint(name: 'idm_settings_uniq_idx_setting_user', columns: ['domain_id', 'name', 'entity_id'])]
#[ORM\EntityListeners([SettingListener::class])]
#[ORM\HasLifecycleCallbacks]
class SettingUser extends AbstractSetting
{
	#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'settings')]
	protected ?User $entity = null;

	public function getEntity (): ?User
	{
		return $this->entity;
	}

	public function setEntity (?User $entity): self
	{
		$this->entity = $entity;

		return $this;
	}
}
